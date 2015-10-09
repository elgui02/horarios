<?php

namespace Umg\VotacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlumnoCursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Alumno_id')
            ->add('CatedraticoCurso_id')
            ->add('alumno')
            ->add('catedraticoCurso')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Umg\VotacionBundle\Entity\AlumnoCurso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umg_votacionbundle_alumnocurso';
    }
}
