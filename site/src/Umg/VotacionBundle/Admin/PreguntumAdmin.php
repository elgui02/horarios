<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PreguntumAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('Pregunta')
            ->add('tipoPreguntum', 'sonata_type_model', array(), array('insert' => 'standard'))
            ->add('evaluacion', 'sonata_type_model', array(), array('insert' => 'standard'))                               
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('Pregunta')
            ->add('tipoPreguntum')
            ->add('evaluacion')              
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('id')
            ->add('Pregunta')
            ->add('tipoPreguntum')
            ->add('evaluacion')                
        ;
    }
}