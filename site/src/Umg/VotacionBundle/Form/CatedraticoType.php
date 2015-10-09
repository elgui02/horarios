<?php

namespace Umg\VotacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatedraticoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo')
            ->add('Nombre')
            ->add('Direccion')
            ->add('Nit')
            ->add('FechaNacimiento')
            ->add('Colegiado')
            ->add('Especialidad')
            ->add('Universidad')
            ->add('Graduacion')
            ->add('Estudios')
            ->add('Logros')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Umg\VotacionBundle\Entity\Catedratico'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umg_votacionbundle_catedratico';
    }
}
