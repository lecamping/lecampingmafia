<?php

namespace LCM\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StartupType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('season')
            ->add('pitch')
            ->add('website')
            ->add('status')
            ->add('socialnetworks')
            ->add('founders')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LCM\AdminBundle\Entity\Startup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lcm_adminbundle_startup';
    }
}
