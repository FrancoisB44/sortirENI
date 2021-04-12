<?php
namespace App\Controller;
use App\Entity\Role;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register( Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
    {
        $user = new User();

        //SET Role to USER
        //$roles[] = "ROLE_DISABLED";
        //$user->setRoles($roles);

        //Set admin to false/0
        $user->setAdmin(0);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //debut test image
            $image=$form->get('picture')->getData(); //recuperation fichier ds Usertype
            if($image){
                //Recupe le nom du fichier
                $originalFileName=pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
                //generer un nouveau nom unique pour l'image
                $newFileName=uniqid().'.'.$image->guessExtension();
                try{
                    //upload l image ds un dossier du projet
                    $image->move(
                        $this->getParameter('picture_profile_directory'),$newFileName);// para de direction de l'upload
                }catch (FileException $e){
                    //TODO traiter l'exception
                }
                $user->setPictureName($newFileName);
            }
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
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}