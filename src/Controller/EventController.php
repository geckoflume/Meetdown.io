<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events,
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_show")
     */
    public function detail($id)
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id '.$id
            );
        }

        return new Response('Check out this great event: '.$event->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
