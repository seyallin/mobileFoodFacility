<?php

namespace  App\Component\RequestBuilder;

use Solarium\Component\RequestBuilder\ComponentRequestBuilderInterface;
use Solarium\Core\Client\Request;
use Solarium\Core\ConfigurableInterface;

class SpatialFixBuilder implements ComponentRequestBuilderInterface {

  /**
   * @inheritDoc
   */
  public function buildComponent(ConfigurableInterface $component, Request $request): Request {
    $request->addParam('spatial', 'true');
    $request->addParam('spatial.sfield', $component->getField());
    $request->addParam('spatial.pt', $component->getPoint());
    $request->addParam('spatial.d', $component->getDistance());

    return $request;
  }

}