<?php

namespace App\Controller;

use App\Form\NewEventType;
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
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

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
        $event = new Event();
        $form = $this->createForm(NewEventType::class, $event);
        //$form = $this->get('form.factory')->create(NewEventType::class, $event);


        if($request->isMethod('POST')){
            // Link between form and request object
            $form->handleRequest($request);
            if($form->isValid()){
                // Store new event
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return $this->redirectToRoute('events');
            }
        }

        return $this->render('event/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
