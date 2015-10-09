<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Pensum;
use Umg\VotacionBundle\Form\PensumType;

/**
 * Pensum controller.
 *
 * @Route("/pensum")
 */
class PensumController extends Controller
{

    /**
     * Lists all Pensum entities.
     *
     * @Route("/", name="pensum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $dataTable = $this->get('data_tables.manager')->getTable('pensumTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        
        
        return array(
            'dataTable' => $dataTable,
        );
    }
    /**
     * Creates a new Pensum entity.
     *
     * @Route("/", name="pensum_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Pensum:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pensum();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pensum_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pensum entity.
     *
     * @param Pensum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pensum $entity)
    {
        $form = $this->createForm(new PensumType(), $entity, array(
            'action' => $this->generateUrl('pensum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr'  => array('class'=>'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Pensum entity.
     *
     * @Route("/new", name="pensum_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pensum();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pensum entity.
     *
     * @Route("/{id}", name="pensum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Pensum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pensum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

      /*  return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );*/
        $request->request->set('id',$id);
        $dataTable = $this->get('data_tables.manager')->getTable('showpensumTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        
       /* 
        return array(
            'dataTable' => $dataTable,
        );*/
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'dataTable' => $dataTable,
        );
    }

    /**
     * Displays a form to edit an existing Pensum entity.
     *
     * @Route("/{id}/edit", name="pensum_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Pensum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pensum entity.');
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
    * Creates a form to edit a Pensum entity.
    *
    * @param Pensum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pensum $entity)
    {
        $form = $this->createForm(new PensumType(), $entity, array(
            'action' => $this->generateUrl('pensum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'  => array('class'=>'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing Pensum entity.
     *
     * @Route("/{id}", name="pensum_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Pensum:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Pensum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pensum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pensum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pensum entity.
     *
     * @Route("/{id}", name="pensum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Pensum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pensum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pensum'));
    }

    /**
     * Creates a form to delete a Pensum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pensum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
