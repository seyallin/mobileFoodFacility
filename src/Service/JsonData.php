<?php

namespace App\Service;

use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * Service for Json data mapping.
 */
class JsonData {

  /**
   * Curl client.
   *
   * @var \Symfony\Component\HttpClient\CurlHttpClient
   */
  private CurlHttpClient $client;

  /**
   * Constructor method.
   */
  public function __construct() {
    $this->client = new CurlHttpClient([
      'headers' => [
        'Accept' => 'application/json',
      ]
    ]);
  }

  /**
   * Get data by URl.
   *
   * @param $url
   *   Url.
   *
   * @return mixed
   * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
   */
  public function getData($url) {
    $response = $this->client->request('GET', $url);
    $data = json_decode($response->getContent(), TRUE);
    return $data;
  }

}