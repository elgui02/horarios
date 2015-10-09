<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Respuestum;
use Umg\VotacionBundle\Form\RespuestumType;

/**
 * Respuestum controller.
 *
 * @Route("/respuestum")
 */
class RespuestumController extends Controller
{

    /**
     * Lists all Respuestum entities.
     *
     * @Route("/", name="respuestum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:Respuestum')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Respuestum entity.
     *
     * @Route("/", name="respuestum_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Respuestum:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Respuestum();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('respuestum_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Respuestum entity.
     *
     * @param Respuestum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Respuestum $entity)
    {
        $form = $this->createForm(new RespuestumType(), $entity, array(
            'action' => $this->generateUrl('respuestum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Respuestum entity.
     *
     * @Route("/new", name="respuestum_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Respuestum();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Respuestum entity.
     *
     * @Route("/{id}", name="respuestum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Respuestum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuestum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Respuestum entity.
     *
     * @Route("/{id}/edit", name="respuestum_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Respuestum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuestum entity.');
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
    * Creates a form to edit a Respuestum entity.
    *
    * @param Respuestum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Respuestum $entity)
    {
        $form = $this->createForm(new RespuestumType(), $entity, array(
            'action' => $this->generateUrl('respuestum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Respuestum entity.
     *
     * @Route("/{id}", name="respuestum_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Respuestum:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Respuestum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuestum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('respuestum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Respuestum entity.
     *
     * @Route("/{id}", name="respuestum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Respuestum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Respuestum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('respuestum'));
    }

    /**
     * Creates a form to delete a Respuestum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('respuestum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
