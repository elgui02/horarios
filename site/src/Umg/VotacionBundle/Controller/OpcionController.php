<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Opcion;
use Umg\VotacionBundle\Form\OpcionType;

/**
 * Opcion controller.
 *
 * @Route("/opcion")
 */
class OpcionController extends Controller
{

    /**
     * Lists all Opcion entities.
     *
     * @Route("/", name="opcion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:Opcion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Opcion entity.
     *
     * @Route("/", name="opcion_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Opcion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Opcion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('opcion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Opcion entity.
     *
     * @param Opcion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Opcion $entity)
    {
        $form = $this->createForm(new OpcionType(), $entity, array(
            'action' => $this->generateUrl('opcion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Opcion entity.
     *
     * @Route("/new", name="opcion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Opcion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Opcion entity.
     *
     * @Route("/{id}", name="opcion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Opcion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Opcion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Opcion entity.
     *
     * @Route("/{id}/edit", name="opcion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Opcion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Opcion entity.');
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
    * Creates a form to edit a Opcion entity.
    *
    * @param Opcion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Opcion $entity)
    {
        $form = $this->createForm(new OpcionType(), $entity, array(
            'action' => $this->generateUrl('opcion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Opcion entity.
     *
     * @Route("/{id}", name="opcion_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Opcion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Opcion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Opcion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('opcion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Opcion entity.
     *
     * @Route("/{id}", name="opcion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Opcion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Opcion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('opcion'));
    }

    /**
     * Creates a form to delete a Opcion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('opcion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
