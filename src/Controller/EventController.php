<?php

namespace App\Controller;

use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="events")
     */
    public function index()
    {
        // Find all events, ascending according to the start date and start time
        $events=$this->getDoctrine()->getRepository(Event::class)->findBy(array(), array('date_start' => 'asc', 'time_start' => 'asc'));

        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events,
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_detail", requirements={"id"="\d+"})
     */
    public function detail($id)
    {
        // Find $id event
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        return $this->render('event/event.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/event/new", name="add_event")
     */
    public function addEvent(Request $request)
    {
        // 1) build the form
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        // 2) handle the submit (will only happen on POST)
        // Link between form and request object
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            // 3) Save new event
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('events');
        }

        return $this->render('event/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
