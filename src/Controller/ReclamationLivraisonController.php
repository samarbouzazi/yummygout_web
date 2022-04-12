<?php

namespace App\Controller;

use App\Entity\Reclamantionlivraison;
use App\Repository\ReclamantionlivraisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReclamantionlivraisonType;


class ReclamationLivraisonController extends AbstractController
{
    /**
     * @Route("/reclamation/livraison", name="app_reclamation_livraison")
     */
    public function index(): Response
    {
        return $this->render('reclamation_livraison/index.html.twig', [
            'controller_name' => 'ReclamationLivraisonController',
        ]);
    }
    /**
     * @param  ReclamantionlivraisonRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("reclamationlivraison/AfficheR", name="AfficheR")
     */
    public function Affichel(ReclamantionlivraisonRepository $repository){
        $reclamationlivraison=$repository->findAll();
        return $this->render('reclamation_livraison/AfficheR.html.twig', ['reclamationlivraison'=>$reclamationlivraison]);
    }

    /**
     * @Route("/SuppReclivraison/{id}", name="SuppReclivraison")
     */
    function Delete( Reclamantionlivraison $reclivraison):Response
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($reclivraison);
        $em->flush();
        return $this->redirectToRoute('AfficheR');
    }
    /**
     * @Route("/AjouterReclivraison", name="AjouterReclivraison")
     */
    function Add( Request $request, ReclamantionlivraisonRepository $repository):Response
    {
        $Reclamantionlivraison=new Reclamantionlivraison();
        $form=$this->createForm(ReclamantionlivraisonType::class, $Reclamantionlivraison);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        $var=$repository->findOneBy(['idLivraison' => ($Reclamantionlivraison->getIdLivraison())]);
        if($form->isSubmitted()&& $form->isValid() && !$var){
            $em=$this->getDoctrine()->getManager();
            $em->persist($Reclamantionlivraison);
            $em->flush();
            $this->addFlash(
                'info',
                'ajouté avec succés'
            );
            return $this->redirectToRoute('AfficheR');
        }elseif ($var){
            $this->addFlash(
                'info',
                'vous avez ajouté une réclamation pour cette livraison déjà'
            );
        }
        return $this->render('reclamation_livraison/AddReclivraison.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("Reclivraison/UpdateR/{id}",name="updateR")
     */
    function update(ReclamantionlivraisonRepository $repository, $id, Request $request){
        $reclivraison=$repository->find($id);
        $form=$this->createForm(ReclamantionlivraisonType::class,$reclivraison);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheR");
        }
        return $this->render('reclamation_livraison/UpdateR.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param  ReclamantionlivraisonRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("reclamationlivraison/Affichebackrec", name="Afficheb")
     */
    public function Affichebackrec(ReclamantionlivraisonRepository $repository){
        $reclamationlivraison=$repository->findAll();
        return $this->render('reclamation_livraison/ReclamationBack.html.twig', ['reclamationlivraison'=>$reclamationlivraison]);
    }
}
