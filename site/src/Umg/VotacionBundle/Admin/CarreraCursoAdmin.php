<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CarreraCursoAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('campusCarrera', 'sonata_type_model', array(), array('insert' => 'standard'))
                ->add('pensumAnio', 'sonata_type_model', array(), array('insert' => 'standard'))
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('campusCarrera')
            ->add('pensumAnio')
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('id')
            ->add('campusCarrera')
            ->add('pensumAnio')
        ;
    }
}