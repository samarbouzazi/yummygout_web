<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryController extends AbstractController
{
    /**
     * @Route("/delivery", name="app_delivery")
     */
    public function index(): Response
    {
        return $this->render('delivery/index.html.twig', [
            'controller_name' => 'DeliveryController',
        ]);
    }
}
