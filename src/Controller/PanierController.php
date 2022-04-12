<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Platt;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="app_panier")
     */
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
    /**
     * @param PanierRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/panier/AfficheP" , name="AfficheP")
     */
    public function Affiche(PanierRepository $repository){

        $panier=$repository->findAll();

        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);

    }
    /**
     * @param PanierRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/panier/Affichefront" , name="Affichefront")
     */
    public function Affichefront(PanierRepository $repository){

        $panier=$repository->findAll();

        return $this->render('panier/Affichagefront.html.twig',['panier'=>$panier]);

    }
    /**
     * @Route("/Supp/{id}" ,  name="supp")
     */
    public function Delete( Panier $panier):Response{

        $em=$this->getDoctrine()->getManager();
        $em->remove($panier);
        $em->flush();
        $this->addFlash(
            'info',
            'commande Supprimée'
        );
        return $this->redirectToRoute('Affichefront')  ;

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Panier/Addfront/{id}" , name="Addfront")
     */
    function Addfront(\Symfony\Component\HttpFoundation\Request $request , Platt $plat , \SessionIdInterface $session){
        $randomNumber = rand();
        $panier=new Panier();
        $panierr = $session->get();
        $id = $plat->getIdplat();
        $panier->setNumfacture($randomNumber);
        $form=$this->createForm(PanierType::class , $panier);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form ->isValid() ){
            $em=$this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush();
            $session->set("panier", $panier);
            return $this->redirectToRoute('Affichefront');

        }

        return $this->render('panier/addp.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Panier/Addp" , name="Addp")
     */
    function Add(\Symfony\Component\HttpFoundation\Request $request  ){
        $randomNumber = rand();
        $panier=new Panier();
        $panier->setNumfacture($randomNumber);
        $form=$this->createForm(PanierType::class , $panier);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form ->isValid() ){
            $em=$this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush();
            return $this->redirectToRoute('Affichefront');

        }
        $this->addFlash(
            'info',
            'commande Ajouté'
        );
        return $this->render('panier/addp.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("panier/Update/{id}",name="update")
     */
    function Update(PanierRepository $repository, $id , \Symfony\Component\HttpFoundation\Request $request){
        $panier=$repository->find($id);
        $form=$this->createForm(PanierType::class,$panier);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                'info',
                'commande Modifié'
            );
            return $this->redirectToRoute("Affichefront");

        }

        return $this->render('panier/updatep.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }

}
