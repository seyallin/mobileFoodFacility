<?php

namespace App\Controller;

use App\Form\MobileFoodListType;
use App\Service\MobileFood;
use App\Service\Solr;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
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
