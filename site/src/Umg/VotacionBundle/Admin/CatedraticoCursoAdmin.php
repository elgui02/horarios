<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CatedraticoCursoAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('catedratico', 'sonata_type_model', array(), array('insert' => 'standard'))
            ->add('carreraCurso', 'sonata_type_model', array(), array('insert' => 'standard'))
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('catedratico')
            ->add('carreraCurso')
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('id')
            ->add('catedratico')
            ->add('carreraCurso')
        ;
    }
}