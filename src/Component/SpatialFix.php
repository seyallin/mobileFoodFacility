<?php

namespace App\Component;

use App\Component\RequestBuilder\SpatialFixBuilder;
use Solarium\Component\RequestBuilder\ComponentRequestBuilderInterface;
use Solarium\Component\Spatial;

class SpatialFix extends Spatial {

  public function getRequestBuilder(): ComponentRequestBuilderInterface {
    return new SpatialFixBuilder();
  }

}