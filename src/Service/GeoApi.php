<?php

namespace App\Service;

/**
 * Service for Json data mapping.
 */
class GeoApi {

  /**
   * Api string.
   *
   * @var string
   */
  private $api = 'https://geocode.maps.co/search?api_key=668d7134a876b190532998bscb57b46';

  /**
   * GeoAPi constructor.
   *
   * @param \App\Service\JsonData $client
   *   Json data service.
   */
  public function __construct(private JsonData $client) {
  }

  /**
   * Get data by URl.
   *
   * @param string $address
   *   Address string.
   *
   * @return mixed
   * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
   */
  public function getData($address) {
    $url = $this->api . '&q=' . $address;
    $data = $this->client->getData($url);
    return $data;
  }

}