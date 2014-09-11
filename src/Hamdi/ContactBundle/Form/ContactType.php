<?php

namespace Hamdi\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array(
            'required'=>false
            ))
            ->add('email','text', array(
            'required'=>false
            ))
            ->add('sujet','text', array(
            'required'=>false
            )) 
            ->add('message', 'textarea', array('required'=>false,
            //attr lets us set any key => value pair as a html attribute
            'attr' => array("cols" => "60", "rows" => 4)
            ))
            ->add('captcha', 'captcha')
            //->add('created_at')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hamdi\ContactBundle\Entity\Contact'
        ));
    }

    public function getName()
    {
        return 'hamdi_contactbundle_contacttype';
    }
}
