<?php

namespace App\Controller;

use App\Form\NewEventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="event")
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
    public function addEvent($id)
    {
        $form = $this->createForm(NewEventType::class, $task);

        return $this->render('event/event.html.twig', [
            'event' => $event,
        ]);
    }
}
