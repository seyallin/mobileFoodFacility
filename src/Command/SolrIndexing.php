<?php

namespace App\Command;

use App\Service\MobileFood;
use App\Service\Solr;
use League\Csv\Reader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Solr indexing command.
 */
#[AsCommand(
  name:'solr:indexing',
  description: 'Solr indexing command.',
  hidden: false,
  aliases: ['solr:indexing']
)]
class SolrIndexing extends Command {

  public function __construct(private Solr $solr, private MobileFood $mobileFood) {
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
      $output->writeln('Indexing row: ' . $i);
    }

    $output->writeln('total rows: ' . count($records));
    return Command::SUCCESS;
  }

}