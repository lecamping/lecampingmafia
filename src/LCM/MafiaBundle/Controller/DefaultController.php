<?php

namespace LCM\MafiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LCM\MafiaBundle\Form\UserLightType;
use LCM\AdminBundle\Form\StartupType;
use LCM\AdminBundle\Entity\Startup;
use LCM\MafiaBundle\Form\MessageType;
use LCM\AdminBundle\Entity\Wall;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_mafia")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT u FROM LCMAdminBundle:User u WHERE u.bro IS NULL');
        $bros = $query->getResult();

        $user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new UserLightType(), $user);

        $startupsedit = array();
        $startups = array();
        $startups = array();
        foreach($user->getStartup() as $k => $v)
        {
            $startups[] = $v;
            $startupedit[] = $this->createForm(new StartupType(), $v)->createView();
        }

        $entity = new Startup();
        $form   = $this->createForm(new StartupType(), $entity);

    	return array('bros' => $bros, 'selectstartup' => $editForm->createView(), 'createstartup' => $form->createView(), 'startupedit' => $startupedit, 'startups' => $startups);
    }



    /**
     * @Route("/wall", name="_mafia_wall")
     * @Template()
     */
    public function wallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT w FROM LCMAdminBundle:Wall w ORDER BY w.day DESC')->setMaxResults(140);
        $msg = $query->getResult();

        $entity = new Wall();
        $newwall = $this->createForm(new MessageType(), $entity);

        return array('msg' => $msg, 'newwall' => $newwall->createView(), );
    }

    /**
     * @Route("/in/{id}", name="_mafia_inbro")
     * @Template()
     */
    public function inAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('LCMAdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        else
        {
            $entity->setBro(true);
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_mafia'));
    }

    /**
     * @Route("/update_founder", name="_mafia_updatefounder")
     * @Template()
     */
    public function updatefounderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        // Clean
        foreach($user->getStartup() as $k => $v)
        {
            $entity = $em->getRepository('LCMAdminBundle:Startup')->find($v->getId());
            if($entity)
            {
                $entity->removeFounder($user);
                $em->persist($entity);
                $em->flush();
            }
        }

        $form = $this->createForm(new UserLightType(), $user);
        $form->bind($request);

        if ($form->isValid()) {
            // Add
            foreach($user->getStartup() as $k => $v)
            {
                $entity = $em->getRepository('LCMAdminBundle:Startup')->find($v->getId());
                if($entity)
                {
                    $entity->addFounder($user);
                    $em->persist($entity);
                    $em->flush();
                }
            }
        }

        return $this->redirect($this->generateUrl('_mafia'));
    }

    /**
     * @Route("/add_startup", name="_mafia_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $entity  = new Startup();
        $form = $this->createForm(new StartupType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $entity->addFounder($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_mafia'));
    }

    /**
     * @Route("/wall/new", name="_mafia_wall_new")
     * @Template()
     */
    public function newmsgAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $entity = new Wall();
        $newwall = $this->createForm(new MessageType(), $entity);
        $newwall->bind($request);

        if ($newwall->isValid()) {
            $entity->setUser($this->get('security.context')->getToken()->getUser());
            $entity->setDay(new \DateTime('NOW'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_mafia_wall'));
    }

    /**
     * @Route("/edit_startup/{id}", name="_mafia_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $entity = $em->getRepository('LCMAdminBundle:Startup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Startup entity.');
        }

        $editForm = $this->createForm(new StartupType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_mafia'));
    }

    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
        return $this->redirect($this->generateUrl('_mafia'));
    }

    /**
     * @Route("/logout")
     * @Template()
     */
    public function logoutAction()
    {
        return $this->redirect($this->generateUrl('_mafia'));
    }
}
