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
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s FROM LCMAdminBundle:Startup s ORDER BY s.season DESC, s.name');
        $startups = $query->getResult();
        return array('startups' => $startups);
    }

    /**
     * @Route("/en", name="lcm_index_en")
     * @Template()
     */
    public function indexenAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s FROM LCMAdminBundle:Startup s ORDER BY s.season DESC, s.name');
        $startups = $query->getResult();
        return array('startups' => $startups);
    }

    /**
     * @Route("/fr", name="lcm_index_fr")
     * @Template()
     */
    public function indexfrAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s FROM LCMAdminBundle:Startup s ORDER BY s.season DESC, s.name');
        $startups = $query->getResult();
        return array('startups' => $startups);
    }

    /**
     * @Route("/login_check")
     * @Template()
     */
    public function checksAction()
    {
        return $this->redirect($this->generateUrl('lcm_index'));
    }

    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
        return $this->redirect($this->generateUrl('lcm_index'));
    }
}
