<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/auth", name="github_redirect_url")
     */
    public function adminAuthAction()
    {
        // To avoid the ?code= url. Can be done with Javascript.
        return $this->redirectToRoute('diary');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }
}