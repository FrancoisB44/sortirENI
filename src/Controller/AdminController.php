<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use App\Form\AdminUserRegistrationFormType;
use App\Form\CampusType;
use App\Form\CityType;
use App\Form\PlaceType;
use App\Form\CreateUserType;
use App\Form\RegistrationFormType;
use App\Form\StatusType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

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

    /**
     * @Route("/create_user_as_admin", name="create_user_as_admin")
     */
    public function createUserAsAdmin(Request $request,UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator)
    {
        $user = new User();
        $form = $this->createForm(AdminUserRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('create_user/createProfileAsAdmin.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list_user", name="list_user")
     */
    public function listUser(EntityManagerInterface $entityManager){
        $list = $entityManager->getRepository(User::class)->findAll();
        dump($list);
        exit();
    }
}