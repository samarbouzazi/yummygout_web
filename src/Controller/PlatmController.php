<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Platt;
use App\Form\CategoriesType;
use App\Form\PlatType;
use App\Repository\CategorieRepository;
use App\Repository\PlatmRepository;
use App\Repository\PlattRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class PlatmController extends AbstractController
{
    /**
     * @Route("/platt", name="app_platt")
     */
    public function index(): Response
    {
        return $this->render('platt/index.html.twig', [
            'controller_name' => 'PlattController',
        ]);
    }

    /**
     * @Route("/affpClass1", name="affpClass1")
     */

    public function afficher(PlatmRepository $repository)
    {
        $plattt = $repository->findAll();
        return $this->render('categorie/Show.html.twig', ['plat' => $plattt]);

    }







}
