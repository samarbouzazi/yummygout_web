<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivraisonController extends AbstractController
{
    /**
     * @Route("/livraison", name="app_livraison")
     */
    public function index(): Response
    {
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'LivraisonController',
        ]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("livraison/Affichel", name="Affichel")
     */
    public function Affichel(LivraisonRepository $repository){
        $livraison=$repository->findAll();
        return $this->render('livraison/Affichel.html.twig', ['livraison'=>$livraison]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("livraison/Affichefront", name="Affichefrontlivraison")
     */
    public function Affichefrontlivraison(LivraisonRepository $repository){
        $livraison=$repository->findAll();
        return $this->render('livraison/Affichelivraisonfront.html.twig', ['livraison'=>$livraison]);
    }
    /**
     * @Route("/Supplivraison/{id}", name="Supplivraison")
     */
    function Delete( Livraison $livraison):Response
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($livraison);
        $em->flush();
        return $this->redirectToRoute('Affichel');
    }
    /**
     * @Route("/Ajouterlivraison", name="Ajouterlivraison")
     */
    function Add( Request $request, LivraisonRepository $repository):Response
    {
        $randomNumber = rand(100001, 999999);
        $livraison=new livraison();
        $livraison->setReflivraison($randomNumber);
        $form=$this->createForm(LivraisonType::class, $livraison);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        $var=$repository->findOneBy(['idpanier' => ($livraison->getIdpanier())]);
        if($form->isSubmitted()&& $form->isValid() && !$var){
            $em=$this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            $this->addFlash(
                'info',
                'ajouté avec succés'
            );
            return $this->redirectToRoute('Affichel');
        }elseif ($var){
                $this->addFlash(
                    'alerte',
                    'Vérifier l existance de cette livraison déjà '
                );
            }
        return $this->render('livraison/Addlivraison.html.twig',[
            'form'=>$form->createView()
        ]);}

    /**
     * @Route("livraison/Update/{id}",name="update")
     */
    function update(LivraisonRepository $repository, $id, Request $request){
        $livraison=$repository->find($id);
        $form=$this->createForm(LivraisonType::class,$livraison);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                'info',
                'Modifié avec succés'
            );
            return $this->redirectToRoute("Affichel");
        }
        return $this->render('livraison/Updatel.html.twig',[
            'form'=>$form->createView()
        ]);
    }
        }
