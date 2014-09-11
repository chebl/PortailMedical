<?php

namespace Portail\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = array('ROLE_SUPER_ADMIN'=>'ROLE_SUPER_ADMIN','ROLE_ADMIN'=>'ROLE_ADMIN','ROLE_USER'=>'ROLE_USER',
            'ROLE_MODERATEUR'=>'ROLE_MODERATEUR','ROLE_AUTEUR'=>'ROLE_AUTEUR');
        $builder
            ->add('name')
            ->add('roles', 'choice', array(
            'choices' => $roles,
            'multiple' => true,
            'expanded' => true,
        )) 
          ;      
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\FrontBundle\Entity\Group'
        ));
    }

    public function getName()
    {
        return 'portail_frontbundle_grouptype';
    }
}
