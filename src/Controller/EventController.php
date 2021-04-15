<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use App\Form\CancelEventFormType;
use App\Form\EventType;
use App\Form\PlaceType;
use App\Form\SearchType;
use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function createEvent(Request $request, EntityManagerInterface $entityManager, PlaceRepository $placeRepository): Response
    {
        $event = new Event();
        $event->setMotif(" ");
        $formEvent = $this->createForm(EventType::class, $event);
        $formEvent->handleRequest($request);

        //test de recuperation du nouvx lieu de creer
        //$foo = $request->query->get('idFoo');
            $foo = $request->query->get('idFoo');

        $place= null;
        if(!empty($foo)) {
            $place = $placeRepository->find($foo);
            $event->setPlace($place);
        }


        $dEvent = $event->getStartDateTime();
        $dLRegistration = $event->getRegistrationDeadLine();
        $today = new \DateTime('now');

        if ($formEvent->isSubmitted() && $formEvent->isValid()) {
//            $event->setUser($this->getUser()->getUsername());
            if  ($dEvent > $today and $dLRegistration > $today and $dLRegistration < $dEvent) {
            $event->setUser($this->getUser());

            $idPlace= $request->get('select_place');
            $place = $placeRepository->findOneBy(['id'=>$idPlace]);
            $event->setPlace($place);



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

            return $this->redirectToRoute('list');
        } else {
                $this->addFlash('danger', 'Attention, incohérence dans la saisie des dates!!!');
//                return $this->redirectToRoute('create');
            }
        }

        return $this->render('event/createEvent.html.twig', [
            'formEvent' => $formEvent->createView(),
           'foo'=> $place
        ]);
    }


    /**
     * @Route(path="/list2", name="list2")
     */
    public function listEvent(EntityManagerInterface $entityManager, PaginatorInterface $paginator) {

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
    public function findByFilters(EventRepository $eventRepository,PaginatorInterface $paginator, Request $request, EntityManagerInterface $em) {

        $data = new SearchData();
        $formSearch = $this->createForm(SearchType::class, $data);

//        $data->setUserSearch($this->getUser());

//        $planner = $userRepository->find($this->getUser()->getUsername());
//        $em = $this->getDoctrine()->getManager()->getRepository('App:User');
//        $user = $em->find($request->getUser());

        $formSearch->handleRequest($request);


        $listByFilters = $eventRepository->findSearch($data, $this->getUser());
//        dump($data);
//        dump($listByFilters);
//        exit();
         $event= $paginator->paginate(
            $listByFilters, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );

        return $this->render('event/listEvent2.html.twig', [
            'listByFilters' => $event,
            'formSearch' => $formSearch->createView(),
//            'planner' => $planner
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

            if(count($inscription->getUsers()) == $inscription->getNbRegistrationsMax()) {
                $statutId = $entityManager->getRepository(Status::class)->findAll();
                $inscription->setStatus($statutId[7]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
        } else {
            $this->addFlash('danger', 'Dommage, il n\'y a plus de place');
        }


        return $this->redirectToRoute('list');
    }
    /**
     * @Route(path="/unsubscribe/{id}", requirements={"id":"\d+"}, name="unsubscribe")
     */
    public function unsubscribe(Request $request, EntityManagerInterface $entityManager){
        $id = $request->get('id');

        $repo = $entityManager->getRepository(Event::class);
        $event = $repo->find($id);

        $event->removeUser($this->getUser());

        if(count($event->getUsers()) < $event->getNbRegistrationsMax()) {
            $statutId = $entityManager->getRepository(Status::class)->findAll();
            $event->setStatus($statutId[1]);
        }


        $entityManager->flush();
        return $this->redirectToRoute('list');
    }

    /**
     * @Route(path="/cancel_event/{id}",requirements={"id":"\d+"}, name="cancel_event")
     */
    public function cancelEvent(Request $request, EntityManagerInterface $entityManager)
    {
        $id = $request->get('id');
        $repo = $entityManager->getRepository(Event::class);

        $event = $repo->find($id);
        $event->setMotif(null);
        $cancelForm = $this->createForm(CancelEventFormType::class,$event);
        $cancelForm->handleRequest($request);
        if($cancelForm->isSubmitted() && $cancelForm->isValid()){
            $statutId = $entityManager->getRepository(Status::class)->findAll();
            $event->setStatus($statutId[5]);
            $entityManager->flush();
            $this->addFlash('danger', 'Sortie annulée !');

            return $this->redirectToRoute('list');
        }
        return $this->render('event/cancelEvent.html.twig', [
            'detailEvent' => $event,
            'cancelForm' => $cancelForm->createView(),
        ]);
    }


//    /**
//     * @Route("/create_place", name="create_place")
//     */
//    public function createPlace(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $place = new Place();
//
//        $formPlace = $this->createForm(PlaceType::class, $place);
//        $formPlace->handleRequest($request);
//
//        if ($formPlace->isSubmitted() && $formPlace->isValid()) {
//
//            $entityManager->persist($place);
//            $entityManager->flush();
//
//            $this->addFlash('success', 'Lieu ajouté !');
//
//            return $this->redirectToRoute('create_place');
//        }
//        $listPlace = $entityManager->getRepository('App:Place')->findAll();
//
//        return $this->render('admin/createPlace.html.twig', [
//            'formPlace' => $formPlace->createView(),
//            'listPlace' => $listPlace,
//        ]);
//    }

    /**
     * @Route("/create_place_bis", name="create_place_bis")
     */
    public function createPlaceBis(Request $request,PlaceRepository $placeRepository, EntityManagerInterface $entityManager): Response
    {
        $place = new Place();

        $formPlace = $this->createForm(PlaceType::class, $place);
        $formPlace->handleRequest($request);

        if ($formPlace->isSubmitted() && $formPlace->isValid()) {

            $entityManager->persist($place);
            $entityManager->flush();

            $idFoo=$place->getId();
            $this->addFlash('success', 'Lieu ajouté !');
            //$foo= $placeRepository->find($idFoo);
            return $this->redirectToRoute('create',['idFoo'=>$idFoo]);

        }
        $listPlace = $entityManager->getRepository('App:Place')->findAll();

        return $this->render('admin/createPlace.html.twig', [
            'formPlace' => $formPlace->createView(),
            'listPlace' => $listPlace,
            //'idFoo'=>$foo,
        ]);
    }


}



