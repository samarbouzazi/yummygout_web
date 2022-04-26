<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{
    /**
     * @Route("/favoris", name="app_favoris")
     */
    public function index(): Response
    {
        return $this->render('favoris/index.html.twig', [
            'controller_name' => 'FavorisController',
        ]);
    }
}
