<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use App\Form\EventType;
use App\Form\SearchType;
use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function createEvent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();

        $formEvent = $this->createForm(EventType::class, $event);
        $formEvent->handleRequest($request);

        if ($formEvent->isSubmitted() && $formEvent->isValid()) {
//            $event->setUser($this->getUser()->getUsername());
            $event->setUser($this->getUser());


            $dEvent = $event->getStartDateTime();
            $dLRegistration = $event->getRegistrationDeadLine();
            $today = new \DateTime('now');

            $statutId = $entityManager->getRepository(Status::class)->findAll();

            if ($dEvent < $today) {
                $event->setStatus($statutId[6]);
            } elseif ($dEvent > $today and $dLRegistration < $today) {
                $event->setStatus($statutId[2]);
            } elseif ($dEvent > $today and $dLRegistration > $today) {
                $event->setStatus($statutId[1]);
            }

            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Sortie ajoutée !');

            return $this->redirectToRoute('list2');
        }

        return $this->render('event/createEvent.html.twig', [
            'formEvent' => $formEvent->createView(),
        ]);
    }


    /**
     * @Route(path="/list2", name="list2")
     */
    public function listEvent(EntityManagerInterface $entityManager) {

        $listEvent = $entityManager->getRepository('App:Event')->findAll();
        $listCampus = $entityManager->getRepository(Campus::class)->findAll();
        $listByCampus = $entityManager->getRepository('App:Event')->findByCampus('id');

        return $this->render('event/listEvent.html.twig', [
            'listEvent' => $listEvent,
            'listCampus' => $listCampus,
            'listByCampus' => $listByCampus
        ]);
    }

    /**
     * @Route(path="/details/{id}", requirements={"id":"\d+"}, name="details", methods={"GET"})
     */
    public function detailEvent(Request $request, EventRepository $eventRepository) {

        $id = $request->get('id');

        $eventRepository = $this->getDoctrine()->getRepository(Event::class);
        $event = $eventRepository->find($id);
        $participants = $event->getUsers();

        $detailEvent = $eventRepository->find($id);


        return $this->render('event/detailsEvent.html.twig', [
            'detailEvent' => $detailEvent,
            'participants' => $participants
        ]);
    }



    /**
     * @Route(path="/list", name="list")
     */
    public function findByFilters(EventRepository $eventRepository, Request $request) {

        $data = new SearchData();
        $formSearch = $this->createForm(SearchType::class, $data);

        $formSearch->handleRequest($request);


        $listByFilters = $eventRepository->findSearch($data);

        return $this->render('event/listEvent2.html.twig', [
            'listByFilters' => $listByFilters,
            'formSearch' => $formSearch->createView()
        ]);
    }

    /**
     * @Route(path="/subscribe/{id}", requirements={"id":"\d+"}, name="subscribe", methods={"GET"})
     */
    public function subscribe(Request $request, EventRepository $eventRepository, EntityManagerInterface $entityManager) {
        $id = $request->get('id');

        $eventRepository = $this->getDoctrine()->getRepository(Event::class);
        $inscription = $eventRepository->find($id);

        if(count($inscription->getUsers()) < $inscription->getNbRegistrationsMax()) {
            $inscription->addUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
        } else {
            $this->addFlash('danger', 'Dommage, il n\'y a plus de place');
        }

        return $this->redirectToRoute('list');
    }


//    public function place(Request $request, $placeId) {
//        $event = new Event();
//        $em = $this->getDoctrine()->getManager();
//        $placeSearch = $em->getRepository(Place::class)->findAllPlaceByCity($placeId);
//
//        $form = $this->createForm(
//            Event::class,
//            $event,
//            ['placeSearch' => $placeSearch]
//
//        );
//    }



}


