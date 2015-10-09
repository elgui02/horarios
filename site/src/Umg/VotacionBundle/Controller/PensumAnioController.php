<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\PensumAnio;
use Umg\VotacionBundle\Form\PensumAnioType;

/**
 * PensumAnio controller.
 *
 * @Route("/pensumanio")
 */
class PensumAnioController extends Controller
{

    /**
     * Lists all PensumAnio entities.
     *
     * @Route("/", name="pensumanio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:PensumAnio')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PensumAnio entity.
     *
     * @Route("/", name="pensumanio_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:PensumAnio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PensumAnio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pensumanio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PensumAnio entity.
     *
     * @param PensumAnio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PensumAnio $entity)
    {
        $form = $this->createForm(new PensumAnioType(), $entity, array(
            'action' => $this->generateUrl('pensumanio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new PensumAnio entity.
     *
     * @Route("/{id}/new", name="pensumanio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pensum = $em->getRepository('UmgVotacionBundle:Pensum')->find($id);

        if (!$pensum) {
            throw $this->createNotFoundException('Unable to find PensumAnio entity.');
        }

        $entity = new PensumAnio();
        $entity->setPensum($pensum);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PensumAnio entity.
     *
     * @Route("/{id}", name="pensumanio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:PensumAnio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PensumAnio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PensumAnio entity.
     *
     * @Route("/{id}/edit", name="pensumanio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:PensumAnio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PensumAnio entity.');
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
    * Creates a form to edit a PensumAnio entity.
    *
    * @param PensumAnio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PensumAnio $entity)
    {
        $form = $this->createForm(new PensumAnioType(), $entity, array(
            'action' => $this->generateUrl('pensumanio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing PensumAnio entity.
     *
     * @Route("/{id}", name="pensumanio_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:PensumAnio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:PensumAnio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PensumAnio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pensumanio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PensumAnio entity.
     *
     * @Route("/{id}", name="pensumanio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:PensumAnio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PensumAnio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pensumanio'));
    }

    /**
     * Creates a form to delete a PensumAnio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pensumanio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
