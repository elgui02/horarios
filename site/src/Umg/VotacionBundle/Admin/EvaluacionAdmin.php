<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class EvaluacionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('Activa')
            ->add('FechaHora')
            ->add('FechaHoraFinal')
            ->add('campusCarrera')                
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('Activa')
            ->add('FechaHora')
            ->add('FechaHoraFinal')
            ->add('campusCarrera')  
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('id')
            ->add('Activar')
            ->add('FechaHora')
            ->add('FechaHoraFinal')
            ->add('campusCarrera')  
        ;
    }
}