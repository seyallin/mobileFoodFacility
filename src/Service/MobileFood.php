<?php

namespace App\Service;

class MobileFood {

  /**
   * Data url string.
   *
   * @var string
   */
  private string $dataUrl;

  /**
   * Geocode service url string.
   * @var string
   */
  private string $geocodeUrl;

  /**
   * MobileFood service controller.
   *
   * @param \App\Service\JsonData $client
   *   Curl client
   * @param \App\Service\Solr
   *   Solr service.
   */
  public function __construct(
    private JsonData $client
  ) {
    $this->dataUrl = 'https://data.sfgov.org/api/id/rqzj-sfat.json';
    $this->geocodeUrl = 'https://geocode.maps.co/search?api_key=668d7134a876b190532998bscb57b46';
  }

  /**
   * Get all mobile food places.
   *
   * @return mixed
   * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
   */
  public function getAll() {
    // TODO: add caching.
    $data = $this->client->getData($this->dataUrl);
    return $data;
  }

  /**
   * Get single place.
   *
   * @param $id
   *   Place id.
   *
   * @return false|mixed
   * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
   */
  public function get($id) {
    // TODO: add caching.
    $data = $this->client->getData($this->dataUrl . '?objectid=' . $id);
    return reset($data);
  }

}