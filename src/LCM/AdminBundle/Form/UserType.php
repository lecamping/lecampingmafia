<?php

namespace LCM\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('lastLogin')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpireAt')
            ->add('firstname')
            ->add('lastname')
            ->add('facebookId')
            ->add('startup')
            ->add('emailCanonical', 'text', array('required' => false))
            ->add('enabled', 'checkbox', array('required' => false))
            ->add('password', 'text', array('required' => false))
            ->add('locked', 'checkbox', array('required' => false))
            ->add('bro', 'checkbox', array('required' => false))
            ->add('expired', 'checkbox', array('required' => false))
            ->add('credentialsExpired', 'checkbox', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LCM\AdminBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lcm_adminbundle_user';
    }
}
