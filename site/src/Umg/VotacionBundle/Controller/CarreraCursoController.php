<?php

namespace Umg\VotacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\DBAL\Connection;
use Umg\VotacionBundle\Entity\CarreraCurso;
use Umg\VotacionBundle\Form\CarreraCursoType;
use Umg\VotacionBundle\Form\CarreraCursoEditType;

/**
 * CarreraCurso controller.
 *
 * @Route("/carreracurso")
 */
class CarreraCursoController extends Controller
{

    /**
     * Lists all CarreraCurso entities.
     *
     * @Route("/", name="carreracurso")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UmgVotacionBundle:CarreraCurso')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CarreraCurso entity.
     *
     * @Route("/", name="carreracurso_create")
     * @Method("POST")
     * @Template("UmgVotacionBundle:CarreraCurso:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cursos = ($request->request->get('umg_votacionbundle_carreracurso'));
        $em->getConnection()->beginTransaction();

        try {
            
            $carrera = $em->getRepository('UmgVotacionBundle:CampusCarrera')->find($cursos['campusCarrera']);
            foreach ($cursos['pensumAnio'] as $valor)
            {
                $curso = $em->getRepository('UmgVotacionBundle:PensumAnio')->find($valor);
                
                $entity = new CarreraCurso();
                $entity->setCampusCarrera($carrera);
                $entity->setPensumAnio($curso);
                $em->persist($entity);
                $em->flush();

            }

            $em->getConnection()->commit();
            return $this->redirect($this->generateUrl('campuscarrera_show', array('id' => $cursos['campusCarrera'])));

        } 
        catch (Exception $e) {
            $em->getConnection()->rollback();
            $entity = new CarreraCurso();
            $entity->setCampusCarrera($carrera);
            $form   = $this->createCreateForm($entity);
        
        
            return array(
                'entity' => $entity,
                'form'   => $form->createView(),
            );        

            throw $e;
        }
    }

    /**
     * Creates a form to create a CarreraCurso entity.
     *
     * @param CarreraCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CarreraCurso $entity)
    {
        $form = $this->createForm(new CarreraCursoType(), $entity, array(
            'action' => $this->generateUrl('carreracurso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new CarreraCurso entity.
     *
     * @Route("/{id}/new", name="carreracurso_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('UmgVotacionBundle:CampusCarrera')->find($id);

        if (!$carrera) {
            throw $this->createNotFoundException('Unable to find CampusCarrera entity.');
        }
        $entity = new CarreraCurso();
        $entity->setCampusCarrera($carrera);
        $form   = $this->createCreateForm($entity);
        
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to create a new CarreraCurso entity.
     *
     * @Route("/{id}/nuevo", name="carreracurso_nuevo")
     * @Method("GET")
     * @Template()
     */
    public function nuevoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('UmgVotacionBundle:Carrera')->find($id);
        $cursos = $em->getRepository('UmgVotacionBundle:PensumAnio')->findByCarrera($carrera);

        if (!$carrera) {
            throw $this->createNotFoundException('Unable to find CarreraCurso entity.');
        }
        

        return array(
            'cursos' => $cursos,
        );
    }


    /**
     * Finds and displays a CarreraCurso entity.
     *
     * @Route("/{id}", name="carreracurso_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:CarreraCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CarreraCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CarreraCurso entity.
     *
     * @Route("/{id}/edit", name="carreracurso_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:CarreraCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CarreraCurso entity.');
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
    * Creates a form to edit a CarreraCurso entity.
    *
    * @param CarreraCurso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CarreraCurso $entity)
    {
        $form = $this->createForm(new CarreraCursoEditType(), $entity, array(
            'action' => $this->generateUrl('carreracurso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'  => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing CarreraCurso entity.
     *
     * @Route("/{id}", name="carreracurso_update")
     * @Method("PUT")
     * @Template("UmgVotacionBundle:CarreraCurso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UmgVotacionBundle:CarreraCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CarreraCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('carreracurso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CarreraCurso entity.
     *
     * @Route("/{id}", name="carreracurso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UmgVotacionBundle:CarreraCurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CarreraCurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('carreracurso'));
    }

    /**
     * Creates a form to delete a CarreraCurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('carreracurso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
