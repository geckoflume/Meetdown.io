<?php

namespace App\Controller;

use App\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

/**
 * Controller used to manage events.
 * @author Florian Mornet <florian.mornet@enseirb-matmeca.fr>
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="events")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index()
    {
        // Find all events, ascending according to the start date and start time
        $events=$this->getDoctrine()->getRepository(Event::class)->findBy(array(), array('date_start' => 'asc', 'time_start' => 'asc'));

        $event_count = null;

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $event_count = $this->getDoctrine()->getRepository(Event::class)->countEventsByUser($this->getUser());
        }

        return $this->render('event/base_list_events.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events,
            'event_count' => $event_count,
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_detail", requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function detail($id)
    {
        // Find $id event
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $event_count = null;

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $event_count = $this->getDoctrine()->getRepository(Event::class)->countEventsByUser($this->getUser());
        }

        return $this->render('event/event.html.twig', [
            'event' => $event,
            'event_count' => $event_count,
        ]);
    }

    /**
     * @Route("/event/new", name="add_event")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function addEvent(Request $request)
    {
        $event_count = null;

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $event_count = $this->getDoctrine()->getRepository(Event::class)->countEventsByUser($this->getUser());
        }
        // 1) build the form
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $event->setPoster($this->getUser());

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

        return $this->render('event/add_event.html.twig', [
            'form' => $form->createView(),
            'event_count' => $event_count,
        ]);
    }

    // TODO: delete event action

    /**
     * @Route("/my_events", name="my_events")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function myEvents()
    {
        // Find all events by the connected user
        $eventsUser = $this->getDoctrine()->getRepository(Event::class)->findByUser($this->getUser());

        $event_count = null;

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $event_count = $this->getDoctrine()->getRepository(Event::class)->countEventsByUser($this->getUser());
        }

        return $this->render('event/my_events.html.twig', [
            'controller_name' => 'EventController',
            'action_name' => 'my_events',
            'events' => $eventsUser,
            'event_count' => $event_count,
        ]);
    }
}
