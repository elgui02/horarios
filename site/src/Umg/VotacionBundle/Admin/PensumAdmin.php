<?php

namespace Umg\VotacionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PensumAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('Anio')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) 
    {
        $datagridMapper
            ->add('Anio')
        ;
    }
    protected function ConfigureListFields(ListMapper $listMapper) 
    {
        $listMapper
            ->addIdentifier('Anio')
        ;
    }
}