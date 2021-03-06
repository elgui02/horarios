<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Seccion;
use Umg\VotacionBundle\Form\SeccionType;

/**
 * Seccion controller.
 *
 * @Route("/seccion")
 */
class SeccionController extends Controller
{

    /**
     * Lists all Seccion entities.
     *
     * @Route("/", name="seccion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:Seccion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Seccion entity.
     *
     * @Route("/", name="seccion_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Seccion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Seccion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('campuscarrera_show', array('id' => $entity->getSemestre()->getCampusCarrera()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Seccion entity.
     *
     * @param Seccion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Seccion $entity)
    {
        $form = $this->createForm(new SeccionType(), $entity, array(
            'action' => $this->generateUrl('seccion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Seccion entity.
     *
     * @Route("/{id}/new", name="seccion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $semestre = $em->getRepository('UmgVotacionBundle:Semestre')->find($id);

        if (!$semestre) {
            throw $this->createNotFoundException('Unable to find Semestre entity.');
        }

        $entity = new Seccion();
        $entity->setSemestre($semestre);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Seccion entity.
     *
     * @Route("/{id}", name="seccion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Seccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Seccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Seccion entity.
     *
     * @Route("/{id}/edit", name="seccion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Seccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Seccion entity.');
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
    * Creates a form to edit a Seccion entity.
    *
    * @param Seccion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Seccion $entity)
    {
        $form = $this->createForm(new SeccionType(), $entity, array(
            'action' => $this->generateUrl('seccion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Seccion entity.
     *
     * @Route("/{id}", name="seccion_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Seccion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Seccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Seccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('seccion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Seccion entity.
     *
     * @Route("/{id}", name="seccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Seccion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Seccion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('seccion'));
    }

    /**
     * Creates a form to delete a Seccion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seccion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
