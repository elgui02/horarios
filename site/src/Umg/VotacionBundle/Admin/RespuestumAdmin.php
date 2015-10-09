<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class RespuestumAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('Respuesta')
            ->add('Pregunta_id')
            ->add('AlumnoCurso_id')
            ->add('Catedratico_id')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('Respuesta')
            ->add('Pregunta_id')
            ->add('AlumnoCurso_id')
            ->add('Catedratico_id')
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('Respuesta')
            ->add('Pregunta_id')
            ->add('AlumnoCurso_id')
            ->add('Catedratico_id')
        ;
    }
}