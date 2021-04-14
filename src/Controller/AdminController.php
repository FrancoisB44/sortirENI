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
use App\Form\ModificationFormType;
use App\Form\ModifyProfileAsAdminFormType;
use App\Form\PlaceType;
use App\Form\CreateUserType;
use App\Form\RegistrationFormType;
use App\Form\StatusType;
use App\Repository\PlaceRepository;
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

            return $this->redirectToRoute('create_campus'); // rester sur la meme page
        }
        $listCampus = $entityManager->getRepository('App:Campus')->findAll();
        //mettre l id ds le path
        // faire un campus repository et faire un find all
// recuperer ma liste de campus + ajouter au tableau des para a afficher dc apres le create view
        return $this->render('admin/createCampus.twig', [
            'formCampus' => $formCampus->createView(),
            'listCampus' => $listCampus,
            ]);

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

            return $this->redirectToRoute('create_status');
        }
        $listStatus = $entityManager->getRepository('App:Status')->findAll();

        return $this->render('admin/createStatus.twig', [
            'formStatus' => $formStatus->createView(),
            'listStatus' => $listStatus,
            ]);
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
    //test
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
    /**
     * @Route("/create_user_as_admin", name="create_user_as_admin")
     */
    public function createUserAsAdmin(Request $request,UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator)
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
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

//            return $guardHandler->authenticateUserAndHandleSuccess(
//                $user,
//                $request,
//                $authenticator,
//                'main' // firewall name in security.yaml
//            );
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

        return $this->render('admin/listUsersAsAdmin.html.twig', ['listUsers'=> $list]);
    }

    /**
     * @Route("/delete_user/{id}",requirements={"id":"\d+"}, name="delete_user")
     */
    public function deleteUser($id, EntityManagerInterface $entityManager){
        $repo = $entityManager->getRepository(User::class);
        $user = $repo->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success','utilisateur'.$user->getUsername().'a été supprimé');

        $list = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/listUsersAsAdmin.html.twig', ['listUsers'=> $list]);
    }

    /**
     * @Route("/modify_user_as_admin/{id}", requirements={"id":"\d+"}, name="modify_user_as_admin")
     */
    public function modifyUser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $profileId = $request->get('id');
        $profile = $entityManager->getRepository(User::class)->find($profileId);
        $form = $this->createForm(ModifyProfileAsAdminFormType::class,$profile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profile);
            $entityManager->flush();
            $this->addFlash('success', 'Modification success');
            return $this->redirectToRoute('list_user');// pas sur du nom de la route
        }
        return $this->render('admin/modifyProfileAsAdmin.html.twig', ["userForm" => $form->createView(), "user"=>$profile]);
    }

    /**
     * @Route("/home", name="admin_home")
     */
    public function mainAdmin(){
        return $this->render('admin/mainAdmin.html.twig');
    }

    /**
     * @Route("/delete_campus/{id}",requirements={"id":"\d+"}, name="delete_campus")
     */
    public function deleteCampus(Request $request, EntityManagerInterface $entityManager){
        $id = $request->get('id');

        $campus = $entityManager->getRepository(Campus::class)->find($id);

        $entityManager->remove($campus);
        $entityManager->flush();

        $this->addFlash('success','Le campus a été supprimé');

        return $this->redirectToRoute('create_campus'); // rester sur la meme page
    }

    /**
     * @Route("/delete_status/{id}",requirements={"id":"\d+"}, name="delete_status")
     */
    public function deleteStatus(Request $request, EntityManagerInterface $entityManager){
        $id = $request->get('id');

        $status = $entityManager->getRepository(Status::class)->find($id);

        $entityManager->remove($status);
        $entityManager->flush();

        $this->addFlash('success','Le status a été supprimé');

        return $this->redirectToRoute('create_status'); // rester sur la meme page
    }

    /**
     * @Route("/modify_status/{id}", requirements={"id":"\d+"}, name="modify_status")
     */
    public function modifyStatus(Request $request, EntityManagerInterface $entityManager)
    {
        $statusId = $request->get('id');
        $status = $entityManager->getRepository(Status::class)->find($statusId);
        $form = $this->createForm(StatusType::class,$status);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($status);
            $entityManager->flush();
            $this->addFlash('success', 'Modification success');
            return $this->redirectToRoute('list_user');// pas sur du nom de la route
        }
        return $this->render('admin/createStatus.twig', ["statusForm" => $form->createView(), "status"=>$status]);
    }

}

