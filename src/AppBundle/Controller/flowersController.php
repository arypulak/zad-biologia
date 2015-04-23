<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\flowers;
use AppBundle\Form\flowersType;

/**
 * flowers controller.
 *
 * @Route("/admin/flowers")
 */
class flowersController extends Controller
{

    /**
     * Lists all flowers entities.
     *
     * @Route("/", name="admin_flowers")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:flowers')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new flowers entity.
     *
     * @Route("/", name="admin_flowers_create")
     * @Method("POST")
     * @Template("AppBundle:flowers:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new flowers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_flowers_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a flowers entity.
     *
     * @param flowers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(flowers $entity)
    {
        $form = $this->createForm(new flowersType(), $entity, array(
            'action' => $this->generateUrl('admin_flowers_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new flowers entity.
     *
     * @Route("/new", name="admin_flowers_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new flowers();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a flowers entity.
     *
     * @Route("/{id}", name="admin_flowers_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:flowers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find flowers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing flowers entity.
     *
     * @Route("/{id}/edit", name="admin_flowers_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:flowers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find flowers entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a flowers entity.
    *
    * @param flowers $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(flowers $entity)
    {
        $form = $this->createForm(new flowersType(), $entity, array(
            'action' => $this->generateUrl('admin_flowers_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing flowers entity.
     *
     * @Route("/{id}", name="admin_flowers_update")
     * @Method("PUT")
     * @Template("AppBundle:flowers:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:flowers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find flowers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_flowers_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a flowers entity.
     *
     * @Route("/{id}", name="admin_flowers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:flowers')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find flowers entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_flowers'));
    }

    /**
     * Creates a form to delete a flowers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_flowers_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
