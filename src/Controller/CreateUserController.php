<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CreateUserController
 * @package App\Controller
 * @Route(path="/user",name="user")
 */
class CreateUserController extends AbstractController
{

    /* creation methode  pr ajouter un nouvel utilisateur
    *stocker en BDD
     *
    */
    /**
     * @Route(path="/create", name="create", methods={"GET","POST"})
     */
    public function createUser(Request $request, EntityManagerInterface $entityManager)
    {
        $createUser = new User();
        $form = $this->createForm(CreateUserType::class, $createUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($createUser);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout d\'un utilisateur reussie');
            return $this->redirectToRoute('home');// pas sur du nom de la route
        }
        return $this->render('create_user/createProfile.html.twig', ["form" => $form->createView()]);
    }
}
