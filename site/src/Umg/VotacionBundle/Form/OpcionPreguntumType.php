<?php

namespace Umg\VotacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpcionPreguntumType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('preguntum')
            ->add('opcion','genemu_jqueryselect2_entity',array(
                'class' => 'Umg\VotacionBundle\Entity\Opcion',
                'empty_value' => 'Seleccione las respuestas',
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
            'data_class' => 'Umg\VotacionBundle\Entity\OpcionPreguntum'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umg_votacionbundle_opcionpreguntum';
    }
}
