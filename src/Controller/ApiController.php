<?php

namespace App\Controller;

use App\Entity\Evenement;

use App\Entity\Stocks;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"POST"})
     */
    public function majEvent(Stocks $calendar, Request $request)
    {
        // On récupère les données
        $data = json_decode($request->getContent());

        if(
            isset($data->title) && !empty($data->title) &&
            isset($data->start) && !empty($data->start) &&
            // isset($data->end) && !empty($data->end) &&
            isset($data->description) && !empty($data->description) &&
            isset($data->backgroundColor) && !empty($data->backgroundColor) &&
            isset($data->borderColor) && !empty($data->borderColor) &&
            isset($data->textColor) && !empty($data->textColor)
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Stocks();

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setNom($data->title);
            $calendar->setDescription($data->description);
            $calendar->setDate(new DateTime($data->start));
            // if($donnees->allDay){
            // $calendar->setDate(new DateTime($data->end));
            // }else{
            //   $calendar->setEnd(new DateTime($donnees->end));
            //}
            /*  $calendar->setAllDay($donnees->allDay);
              $calendar->setBackgroundColor($donnees->backgroundColor);
              $calendar->setBorderColor($donnees->borderColor);
              $calendar->setTextColor($donnees->textColor);*/

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }


        /*return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);*/
    }

}