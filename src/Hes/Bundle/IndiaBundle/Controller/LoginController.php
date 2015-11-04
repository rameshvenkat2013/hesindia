<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hes\Bundle\IndiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class LoginController extends Controller
{

    /**
     * @Route("/login_check", name="login_check")
     */

    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system

        $authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render(
                'HESIndiaBundle:hes:homepage.html.twig',
                array(
                    // last username entered by the user
                    'last_username' => $lastUsername,
                    'error'         => $error,
                )
            );
        
    }
    
    
}
?>
