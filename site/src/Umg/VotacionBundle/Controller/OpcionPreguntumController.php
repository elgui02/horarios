<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Umg\VotacionBundle\Entity\OpcionPreguntum;
use Umg\VotacionBundle\Form\OpcionPreguntumType;

/**
 * OpcionPreguntum controller.
 *
 * @Route("/opcionpreguntum")
 */
class OpcionPreguntumController extends Controller
{

    /**
     * Lists all OpcionPreguntum entities.
     *
     * @Route("/", name="opcionpreguntum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:OpcionPreguntum')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new OpcionPreguntum entity.
     *
     * @Route("/", name="opcionpreguntum_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:OpcionPreguntum:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $opciones = ($request->request->get('umg_votacionbundle_opcionpreguntum'));
        $em->getConnection()->beginTransaction();

        try {
            
            $pregunta = $em->getRepository('UmgVotacionBundle:Preguntum')->find($opciones['preguntum']);
            foreach ($opciones['opcion'] as $valor)
            {
                $opcion = $em->getRepository('UmgVotacionBundle:Opcion')->find($valor);
                
                $entity = new OpcionPreguntum();
                $entity->setPreguntum($pregunta);
                $entity->setOpcion($opcion);
                $em->persist($entity);
                $em->flush();

            }

            $em->getConnection()->commit();
            return $this->redirect($this->generateUrl('evaluacion_show', array('id' => $pregunta->getEvaluacion()->getId())));

        } 
        catch (Exception $e) {
            $em->getConnection()->rollback();
            $entity = new OpcionPreguntum();
            $entity->setPreguntum($pregunta);
            $form   = $this->createCreateForm($entity);
        
        
            return array(
                'entity' => $entity,
                'form'   => $form->createView(),
            );        

            throw $e;
        }

    }

    /**
     * Creates a form to create a OpcionPreguntum entity.
     *
     * @param OpcionPreguntum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OpcionPreguntum $entity)
    {
        $form = $this->createForm(new OpcionPreguntumType(), $entity, array(
            'action' => $this->generateUrl('opcionpreguntum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new OpcionPreguntum entity.
     *
     * @Route("/{id}/new", name="opcionpreguntum_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pregunta = $em->getRepository('UmgVotacionBundle:Preguntum')->find($id);

        if (!$pregunta) {
            throw $this->createNotFoundException('Unable to find OpcionPreguntum entity.');
        }

        $entity = new OpcionPreguntum();
        $entity->setPreguntum($pregunta);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a OpcionPreguntum entity.
     *
     * @Route("/{id}", name="opcionpreguntum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:OpcionPreguntum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpcionPreguntum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OpcionPreguntum entity.
     *
     * @Route("/{id}/edit", name="opcionpreguntum_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:OpcionPreguntum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpcionPreguntum entity.');
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
    * Creates a form to edit a OpcionPreguntum entity.
    *
    * @param OpcionPreguntum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OpcionPreguntum $entity)
    {
        $form = $this->createForm(new OpcionPreguntumType(), $entity, array(
            'action' => $this->generateUrl('opcionpreguntum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing OpcionPreguntum entity.
     *
     * @Route("/{id}", name="opcionpreguntum_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:OpcionPreguntum:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:OpcionPreguntum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpcionPreguntum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('opcionpreguntum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a OpcionPreguntum entity.
     *
     * @Route("/{id}/delete", name="opcionpreguntum_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:OpcionPreguntum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OpcionPreguntum entity.');
            }

            $em->remove($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('evaluacion_show', array('id' => $entity->getPreguntum()->getEvaluacion()->getId())));
    }

    /**
     * Creates a form to delete a OpcionPreguntum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('opcionpreguntum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
