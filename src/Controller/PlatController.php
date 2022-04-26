<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\PanierRepository;
use App\Repository\PlatRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    /**
     * @Route("/plat", name="app_plat")
     */
    public function index(): Response
    {
        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }
    /**
     * @Route("/affpClassfront", name="affpClassfront")
     */

    public function afficherF(PlatRepository $repository)
    {
        $plattt = $repository->findAll();
        return $this->render('plat/AfficherFront.html.twig', ['plat' => $plattt]);

    }
    /**
     * @Route("/show/{id}", name="showCategorie")
     */
    public function ShowStuByClass(PlatRepository $repClass, PanierRepository $repStu, $id)
    {
        $pp=$repClass->find($id);
        $oo=$repStu->list($pp->getIdplat());
        return $this->render('plat/Show.html.twig', array(
            "plat" => $pp,
            "panier"=>$oo));
    }

}
