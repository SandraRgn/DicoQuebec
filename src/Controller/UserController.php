<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user_inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);

        //pour traiter le formulaire
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            //retourne une instance de l'entity manager
            $em = $this->getDoctrine()->getManager();
            //roles est un tableau donc il faut mettre des crochets
            $user->setRoles(["ROLE_USER"]);
            //hash du mot de passe
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            //sauvegarde
            $em->persist($user);
            $em->flush();

            //message flash qui s'affichera sur la prochaine page
            $this->addFlash("success", "Merci pour votre inscription");
            return $this->redirectToRoute("login");
        }

        return $this->render('user/inscription.html.twig', ["userForm" => $userForm->createView()
        ]);
    }

    /**
     * @Route("/connexion/", name="login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $lastError = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return $this->render('user/login.html.twig', ["lastError" =>$lastError, "lastUsername" => $lastUsername
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout()
    {

        //c'est symfony qui s'occupe de tout
    }
}
