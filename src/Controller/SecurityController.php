<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request ;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
	 * @Route ("/inscription" , name ="app_inscription")
	 */
	public function ajouterUser(Request $requete, EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder )
	{
        // Création un utilisateur vide
        $user = new User ();

        $formulaireUser = $this -> createForm (UserType::class,$user);
        $formulaireUser-> handleRequest ( $requete);

        if($formulaireUser->isSubmitted() && $formulaireUser->isValid())
        {

        // Enregistrer la ressource en BD
        $user->setRoles(['ROLE_USER']);
        //Encoder le mot de passe de l'utilisateur
        $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodagePassword);
        $manager -> persist ($user);
        $manager -> flush ();
        // Rediriger l' utilisateur vers la page affichant la liste des ressources
        return $this -> redirectToRoute ('accueil');


        }
        // Afficher la page d'ajout d'un utilisateur
        return $this -> render ('security/inscription.html.twig ',
        ['vueFormulaireUser' => $formulaireUser -> createView ()]);
	}
}
