<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Animals;
use AppBundle\Form\AnimalsType;

/**
 * Animals controller.
 *
 * @Route("/admin/animals")
 */
class AnimalsController extends Controller
{

    /**
     * Lists all Animals entities.
     *
     * @Route("/", name="admin_animals")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Animals')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Animals entity.
     *
     * @Route("/", name="admin_animals_create")
     * @Method("POST")
     * @Template("AppBundle:Animals:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Animals();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_animals_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Animals entity.
     *
     * @param Animals $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Animals $entity)
    {
        $form = $this->createForm(new AnimalsType(), $entity, array(
            'action' => $this->generateUrl('admin_animals_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Animals entity.
     *
     * @Route("/new", name="admin_animals_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Animals();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Animals entity.
     *
     * @Route("/{id}", name="admin_animals_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Animals')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Animals entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Animals entity.
     *
     * @Route("/{id}/edit", name="admin_animals_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Animals')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Animals entity.');
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
    * Creates a form to edit a Animals entity.
    *
    * @param Animals $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Animals $entity)
    {
        $form = $this->createForm(new AnimalsType(), $entity, array(
            'action' => $this->generateUrl('admin_animals_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Animals entity.
     *
     * @Route("/{id}", name="admin_animals_update")
     * @Method("PUT")
     * @Template("AppBundle:Animals:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Animals')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Animals entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_animals_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Animals entity.
     *
     * @Route("/{id}", name="admin_animals_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Animals')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Animals entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_animals'));
    }

    /**
     * Creates a form to delete a Animals entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_animals_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
