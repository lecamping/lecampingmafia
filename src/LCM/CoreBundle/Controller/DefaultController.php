<?php

namespace LCM\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="lcm_index")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => "romain");
    }

    /**
     * @Route("/admin")
     * @Template()
     */
    public function adminAction()
    {
        return array('name' => "admin");
    }

    /**
     * @Route("/login_check")
     * @Template()
     */
    public function checksAction()
    {
        return $this->redirect($this->generateUrl('lcm_index'));
    }
}
