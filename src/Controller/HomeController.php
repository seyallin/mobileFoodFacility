<?php

namespace App\Controller;

use App\Form\MobileFoodListType;
use App\Service\Solr;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Home page controller.
 */
class HomeController extends AbstractController
{

  /**
   * Index page router.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Request object
   * @param \App\Service\Solr $solr
   *   Solr service.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Response data.
   */
  #[Route('/', name: 'app_home')]
  public function index(Request $request, Solr $solr): Response
  {

    $form = $this->createForm(MobileFoodListType::class);
    $form->handleRequest($request);
    $data = $form->getData() ?? [];
    $search = $data['search'] ?? '';
    return $this->render('home/index.html.twig', [
      'controller_name' => 'HomeController',
      'mobile_list' => $solr->search($search),
      'form' => $this->createForm(MobileFoodListType::class),
    ]);
  }
}
