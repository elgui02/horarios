<?php

namespace Umg\VotacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarreraCursoEditType extends AbstractType
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
                'required' => true,
                'configs' => array('width' => '1139px'),
            ))
            ->add('semestre', 'entity', array(
                'class' => 'UmgVotacionBundle:Semestre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.CampusCarrera = ? :campus')
                        ->addParameter('campus',$this->getCampusCarrera())
                },
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
