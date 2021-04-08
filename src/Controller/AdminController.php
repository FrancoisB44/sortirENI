<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Place;
use App\Entity\Status;
use App\Form\CampusType;
use App\Form\CityType;
use App\Form\PlaceType;
use App\Form\StatusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/create_campus", name="create_campus")
     */
    public function createCampus(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campus = new Campus();

        $formCampus = $this->createForm(CampusType::class, $campus);
        $formCampus->handleRequest($request);

        if ($formCampus->isSubmitted() && $formCampus->isValid()) {

            $entityManager->persist($campus);
            $entityManager->flush();

            $this->addFlash('success', 'Campus ajouté !');

            return $this->redirectToRoute('list_campus');
        }

        return $this->render('admin/createCampus.twig', [ 'formCampus' => $formCampus->createView() ]);
    }

    /**
     * @Route(path="/list_campus", name="list_campus")
     */
    public function listCampus(EntityManagerInterface $entityManager) {

        $listCampus = $entityManager->getRepository('App:Campus')->findAll();

        return $this->render('admin/listCampus.html.twig', ['listCampus' => $listCampus]);
    }


    /**
     * @Route("/create_status", name="create_status")
     */
    public function createStatus(Request $request, EntityManagerInterface $entityManager): Response
    {
        $status = new Status();

        $formStatus = $this->createForm(StatusType::class, $status);
        $formStatus->handleRequest($request);

        if ($formStatus->isSubmitted() && $formStatus->isValid()) {

            $entityManager->persist($status);
            $entityManager->flush();

            $this->addFlash('success', 'Etat ajouté !');

            return $this->redirectToRoute('list_status');
        }

        return $this->render('admin/createStatus.twig', [ 'formStatus' => $formStatus->createView() ]);
    }


    /**
     * @Route(path="/list_status", name="list_status")
     */
    public function listStatus(EntityManagerInterface $entityManager) {

        $listStatus = $entityManager->getRepository('App:Status')->findAll();

        return $this->render('admin/listStatus.html.twig', ['listStatus' => $listStatus]);
    }


    /**
     * @Route("/create_place", name="create_place")
     */
    public function createPlace(Request $request, EntityManagerInterface $entityManager): Response
    {
        $place = new Place();

        $formPlace = $this->createForm(PlaceType::class, $place);
        $formPlace->handleRequest($request);

        if ($formPlace->isSubmitted() && $formPlace->isValid()) {

            $entityManager->persist($place);
            $entityManager->flush();

            $this->addFlash('success', 'Lieu ajouté !');

            return $this->redirectToRoute('create_place');
        }
        $listPlace = $entityManager->getRepository('App:Place')->findAll();

        return $this->render('admin/createPlace.html.twig', [
            'formPlace' => $formPlace->createView(),
            'listPlace' => $listPlace,
            ]);
    }



}