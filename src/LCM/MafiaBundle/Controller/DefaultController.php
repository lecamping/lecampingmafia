<?php

namespace LCM\MafiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    	echo "Hello";
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('_admin'));
        die();
    }

    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
    }

    /**
     * @Route("/logout")
     * @Template()
     */
    public function logoutAction()
    {
    }
}
