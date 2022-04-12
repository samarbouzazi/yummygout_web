<?php

namespace App\Controller;

use App\Entity\Fournisseurs;
use App\Entity\Stocks;
use App\Form\FournisseursType;
use App\Form\StocksType;
use App\Repository\StocksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StocksController extends AbstractController
{
    /**
     * @Route("/stocks", name="app_stocks")
     */
    public function index(): Response
    {
        return $this->render('stocks/index.html.twig', [
            'controller_name' => 'StocksController',
        ]);
    }

    /**
     * @Route("/affS", name="affS")
     */

    public function afficheS(StocksRepository $repository)
    {
        $sto = $repository->findAll();
        return $this->render('stocks/AfficheS.html.twig', ['sto' => $sto]);

    }
    /**
     * @Route ("/Stocks/adds",name="adds")
     */

    public function add(Request $request)
    {
        $sto = new Stocks();
        $form = $this->createForm(StocksType::class, $sto);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sto);
            $em->flush();
            return $this->redirectToRoute('affS');
        }
        return $this->render('stocks/Add.html.twig', [
            'formS' => $form->createView()
        ]);

    }

    /**
     * @Route ("/stocks/updateS/{id}",name="updateS")
     */
    public function updateS(StocksRepository $repository, $id, Request $request)
    {
        $sto = $repository->find($id);
        $form = $this->createForm(StocksType::class, $sto);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affS");
        }
        return $this->render('stocks/updateS.html.twig', [
            'formS' => $form->createView()
        ]);
    }

    /**
     * @Route ("/deletes/{id}",name="deletes")
     */
    public function supprimer($id, StocksRepository $repository)
    {
        $sto = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($sto);
        $em->flush();

        return $this->redirectToRoute('affS');
    }
}
