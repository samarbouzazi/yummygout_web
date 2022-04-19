<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Form\RechercheType;
use App\Repository\LivraisonRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function Affichel(Request $request, PaginatorInterface $paginator){
        $repository= $this->getDoctrine()->getRepository(Livraison::class);
        $donnees=$repository->findAll();
        $livraison= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
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

    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("/ascref", name="refasc")
     */
    function OrderByRefSQL(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByRefDQL();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/affrefd", name="refdesc")
     */
    function OrderByRefdescSQL(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByRefDescDQL();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/affetata", name="etatasc")
     */
    function OrderByEtatAsc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByEtatasc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/affetatd", name="etatdesc")
     */
    function OrderByEtatdesc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByEtatdesc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/affdattea", name="dateasc")
     */
    function OrderBydateAsc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByDateasc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/affdated", name="datedesc")
     */
    function OrderBydatedesc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByEtatdesc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/matriculeasc", name="matriculeasc")
     */
    function OrderByMatriculeasc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByMatriculeasc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/matriculedesc", name="matriculedesc")
     */
    function OrderByMatriculedesc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByMatriculedesc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/panierasc", name="panierasc")
     */
    function OrderBypanierasc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByMatriculeasc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/panierdesc", name="panierdesc")
     */
    function OrderBypanierdesc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByMatriculedesc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    function getDistance($addressfrom, $addressto, $unit){
        $apikey="AIzaSyCkG6ViKAIg4bnML4MsJzKe-F7sDx3WqSA";
        $formattedAddrFrom= str_replace(' ', '+', $addressfrom);
        $formattedAddrTo= str_replace(' ', '+', $addressto);
        $geocodefrom= file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apikey);
        $outputfrom= json_decode($geocodefrom);
        if(!empty($outputfrom->error_message)){
            return $outputfrom->error_message;
        }
        $geocodeTo= file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apikey);
        $outputTo= json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }
        $latfrom= $outputfrom->results[0]->geometry->location->lat;
        $longfrom= $outputfrom->results[0]->geometry->location->lng;
        $latTo= $outputTo->results[0]->geometry->location->lat;
        $longTo= $outputTo->results[0]->geometry->location->lng;
        $theta = $longfrom - $longTo;
        $dist = sin(deg2rad($latfrom)) * sin(deg2rad($latTo)) + cos(deg2rad($latfrom)) * cos(deg2rad($latTo)) * cos(deg2rad($theta));
        $dist= acos($dist);
        $dist = rad2deg($dist);
        $miles =$dist * 60 * 1.1515;
        $unit= strtoupper($unit);
        if ($unit=="k"){
            return round($miles* 1.609344, 2).' km';
        }elseif($unit=="M"){
            return round($miles* 1609.344, 2).' meteres';
        }else{
            return round($miles, 2).' miles';
        }
    }

    /**
     * @return Response
     * @Route("/geo", name="geo")
     */
    function aff(){
        $add='Cypress Hills, Brooklyn, NY, USA';
        $ad='Pozone park, Queens, NY, USA';
        $dist=$this->getDistance($add, $ad, "k");
        return $this->render("livraison/Affichefront.html.twig",
            [
                'c'=>$dist
            ]);
    }

    /**
     * @param Request $request
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("liv/search" ,name="searchh")
     */
    function rechercher(Request $request, LivraisonRepository $repository, PaginatorInterface $paginator){
        $searchvalue=$request->get('searchh');
        $donnees= $repository->findByMultiple( $searchvalue);
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('livraison/Affichel.html.twig', ['livraison'=>$liv]);

    }
    }
