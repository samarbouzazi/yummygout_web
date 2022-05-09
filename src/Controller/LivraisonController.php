<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Entity\Geocode;
use App\Entity\GeocodeRepository;
use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Form\UpdateLivraisonType;
use App\Repository\CalendarRepository;
use App\Repository\DeliveryRepository;
use App\Repository\LivraisonRepository;
use App\Repository\LivreurRepository;
use App\Services\QrcodeService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use DateTime;

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
            5
        );
        return $this->render('livraison/Affichel.html.twig', ['livraison'=>$livraison]);
    }

    /**
     * @param NormalizerInterface $normalizer
     * @return Response
     * @Route("/liv", name="livjson")
     */
    public function alllivraison(NormalizerInterface $normalizer){
        $repository= $this->getDoctrine()->getRepository(Livraison::class);
        $donnees=$repository->findAll();
        $jsonContent= $normalizer->normalize($donnees, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @param NormalizerInterface $normalizer
     * @param $id
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("/detail/{id}" , name="detail")
     */
    public function detailliv(NormalizerInterface $normalizer, $id){
        $repository= $this->getDoctrine()->getRepository(Livraison::class);
        $donnees=$repository->find($id);
        $jsonContent= $normalizer->normalize($donnees, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @param LivraisonRepository $repository
     * @param $id
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("/updatejson/{id}" , name="updatejson")
     */
    function updatejson(LivraisonRepository $repository, $id, Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $livraison= $repository->find($id);
        $livraison->setEtat($request->get('etat'));
        $em->flush();
        $jsonContent= $normalizer->normalize($livraison, 'json', ['groups'=>'post:read']);
        return new Response(("information updated successfully".json_encode($jsonContent)));
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route ("/addlivjson/new", name="addlivjson")
     */
    function addlivjson(Request $request, NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $livraison= new Livraison();
        $livraison->setReflivraison($request->get('reflivraison'));
        $livraison->setRegion($request->get('region'));
        $livraison->setRueliv($request->get('rueliv'));
        $em->persist($livraison);
        $em->flush();
        $jsonContent= $normalizer->normalize($livraison, 'json', ['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @param $id
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route ("/suppjson/{id}",name="suppjson")
     */
    public function deletelivjson(Request $request, NormalizerInterface $normalizer, $id){
        $em=$this->getDoctrine()->getManager();
        $livraison= $em->getRepository(Livraison::class)->find($id);
        $em->remove($livraison);
        $em->flush();
        $jsonContent= $normalizer->normalize($livraison, 'json',['groups'=>'post:read']);
        return new Response("livraison supprimée".json_encode($jsonContent));
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
    function Add( Request $request, LivraisonRepository $repository,DeliveryRepository $repo, QrcodeService $qrcodeService):Response
    {
        $c=0.0;
        $frais=0.0;
        $qrcode=null;
        $randomNumber = rand(100001, 999999);
        $livraison=new livraison();
        $livraison->setReflivraison($randomNumber);
        $form=$this->createForm(LivraisonType::class, $livraison);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $livreur=$repo->findOneBy(['disponibility'=>'oui', 'zone'=>$livraison->getRegion()]);
            $livraison->setIdlivreur($livreur);
            $livraison->setClient('amani');
            $em=$this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            $this->addFlash(
                'info',
                'ajouté avec succés, pour plus de détail scanner votre qr code'
            );
            $calendar= new Calendar();
            $titre=$calendar->setTitle(strval($livraison->getReflivraison()));
            $start=$calendar->setStart($livraison->getDate());
            $date=$calendar->getStart();
            $dd=strtotime($livraison->getDate()->format('Y-m-d H:i:s'). ' +30 minutes');
            $time = date('Y-m-d H:i:s',$dd);
            $timend=DateTime::createFromFormat('Y-m-d H:i:s', $time, null);
            $end=$calendar->setEnd($timend);
            $description=$calendar->setDescription($livraison->getRueliv());
            $allday=$calendar->setAllday(false);
            $backcolor=$calendar->setBackgroundcolor("#00ffbb");
            $border=$calendar->setBordercolor("#000000");
            $textcolor=$calendar->setTextcolor("#000000");
            $emm=$this->getDoctrine()->getManager();
            $liv=$calendar->setLivreur("amani.hadda@esprit.tn");
            $livraisoncalendar=$calendar->setIdlivraison($livraison);
            $emm->persist($calendar);
            $emm->flush();
            //$idd=$livreur->getId();
            //$nb=0;
            //$count=$repository->countlivraisonparlivreur($idd);
            //foreach ($count as $nbre){
             //   $nb = $nbre['nb'];}
            //if($nb==6){
            //  $persoliv=$repo->findOneBy(['id'=>$idd]);
             //  $persoliv->setDisponibility('non');
           // }
            $c=$this->getDistance($livraison->getRegion());
            if($c>15.0){
                $frais=5.0;
            }
            if($c<15.0){
                $frais=3.0;
            }
           $qrcode=$qrcodeService->qrcode("le référence de livraison est : {$livraison->getReflivraison()}, l''etat est : {$livraison->getEtat()}, l'addresse est : {$livraison->getRueliv()}, {$livraison->getRegion()}, le livreur est : {$livreur->getMatricule()}, les frais de livraison est : {$frais} dt");
            return $this->render('livraison/Addlivraison.html.twig',[
                'form'=>$form->createView(),
                'qrCode'=>$qrcode
            ]);
        }
        return $this->render('livraison/Addlivraison.html.twig',[
            'form'=>$form->createView(),'qrCode'=>$qrcode
        ]);}


    /**
     * @Route("livraison/Update/{id}",name="update")
     */
    function update(LivraisonRepository $repository, $id, Request $request){
        $livraison=$repository->find($id);
        $form=$this->createForm(UpdateLivraisonType::class,$livraison);
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
            5
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
            5
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
            5
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
            5
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
            5
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
            5
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
            5
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
            5
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/regionasc", name="regionasc")
     */
    function OrderByregionasc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByRegionasc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/regiondesc", name="regiondesc")
     */
    function OrderByregiondesc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByRegiondesc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/rueasc", name="rueasc")
     */
    function OrderByRueasc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByRueasc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("livraison/ruedesc", name="ruedesc")
     */
    function OrderByruedesc(LivraisonRepository $repository, Request $request, PaginatorInterface $paginator){
        $donnees=$repository->OrderByRuedesc();
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('livraison/Affichel.html.twig',['livraison'=>$liv]);
    }
    /**
     * @param Request $request
     * @param LivraisonRepository $repository
     * @return Response
     * @Route("liv/search" ,name="search")
     */
    function rechercher(Request $request, LivraisonRepository $repository, PaginatorInterface $paginator){
        $searchvalue=$request->get('search');
        $donnees= $repository->findByMultiple( $searchvalue);
        $liv= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('livraison/Affichel.html.twig', ['livraison'=>$liv]);

    }
    /**
     * @param CalendarRepository $calendar
     * @return Response
     * @Route("/calendrier", name="calendrier")
     */
    public function caledendar(CalendarRepository $calendar): Response

    {   $events = $calendar->findAll();
        $rdvs = [];
        foreach($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundcolor' => $event->getBackgroundcolor(),
                'bordercolor' => $event->getBordercolor(),
                'textcolor' => $event->getTextcolor(),
                'allday' => $event->getAllday()];
        }
        $data = json_encode($rdvs);
        return $this->render('livraison/Calendar.html.twig',compact('data')
        );
    }

    /**
     * @return Response
     * @Route("/tester/{region}/{rueliv}", name="tester")
     */
public function tester($region, $rueliv){
    $addresse=$region.$rueliv;
        $addressGps= str_replace(" ","+", $addresse);
        return $this->render('livraison/geolocalisation.html.twig', ['adrgps'=>$addressGps]);
}

    /**
     * @param $addressfrom
     * @param $addressto
     * @param $unit
     * @param GeocodeRepository $repository
     * @return float
     * @Route("/frais")
     */
    function getDistance($addrssto){
        $repository=$this->getDoctrine()->getRepository(Geocode::class);
        $addressfrom='Ariana Medina';
        $unit="k";
        $from=$repository->findOneBy(['address'=>"Ariana Medina"]);
        $latfrom= $from->getLatitude();
        $longfrom= $from->getLongitude();
        $to= $repository->findOneBy(['address'=>$addrssto]);
        $latTo=$to->getLatitude();
        $longTo= $to->getLongitude();
        $theta = $longfrom - $longTo;
        $dist = sin(deg2rad($latfrom)) * sin(deg2rad($latTo)) + cos(deg2rad($latfrom)) * cos(deg2rad($latTo)) * cos(deg2rad($theta));
        $dist= acos($dist);
        $dist = rad2deg($dist);
        $miles =$dist * 60 * 1.1515;
        $unit= strtoupper($unit);
        $c=0.0;
        if ($unit=="k"){
            $c= round($miles* 1.609344, 2);
        }
        return $c;
    }

    /**
     * @param LivraisonRepository $repo
     * @return Response
     * @Route("/yezi", name="yezi")
     */
    public function count(LivraisonRepository $repo){
        $c=$repo->countnb();
        foreach ($c as $recl){
            $labelss=$recl['nb'];
        }
        $nb=strval($c);
        return $this->render('livraison/Affichefront.html.twig', ['c'=>$labelss]);

    }

}
