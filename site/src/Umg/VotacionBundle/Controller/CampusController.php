<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Campus;
use Umg\VotacionBundle\Form\CampusType;

/**
 * Campus controller.
 *
 * @Route("/campus")
 */
class CampusController extends Controller
{

    /**
     * Lists all Campus entities.
     *
     * @Route("/", name="campus")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $dataTable = $this->get('data_tables.manager')->getTable('campusTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        
        
        return array(
            'dataTable' => $dataTable,
        );
    }
    /**
     * Creates a new Campus entity.
     *
     * @Route("/", name="campus_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Campus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Campus();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('campus_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Campus entity.
     *
     * @param Campus $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Campus $entity)
    {
        $form = $this->createForm(new CampusType(), $entity, array(
            'action' => $this->generateUrl('campus_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Campus entity.
     *
     * @Route("/new", name="campus_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Campus();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Campus entity.
     *
     * @Route("/{id}", name="campus_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Campus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        $request->request->set('id',$id);
        $dataTable = $this->get('data_tables.manager')->getTable('showcampusTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'dataTable'   => $dataTable,
        );
    }

    /**
     * Displays a form to edit an existing Campus entity.
     *
     * @Route("/{id}/edit", name="campus_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Campus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campus entity.');
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
    * Creates a form to edit a Campus entity.
    *
    * @param Campus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Campus $entity)
    {
        $form = $this->createForm(new CampusType(), $entity, array(
            'action' => $this->generateUrl('campus_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Campus entity.
     *
     * @Route("/{id}", name="campus_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Campus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Campus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('campus_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Campus entity.
     *
     * @Route("/{id}", name="campus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Campus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Campus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('campus'));
    }

    /**
     * Creates a form to delete a Campus entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campus_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
