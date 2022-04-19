<?php

namespace App\Controller;

use App\Entity\Lignecommande;
use App\Form\LignecommandeType;
use App\Repository\LignecommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LigneCommandeController extends AbstractController
{
    /**
     * @Route("/ligne/commande", name="app_ligne_commande")
     */
    public function index(): Response
    {
        return $this->render('ligne_commande/index.html.twig', [
            'controller_name' => 'LigneCommandeController',
        ]);
    }
    /**
     * @param LignecommandeRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ligne_commande/AfficheL" , name="AfficheL")
     */
    public function Affiche(LignecommandeRepository $repository){

        $ligne_commande=$repository->findAll();
        return $this->render('ligne_commande/AfficheL.html.twig',['lignecommande'=>$ligne_commande]);

    }
    /**
     * @Route("/Suppl/{id}" ,  name="suppl")
     */
    public function Delete( Lignecommande $lc):Response{

        $em=$this->getDoctrine()->getManager();
        $em->remove($lc);
        $em->flush();
        return $this->redirectToRoute('AfficheL');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Lignecommande/ddl",name="ddl")
     */
    function Add(\Symfony\Component\HttpFoundation\Request $request , LignecommandeRepository $repository){
        $lc=new Lignecommande();
        $form=$this->createForm(LignecommandeType::class , $lc);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        $var=$repository->findOneBy(['idpanier' => ($lc->getIdpanier())]);
        if($form->isSubmitted() && $form ->isValid()&& !$var ){
            $em=$this->getDoctrine()->getManager();
            $em->persist($lc);
            $em->flush();
            return $this->redirectToRoute('AfficheL');
        }
        elseif ($var) {
            $this->addFlash(
                'info',
                'Ligne commande déja existe'
            );
        }
        return $this->render('ligne_commande/ddl.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("Lignecommande/Updatel/{id}",name="updatel")
     */
    function Update(LignecommandeRepository $repository, $id , \Symfony\Component\HttpFoundation\Request $request){
        $lc=$repository->find($id);
        $form=$this->createForm(LignecommandeType::class,$lc);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form ->isValid() ){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheL");


        }

        return $this->render('ligne_commande/updateL.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }
}
