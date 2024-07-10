<?php

namespace App\Command;

use App\Service\MobileFood;
use App\Service\Solr;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Solr indexing command.
 */
#[AsCommand(
  name: 'solr:indexing',
  description: 'Solr indexing command.',
  aliases: ['solr:indexing'],
  hidden: false
)]
class SolrIndexing extends Command {

  /**
   * Constructor for solr command.
   *
   * @param \App\Service\Solr $solr
   *   Solr service.
   * @param \App\Service\MobileFood $mobileFood
   *   MobileFood service.
   */
  public function __construct(private readonly Solr $solr, private readonly MobileFood $mobileFood) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $this->solr->deleteAll();
    $records = $this->mobileFood->getAll();
    $data = [];
    // Batching rows by 10 items in indexing.
    foreach ($records as $i => $row) {
      if ($i % 10 === 0 && $i > 0) {
        $this->solr->index($data);
        $data = [];
        $output->writeln('Indexing row: ' . $i);
      }
      $location = ($row['latitude'] ?? 0) . ',' . ($row['longitude'] ?? 0);
      $data[] =[
        'id' => $row['objectid'],
        'Applicant' => $row['applicant'] ?? '',
        'FacilityType' => $row['facilitytype'] ?? '',
        'Address' => $row['address'] ?? '',
        'Status' => $row['status'] ?? '',
        'FoodItems' => $row['fooditems'] ?? '',
        'Location' => $location,
      ];
    }
    if (!empty($data)) {
      $this->solr->index($data);
    }

    $output->writeln('total rows: ' . count($records));
    return Command::SUCCESS;
  }

}