<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Jornada;
use Umg\VotacionBundle\Form\JornadaType;

/**
 * Jornada controller.
 *
 * @Route("/jornada")
 */
class JornadaController extends Controller 
{

///-------------------
    /**
     * Creates a new Jornada entity.
     *
     * @Route("/", name="jornada_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Jornada:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Jornada();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jornada_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Jornada entity.
     *
     * @param Jornada $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Jornada $entity)
    {
        $form = $this->createForm(new JornadaType(), $entity, array(
            'action' => $this->generateUrl('jornada_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Jornada entity.
     *
     * @Route("/new", name="jornada_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Jornada();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Jornada entity.
     *
     * @Route("/{id}", name="jornada_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Jornada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Jornada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Jornada entity.
     *
     * @Route("/{id}/edit", name="jornada_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Jornada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Jornada entity.');
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
    * Creates a form to edit a Jornada entity.
    *
    * @param Jornada $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Jornada $entity)
    {
        $form = $this->createForm(new JornadaType(), $entity, array(
            'action' => $this->generateUrl('jornada_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Jornada entity.
     *
     * @Route("/{id}", name="jornada_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Jornada:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Jornada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Jornada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('jornada', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Jornada entity.
     *
     * @Route("/{id}", name="jornada_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Jornada')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Jornada entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('jornada'));
    }

    /**
     * Creates a form to delete a Jornada entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jornada_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
