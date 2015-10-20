<?php

namespace Umg\VotacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarreraCursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campusCarrera')
            ->add('Laboratorio')
            ->add('pensumAnio','genemu_jqueryselect2_entity',array(
                'class' => 'Umg\VotacionBundle\Entity\PensumAnio',
                'empty_value' => 'Seleccione cursos',
                'required' => true,
                'multiple' => true,
                'configs' => array('width' => '1139px'),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Umg\VotacionBundle\Entity\CarreraCurso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umg_votacionbundle_carreracurso';
    }
}
