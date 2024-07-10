<?php

namespace App\Controller;

use App\Service\MobileFood;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MobileFoodDetailsController extends AbstractController
{
    #[Route('/mobile_food/{id}', name: 'app_mobile_food_details')]
    public function index($id, MobileFood $mobileFood): Response
    {
      $item = $mobileFood->get($id);
      if (empty($item)) {
        throw $this->createNotFoundException('The product does not exist');
      }
      return $this->render('mobile_food_details/index.html.twig', [
          'controller_name' => 'MobileFoodDetailsController',
        'item' => $mobileFood->get($id),
      ]);
    }
}
