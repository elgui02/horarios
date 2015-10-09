<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\Evaluacion;
use Umg\VotacionBundle\Form\EvaluacionType;

/**
 * Evaluacion controller.
 *
 * @Route("/evaluacion")
 */
class EvaluacionController extends Controller
{

    /**
     * Lists all Evaluacion entities.
     *
     * @Route("/", name="evaluacion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:Evaluacion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Evaluacion entity.
     *
     * @Route("/", name="evaluacion_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:Evaluacion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Evaluacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('evaluacion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Evaluacion entity.
     *
     * @param Evaluacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Evaluacion $entity)
    {
        $user = $this->get('security.context')->getToken()->getUser()->getUserName();
        $form = $this->createForm(new EvaluacionType(array(),array('user' => $user)), $entity, array(
            'action' => $this->generateUrl('evaluacion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Evaluacion entity.
     *
     * @Route("/new", name="evaluacion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Evaluacion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Evaluacion entity.
     *
     * @Route("/{id}", name="evaluacion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Evaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Evaluacion entity.
     *
     * @Route("/{id}/edit", name="evaluacion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Evaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evaluacion entity.');
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
    * Creates a form to edit a Evaluacion entity.
    *
    * @param Evaluacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Evaluacion $entity)
    {
        $user = $this->get('security.context')->getToken()->getUser()->getUserName();
        $form = $this->createForm(new EvaluacionType(array(),array('user' => $user)), $entity, array(
            'action' => $this->generateUrl('evaluacion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing Evaluacion entity.
     *
     * @Route("/{id}", name="evaluacion_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:Evaluacion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:Evaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('evaluacion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Evaluacion entity.
     *
     * @Route("/{id}", name="evaluacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:Evaluacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evaluacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('evaluacion'));
    }

    /**
     * Creates a form to delete a Evaluacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evaluacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
