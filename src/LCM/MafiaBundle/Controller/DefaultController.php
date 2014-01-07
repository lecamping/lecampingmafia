<?php

namespace LCM\MafiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
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
