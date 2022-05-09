<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Reclamantionlivraison;
use App\Repository\LivraisonRepository;
use App\Repository\ReclamantionlivraisonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReclamantionlivraisonType;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;


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
     * @Route ("reclamationlivraison/Affichebackrec", name="Afficheb")
     */
    public function Affichel(Request $request,ReclamantionlivraisonRepository $repository, PaginatorInterface $paginator){
        $donnees=$repository->findAll();
        $reclamationlivraison= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('reclamation_livraison/ReclamationBack.html.twig', compact('reclamationlivraison'));}


    /**
     * @param ReclamantionlivraisonRepository $repository
     * @param NormalizerInterface $normalizable
     * @Route  ("/marwa", name="marwa")
     * @return Response
     */

    public function Afficheljson(ReclamantionlivraisonRepository $repository,NormalizerInterface $normalizable){
        $donnees=$repository->findAll();
       $jsonContent=$normalizable->normalize($donnees,'json', ['groups'=>'post:read']);
        return new Response(json_encode(($jsonContent)));}
    /**
     * @param  ReclamantionlivraisonRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("reclamationlivraison/AfficheR", name="AfficheR")
     */
    public function Affichefrontrec(Request $request){
        $repository=$this->getDoctrine()->getRepository(Reclamantionlivraison::class);
        $user=$this->getUser()->getUsername();
        $donnees=$repository->findByclientname($user);
        return $this->render('reclamation_livraison/AfficheR.html.twig', ['reclamationlivraison'=>$donnees]);
    }

    /**
     * @param ReclamantionlivraisonRepository $repository
     * @param NormalizerInterface $normalizable
     * @param $id
     * @return Response
     * @Route ("/detail/{id}", name="detail")
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function detailjson(ReclamantionlivraisonRepository $repository,NormalizerInterface $normalizable,$id){
        $donnees=$repository->find($id);
        $jsonContent=$normalizable->normalize($donnees,'json', ['groups'=>'post:read']);
        return new Response(json_encode(($jsonContent)));}
    /**
     * @Route("/SuppReclivraison/{id}", name="SuppReclivraison")
     */
    function Delete( Reclamantionlivraison $reclivraison ,$id):Response
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Livraison::class)->find($id);
        $em->remove($reclivraison);
        $em->flush();
        return $this->redirectToRoute('AfficheR');
    }

    /**
     * @param Reclamantionlivraison $reclivraison
     * @param $id
     * @param NormalizerInterface $normalizable
     * @return Response
     * @Route("/m/{id}", name="m")
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */

    function Deletejson( Reclamantionlivraison $reclivraison , $id , NormalizerInterface $normalizable):Response
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Livraison::class)->find($id);
        $em->remove($reclivraison);
        $em->flush();
        $jsonContent=$normalizable->normalize($rec,'json', ['groups'=>'post:read']);
        return new Response("reclamation supprimé".json_encode(($jsonContent)));
    }
    /**
     * @Route("/AjouterReclivraison", name="AjouterReclivraison")
     */
    function Add( Request $request, ReclamantionlivraisonRepository $repository):Response
    {
        $user=$this->getUser()->getUsername();
        $Reclamantionlivraison=new Reclamantionlivraison();
        $form=$this->createForm(ReclamantionlivraisonType::class, $Reclamantionlivraison);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        $var=$repository->findOneBy(['idLivraison' => ($Reclamantionlivraison->getIdLivraison())]);
        if($form->isSubmitted()&& $form->isValid() && !$var){
            $Reclamantionlivraison->setClientname($user);
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
     * @param Request $request
     * @param ReclamantionlivraisonRepository $repository
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route ("/me", name="me")
     */
    function Addjson( Request $request, ReclamantionlivraisonRepository $repository , NormalizerInterface $normalizer):Response
    {
        $Reclamantionlivraison=new Reclamantionlivraison();
            $Reclamantionlivraison->setReclamation($request->get('reclamation'));
            $Reclamantionlivraison->setSujetrec($request->get('sujetrec'));
            $Reclamantionlivraison->setCreatedat($request->get('createdat'));
            $Reclamantionlivraison->setUpdatedat($request->get('updatedat'));
            $Reclamantionlivraison->setClientname($request->get('clientname'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($Reclamantionlivraison);
            $em->flush();
        $jsonContent=$normalizer->normalize($Reclamantionlivraison,'json', ['groups'=>'post:read']);
        return new Response(json_encode(($jsonContent)));


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
     * @param ReclamantionlivraisonRepository $repository
     * @param $id
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("/updatejson/{id}", name="updatejson")
     */
    function updatejson(ReclamantionlivraisonRepository $repository, $id, Request $request , NormalizerInterface $normalizable){
            $reclivraison=$repository->find($id);
            $em=$this->getDoctrine()->getManager();
            $reclivraison->setReclamation($request->get('reclamation'));
            $em->flush();
        $jsonContent=$normalizable->normalize($reclivraison,'json', ['groups'=>'post:read']);
        return new Response("Information updated successfully".json_encode($jsonContent));
        ;

    }





    /**
     * @param Request $request
     * @param ReclamantionlivraisonRepository $repository
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("/search", name="search")
     */
    function rechercher(Request $request, ReclamantionlivraisonRepository $repository, PaginatorInterface $paginator){
        $searchvalue=$request->get('search');
        $donnees= $repository->findByMultiple( $searchvalue );
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('reclamation_livraison/ReclamationBack.html.twig', ['reclamationlivraison'=>$liv]);

    }

    /**
     * @param ReclamantionlivraisonRepository $repository
     * @return Response
     * @Route("/testttt")
     */
    function getlivreurs( ReclamantionlivraisonRepository $repository){
        $donees=$repository->findBy('idLivraison','');
        return $this->render('reclamation_livraison/test.html.twig', ['donnees'=>$donees]);

    }



}
