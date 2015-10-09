<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\AlumnoCurso;
use Umg\VotacionBundle\Form\AlumnoCursoType;

/**
 * AlumnoCurso controller.
 *
 * @Route("/alumnocurso")
 */
class AlumnoCursoController extends Controller
{

    /**
     * Lists all AlumnoCurso entities.
     *
     * @Route("/", name="alumnocurso")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:AlumnoCurso')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AlumnoCurso entity.
     *
     * @Route("/", name="alumnocurso_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:AlumnoCurso:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AlumnoCurso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('carreracurso_show', array('id' => $entity->getCarreraCurso()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AlumnoCurso entity.
     *
     * @param AlumnoCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AlumnoCurso $entity)
    {
        $form = $this->createForm(new AlumnoCursoType(), $entity, array(
            'action' => $this->generateUrl('alumnocurso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new AlumnoCurso entity.
     *
     * @Route("/{id}/new", name="alumnocurso_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('UmgVotacionBundle:CarreraCurso')->find($id);

        if (!$carrera) {
            throw $this->createNotFoundException('Unable to find CarreraCurso entity.');
        }

        $entity = new AlumnoCurso();
        $entity->setCarreraCurso($carrera);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AlumnoCurso entity.
     *
     * @Route("/{id}", name="alumnocurso_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:AlumnoCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AlumnoCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AlumnoCurso entity.
     *
     * @Route("/{id}/edit", name="alumnocurso_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:AlumnoCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AlumnoCurso entity.');
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
    * Creates a form to edit a AlumnoCurso entity.
    *
    * @param AlumnoCurso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AlumnoCurso $entity)
    {
        $form = $this->createForm(new AlumnoCursoType(), $entity, array(
            'action' => $this->generateUrl('alumnocurso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing AlumnoCurso entity.
     *
     * @Route("/{id}", name="alumnocurso_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:AlumnoCurso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:AlumnoCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AlumnoCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('carreracurso_show', array('id' => $entity->getCarreraCurso()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AlumnoCurso entity.
     *
     * @Route("/{id}", name="alumnocurso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:AlumnoCurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AlumnoCurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumnocurso'));
    }

    /**
     * Creates a form to delete a AlumnoCurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumnocurso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
