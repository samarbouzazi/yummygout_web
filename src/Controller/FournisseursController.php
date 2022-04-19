<?php

namespace App\Controller;


use App\Entity\Fournisseurs;
use App\Form\FournisseursType;
use App\Repository\FournisseursRepository;
use App\Repository\StocksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class FournisseursController extends Controller
{
    /**
     * @Route("/fournisseurs", name="app_fournisseurs")
     */
    public function index(): Response
    {
        return $this->render('fournisseurs/index.html.twig', [
            'controller_name' => 'FournisseursController',
        ]);
    }

    /**
     * @Route("/aff", name="aff")
     */

    public function afficher(FournisseursRepository $repository, Request $request):Response
    {
        $allfour = $repository->findAll();
        $four = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $allfour,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('fournisseurs/Affiche.html.twig', ['four' => $four]);

    }
    /**
     * @Route ("/delete/{id}",name="delete")
     */
    public function supprimer($id, FournisseursRepository $repository)
    {
        $four = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($four);
        $em->flush();

        return $this->redirectToRoute('aff');
    }
    /**
     * @Route ("/fournisseur/add",name="add")
     */

    public function add(Request $request)
    {
        $four = new Fournisseurs();
        $form = $this->createForm(FournisseursType::class, $four);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($four);
            $em->flush();
            return $this->redirectToRoute('aff');
        }
        return $this->render('fournisseurs/Add.html.twig', [
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route ("/fournisseurs/update/{id}",name="update")
     */
    public function update(FournisseursRepository $repository, $id, Request $request)
    {
        $four = $repository->find($id);
        $form = $this->createForm(FournisseursType::class, $four);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("aff");
        }
        return $this->render('fournisseurs/update.html.twig', [
            'formu' => $form->createView()
        ]);
    }
    /**
     * @Route("fournisseurs/rechlike", name="rechlike")
     */
    public function rechercherlike(FournisseursRepository  $repository, Request $request): Response
    {
        $nscrech = $request->get('search');
        $forunisseur = $repository->SearchNSC($nscrech);

        return $this->render('fournisseurs/Affiche.html.twig',
            ['four' => $forunisseur]);

    }


    /**
     * @Route("/show/{id}", name="showFournisseur")
     */
    public function ShowStuByClass(FournisseursRepository $repF, StocksRepository $repS, $id)
    {

        $four=$repF->find($id);
        $sto=$repS->listStobyfour($four->getIdf());

        return $this->render('fournisseurs/Show.html.twig', array(
            "four" => $four,
            "stos"=>$sto));
    }
    /**
     * @Route("fournisseurs/trin", name="trin")
     */
    public function OrderByNom(FournisseursRepository $repository,Request $request,PaginatorInterface $paginator)
    {
        $student = $repository->orderByNom();
        // Paginate the results of the query
        $four = $paginator->paginate(
        // Doctrine Query, not results
            $student,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('fournisseurs/Affiche.html.twig',
            ['four' => $four]);
    }

    /**
     * @Route("fournisseurs/trip", name="trip")
     */
    public function OrderByPrenom(FournisseursRepository $repository,Request $request,PaginatorInterface $paginator)
    {
        $student = $repository->orderByPrenom();
        // Paginate the results of the query
        $four = $paginator->paginate(
        // Doctrine Query, not results
            $student,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('fournisseurs/Affiche.html.twig',
            ['four' => $four]);
    }
    /**
     * @Route("fournisseurs/trie", name="trie")
     */
    public function OrderByEmail(FournisseursRepository $repository,Request $request,PaginatorInterface $paginator)
    {
        $student = $repository->orderByEmail();
        $four = $paginator->paginate(
        // Doctrine Query, not results
            $student,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('fournisseurs/Affiche.html.twig',
            ['four' => $four]);
    }
    /**
     * @Route("fournisseurs/tric", name="tric")
     */
    public function OrderByCateg(FournisseursRepository $repository,Request $request,PaginatorInterface $paginator)
    {
        $student = $repository->orderByCateg();
        $four = $paginator->paginate(
        // Doctrine Query, not results
            $student,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('fournisseurs/Affiche.html.twig',
            ['four' => $four]);
    }
    /**
     * @Route("/trit", name="trit")
     */
    public function OrderBytel(FournisseursRepository $repository,Request $request,PaginatorInterface $paginator)
    {
        $student = $repository->orderBytel();
        $four = $paginator->paginate(
        // Doctrine Query, not results
            $student,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('fournisseurs/Affiche.html.twig',
            ['four' => $four]);
    }

}
