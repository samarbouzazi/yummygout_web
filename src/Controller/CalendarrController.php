<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendarr")
 */
class CalendarrController extends AbstractController
{
    /**
     * @Route("/", name="app_calendarr_index", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendarr/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_calendarr_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CalendarRepository $calendarRepository): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();
            return $this->redirectToRoute('app_calendarr_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('calendarr/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/edit", name="app_calendarr_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Calendar $calendar, CalendarRepository $calendarRepository): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendarRepository->add($calendar);
            return $this->redirectToRoute('app_calendarr_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('calendarr/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_calendarr_delete")
     */
    public function delete(Request $request, Calendar $calendar, CalendarRepository $calendarRepository): Response
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($calendar);
        $em->flush();
        return $this->redirectToRoute('app_calendarr_index');
    }
}
