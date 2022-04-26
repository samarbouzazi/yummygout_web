<?php

namespace App\Controller;

use App\Repository\ReclamantionlivraisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartJsController extends AbstractController
{
    /**
     * @Route("/chart/js", name="app_chart_js")
     */
    public function index(): Response
    {
        return $this->render('chart_js/index.html.twig', [
            'controller_name' => 'ChartJsController',
        ]);
    }

    /**
     * @param ReclamantionlivraisonRepository $categrepo
     * @param ChartBuilderInterface $chartBuilder
     * @return Response
     * @Route("/chartjs", name="chartjs")
     */
    public function statistiques(ReclamantionlivraisonRepository $categrepo, ChartBuilderInterface $chartBuilder, ChartBuilderInterface  $chartbuild){
        //rec par sujets
        $reclam=$categrepo->countbysujets();
        $labelss=[];
        $datacountt=[];
        foreach ($reclam as $recl){
            $labelss[]=$recl['sujets'];
            $datacountt[]=$recl['nbre'];
        }
        $chartt = $chartbuild->createChart(Chart::TYPE_BAR);
        $chartt->setData([
            'labels' => $labelss,
            'datasets' => [
                [
                    'label' => 'Le nombre de réclamation par jour',
                    'backgroundColor' => 'rgb(42%, 65%, 80%)',
                    'borderColor' => 'rgb(42%, 65%, 80%)',
                    'data' => $datacountt,
                ],
            ],
        ]);

        $chartt->setOptions([]);
        //reclamations par jour
        $rec = $categrepo->countbydate();
        $datacount = [];
        $labels = [];

        foreach ($rec as $reclamation) {
            $labels[] = $reclamation['daterec'];
            $datacount[] = $reclamation['nb'];
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Le nombre de réclamation par jour',
                    'backgroundColor' => 'rgb(81, 152, 255)',
                    'borderColor' => 'rgb(0, 168, 255)',
                    'data' => $datacount,
                ],
            ],
        ]);

        $chart->setOptions([]);

        return $this->render('chart_js/index.html.twig', [
            'chart' => $chart, 'chartt'=>$chartt
        ]);
    }
}
