<?php

namespace LCM\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LCM\AdminBundle\Entity\Wall;
use LCM\AdminBundle\Form\WallType;

/**
 * Wall controller.
 *
 * @Route("/wall")
 */
class WallController extends Controller
{
    /**
     * Lists all Wall entities.
     *
     * @Route("/", name="wall")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LCMAdminBundle:Wall')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Wall entity.
     *
     * @Route("/{id}/show", name="wall_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LCMAdminBundle:Wall')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wall entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Wall entity.
     *
     * @Route("/new", name="wall_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Wall();
        $form   = $this->createForm(new WallType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Wall entity.
     *
     * @Route("/create", name="wall_create")
     * @Method("POST")
     * @Template("LCMAdminBundle:Wall:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Wall();
        $form = $this->createForm(new WallType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('wall_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Wall entity.
     *
     * @Route("/{id}/edit", name="wall_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LCMAdminBundle:Wall')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wall entity.');
        }

        $editForm = $this->createForm(new WallType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Wall entity.
     *
     * @Route("/{id}/update", name="wall_update")
     * @Method("POST")
     * @Template("LCMAdminBundle:Wall:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LCMAdminBundle:Wall')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wall entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new WallType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('wall_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Wall entity.
     *
     * @Route("/{id}/delete", name="wall_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LCMAdminBundle:Wall')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Wall entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('wall'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
