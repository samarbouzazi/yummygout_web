<?php

namespace App\Controller;


use App\Entity\Fournisseurs;
use App\Form\FournisseursType;
use App\Repository\FournisseursRepository;
use App\Repository\StocksRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Twilio\Rest\Client;

class FournisseursController extends Controller
{
    /**
     * @Route("/", name="app_fournisseurs")
     */
    public function index(): Response
    {
        return $this->render('base-back.html.twig');
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

        $sp=0;
        $pl=0;

        foreach ($allfour as $pr)
        {
            if (  $pr->getCatf()=="Pattes")  :

                $sp+=1;
            elseif ($pr->getCatf()=="Jus"):

                $pl+=1;

            endif;

        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['catf', 'catf'],
                ['Pattes',     $sp],
                ['Jus',      $pl]
            ]);
        $pieChart->getOptions()->setColors(['#ffd700', '#C0C0C0']);

        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('fournisseurs/Affiche.html.twig', ['four' => $four,
            'piechart' => $pieChart]);

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
            "fours" => $four,
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

    /**
     * @Route("/chartjs", name="chartjs")
     */
    public function statistiques(EntityManagerInterface $entityManager): Response

    {
        $produit = $entityManager
            ->getRepository(Fournisseurs::class)
            ->findAll();

        $sp=0;
        $pl=0;

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($produit as $pr)
        {
            if (  $pr->getCatf()=="Pattes")  :

                $sp+=1;
            elseif ($pr->getCatf()=="Jus"):

                $pl+=1;

            endif;

        }

        //$l=sizeof($voyageOrganises);
        //echo "alert('$l');";
        $pieChart = new BarChart();
        $pieChart->getData()->setArrayToDataTable(
            [['catf', 'catf'],
                ['Pattes',     $sp],
                ['Jus',      $pl]
            ]);
        $pieChart->getOptions()->setColors(['#ffd700', '#C0C0C0']);


        $pieChart->getOptions()->setTitle('Population of Largest U.S. Cities');
        $pieChart->getOptions()->getHAxis()->setTitle('Population of Largest U.S. Cities');
        $pieChart->getOptions()->getHAxis()->setMinValue(0);
        $pieChart->getOptions()->getVAxis()->setTitle('City');
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->setHeight(500);
        return $this->render('fournisseurs/chartjs.html.twig',
            array('piechart' => $pieChart));
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiquess(StocksRepository $evRepo)
    {
        // On va chercher le nombre d'annonces publiées par date
        $evenement = $evRepo->countByfour();

        $dates = [];
        $evenementCount = [];



        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($evenement as $evenements){
            $dates[] = $evenements['name'];
            $evenementCount[] = $evenements['count'];
        }

        return $this->render('stocks/stat.html.twig', [

            'dates' => json_encode($dates),
            'evenementCount' => json_encode($evenementCount),
        ]);
    }
}
