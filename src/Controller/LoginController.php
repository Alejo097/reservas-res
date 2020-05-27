<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends  AbstractController
{
    /**
    * @Route("/login", name="login") 
    */
    public function login(AuthenticationUtils $authentication)
    {
        $error = $authentication->getLastAuthenticationError();
        $lastUsername = $authentication->getLastUsername();

        return $this->render('login.html.twig', array(
            'error'=> $error, 
            'lastUsername'=> $lastUsername
        ));
    }

    /**
    * @Route("/login/admin", name="login-admin") 
    */
    public function loginAdmin(AuthenticationUtils $authentication)
    {
        $error = $authentication->getLastAuthenticationError();
        $lastUsername = $authentication->getLastUsername();

        return $this->render('login_admin.html.twig', array(
            'error'=> $error, 
            'lastUsername'=> $lastUsername
        ));
    }
}
?>