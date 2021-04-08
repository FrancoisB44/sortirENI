<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Status;
use App\Form\CampusType;
use App\Form\CityType;
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
     * @Route("/create_city", name="create_city")
     */
    public function createCity(Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new City();

        $formCity = $this->createForm(CityType::class, $city);
        $formCity->handleRequest($request);

        if ($formCity->isSubmitted() && $formCity->isValid()) {

            $entityManager->persist($city);
            $entityManager->flush();

            $this->addFlash('success', 'Ville ajoutée !');

            return $this->redirectToRoute('create_city');
        }
        $listCity = $entityManager->getRepository('App:City')->findAll();

        return $this->render('admin/createCity.html.twig', [
            'formCity' => $formCity->createView(),
            'listCity' => $listCity,
            ]);
    }



}