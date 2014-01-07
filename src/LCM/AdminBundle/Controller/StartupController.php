<?php

namespace LCM\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LCM\AdminBundle\Entity\Startup;
use LCM\AdminBundle\Form\StartupType;

/**
 * Startup controller.
 *
 * @Route("/startup")
 */
class StartupController extends Controller
{
    /**
     * Lists all Startup entities.
     *
     * @Route("/", name="startup")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LCMAdminBundle:Startup')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Startup entity.
     *
     * @Route("/{id}/show", name="startup_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LCMAdminBundle:Startup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Startup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Startup entity.
     *
     * @Route("/new", name="startup_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Startup();
        $form   = $this->createForm(new StartupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Startup entity.
     *
     * @Route("/create", name="startup_create")
     * @Method("POST")
     * @Template("LCMAdminBundle:Startup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Startup();
        $form = $this->createForm(new StartupType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('startup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Startup entity.
     *
     * @Route("/{id}/edit", name="startup_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LCMAdminBundle:Startup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Startup entity.');
        }

        $editForm = $this->createForm(new StartupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Startup entity.
     *
     * @Route("/{id}/update", name="startup_update")
     * @Method("POST")
     * @Template("LCMAdminBundle:Startup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LCMAdminBundle:Startup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Startup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new StartupType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('startup_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Startup entity.
     *
     * @Route("/{id}/delete", name="startup_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LCMAdminBundle:Startup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Startup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('startup'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
