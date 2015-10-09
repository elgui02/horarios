<?php

namespace Umg\VotacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RespuestumType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Respuesta')
            ->add('Pregunta_id')
            ->add('AlumnoCurso_id')
            ->add('Catedratico_id')
            ->add('preguntum')
            ->add('alumnoCurso')
            ->add('catedratico')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Umg\VotacionBundle\Entity\Respuestum'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umg_votacionbundle_respuestum';
    }
}
