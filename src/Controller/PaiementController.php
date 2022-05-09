<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement", name="app_paiement")
     */
    public function index(): Response
    {
        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }
    /**
     * @param PaiementRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/paiement/Affichepp" , name="Affichepp")
     */
    public function Affiche( PaiementRepository  $repository){

        $paiement=$repository->findAll();
        return $this->render('/paiement/Affichepp.html.twig',['paiement'=>$paiement]);

    }
    /**
     * @Route("/suppppp/{idpaiement}" ,  name="suppppp")
     */
    public function Delete( Paiement $paiement):Response{
        $em=$this->getDoctrine()->getManager();
        $em->remove($paiement);
        $em->flush();
        $this->addFlash(
            'info',
            'Supprimé avec succés'
        );
        return $this->redirectToRoute('Affichepp');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/paiement/addpai",name="addpai")
     */
    function Add(\Symfony\Component\HttpFoundation\Request $request , PaiementRepository $repository){
        $pai=new Paiement();
        $form=$this->createForm(PaiementType::class , $pai);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        $var=$repository->findOneBy(['idpanier' => ($pai->getIdpanier())]);
        if($form->isSubmitted() && $form ->isValid() && !$var){
            $em=$this->getDoctrine()->getManager();
            $em->persist($pai);
            $em->flush();
            $this->addFlash(
                'info',
                'ajouté avec succés'
            );
            return $this->redirectToRoute('Affichepp');
        }
        elseif ($var) {
            $this->addFlash(
                'info',
                ' commande déja payée'
            );
        }
        return $this->render('/paiement/addpai.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("paiement/Update/{id}",name="updatepp")
     */
    function Update(PaiementRepository $repository, $id , \Symfony\Component\HttpFoundation\Request $request){
        $paiement=$repository->find($id);
        $form=$this->createForm(PaiementType::class,$paiement);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form ->isValid()  ){
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'info',
                'Paiement Modifié'
            );
            return $this->redirectToRoute("Affichepp");
        }

        return $this->render('paiement/updatepp.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }
}
