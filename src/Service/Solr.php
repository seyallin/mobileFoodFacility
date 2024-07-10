<?php

namespace App\Service;

use Psr\EventDispatcher\EventDispatcherInterface;
use Solarium\Client;
use Solarium\Core\Client\Adapter\AdapterInterface;
use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Solr {

  private Client $solr;

  private array $config;
  private AdapterInterface $adapter;

  private EventDispatcherInterface $eventDispatcher;

  public function __construct(private GeoApi $geoApi) {
    $this->config = [
      'endpoint' => [
        'localhost' => [
          'scheme' => 'http',
          'host' => '127.0.0.1',
          'port' => 8983,
          'path' => '/',
          'core' => 'mobile_food',
        ],
      ],
    ];
    $this->adapter = new Curl();
    $this->eventDispatcher = new EventDispatcher();
    $this->solr = new Client($this->adapter, $this->eventDispatcher, $this->config);
  }

  /**
   * Get solr client.
   *
   * @return \Solarium\Client
   *   The solr client.
   */
  public function getClient() {
    return $this->solr;
  }

  /**
   * Indexing data to solr.
   *
   * @param array $data
   *   Array of documents data
   *
   * @return int|null
   *   Result indexing status.
   */
  public function index($data) {
    $update = $this->getClient()->createUpdate();

    $documents = [];
    foreach ($data as $item) {
      $documents[] = $update->createDocument($item);
    }
    $update->addDocuments($documents);
    $update->addCommit();
    return $this->getClient()->update($update)->getStatus();
  }

  /**
   * Delete all indexes.
   *
   * @return int|null
   * Result status.
   */
  public function deleteAll() {
    $update = $this->getClient()->createUpdate();
    $update->addDeleteQuery('!Status:EXPIRED');
    $update->addCommit();
    return $this->getClient()->update($update)->getStatus();
  }

  public function search($address) {
    $query = $this->getClient()->createSelect();
    $query->setRows(1000);
    //$query->setSorts();
    if (empty($address)) {
      $query->setQuery('!Status:EXPIRED');
    }
    else {
      $geocode = $this->geoApi->getData($address);
      if (empty($geocode)) {
        return [];
      }
      else {
        $geocode  = reset($geocode);
      }
      $query->setQuery('!Status:EXPIRED');
      $helper = $query->getHelper();
      $query->createFilterQuery('Location')
        ->setQuery($helper
          ->geofilt('Location', $geocode['lat'], $geocode['lon'], 0.5));

    }

    $result = $this->getClient()->select($query);
    $docs = $result->getDocuments();
    return $docs;
  }



}