<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\TipoPreguntum;
use Umg\VotacionBundle\Form\TipoPreguntumType;

/**
 * TipoPreguntum controller.
 *
 * @Route("/tipopreguntum")
 */
class TipoPreguntumController extends Controller
{

    /**
     * Lists all TipoPreguntum entities.
     *
     * @Route("/", name="tipopreguntum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:TipoPreguntum')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TipoPreguntum entity.
     *
     * @Route("/", name="tipopreguntum_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:TipoPreguntum:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TipoPreguntum();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipopreguntum_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TipoPreguntum entity.
     *
     * @param TipoPreguntum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoPreguntum $entity)
    {
        $form = $this->createForm(new TipoPreguntumType(), $entity, array(
            'action' => $this->generateUrl('tipopreguntum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TipoPreguntum entity.
     *
     * @Route("/new", name="tipopreguntum_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TipoPreguntum();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TipoPreguntum entity.
     *
     * @Route("/{id}", name="tipopreguntum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:TipoPreguntum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPreguntum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TipoPreguntum entity.
     *
     * @Route("/{id}/edit", name="tipopreguntum_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:TipoPreguntum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPreguntum entity.');
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
    * Creates a form to edit a TipoPreguntum entity.
    *
    * @param TipoPreguntum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoPreguntum $entity)
    {
        $form = $this->createForm(new TipoPreguntumType(), $entity, array(
            'action' => $this->generateUrl('tipopreguntum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TipoPreguntum entity.
     *
     * @Route("/{id}", name="tipopreguntum_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:TipoPreguntum:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:TipoPreguntum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPreguntum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tipopreguntum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TipoPreguntum entity.
     *
     * @Route("/{id}", name="tipopreguntum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:TipoPreguntum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoPreguntum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipopreguntum'));
    }

    /**
     * Creates a form to delete a TipoPreguntum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipopreguntum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
