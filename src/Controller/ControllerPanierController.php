<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\Panier1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/controller/panier")
 */
class ControllerPanierController extends AbstractController
{
    /**
     * @Route("/", name="app_controller_panier_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();

        return $this->render('controller_panier/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    /**
     * @Route("/new", name="app_controller_panier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $form = $this->createForm(Panier1Type::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_controller_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('controller_panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idpanier}", name="app_controller_panier_show", methods={"GET"})
     */
    public function show(Panier $panier): Response
    {
        return $this->render('controller_panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/{idpanier}/edit", name="app_controller_panier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Panier1Type::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_controller_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('controller_panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idpanier}", name="app_controller_panier_delete", methods={"POST"})
     */
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getIdpanier(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_controller_panier_index', [], Response::HTTP_SEE_OTHER);
    }
}
