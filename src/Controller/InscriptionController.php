<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("inscription/{id}", requirements={"id":"\d+"}, name="inscription")
     */
    public function inscription(Request $request,EntityManagerInterface $entityManager): Response
    {
        // recuperation des sorties en BDD on veut recuperer un event precis dc => id
        $id = $request->get('id');
        $Event = $entityManager->getRepository('App:Event')->findOneBy(['id'=>$id]);
        //findbyone me renvoie qu un objet de type event

        //recuperation de l utilisateur en cours de session
        $user=$this->getUser();

        //association d un user a un evenement
        $Event->addUser($user);
        //met aussi l evenmt ds le tableau des utilisateurs
        //relation manytomany donc ds les 2 sens je dois ajouter
        $user->addInscription($Event);

        //verifie

        //
        $entityManager->persist($user);
        $entityManager->persist($Event);
        $entityManager->flush();
    $this-> addFlash('success','Inscription reussie , bien Ouej');
        return $this->render('inscription/inscription.html.twig');
    }
}
