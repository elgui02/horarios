<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper; 

class CampusCarreraAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('carrera','sonata_type_model', array(), array('insert' => 'standard'))
            ->add('campus','sonata_type_model', array(), array('insert' => 'standard'))
     #       ->add('jornada','sonata_type_model',array('expanded'=>true))  
            ->add('jornada','sonata_type_model', array(), array('insert' => 'standard'))     
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('carrera')
            ->add('campus')
            ->add('jornada') 
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('id')
            ->add('carrera')
            ->add('campus')
            ->add('jornada') 
        ;
    }
}