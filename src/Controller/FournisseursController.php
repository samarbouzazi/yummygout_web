<?php

namespace App\Controller;


use App\Entity\Fournisseurs;
use App\Form\FournisseursType;
use App\Repository\FournisseursRepository;
use App\Repository\StocksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FournisseursController extends AbstractController
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

    public function afficher(FournisseursRepository $repository)
    {
        $four = $repository->findAll();
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
        //$classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $four=$repF->find($id);
        $sto=$repS->listStobyfour($four->getIdf());
        //1 method:list of Students
        //$students=$classroom->getStudents();
        //2 method: from repository
        //$students= $this->getDoctrine()->getRepository(Student::class)->listStudentByClass($classroom->getId());
        return $this->render('fournisseurs/Show.html.twig', array(
            "fours" => $four,
            "stos"=>$sto));
    }



}
