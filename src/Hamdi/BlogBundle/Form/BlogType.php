<?php

namespace Hamdi\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('blog')
            ->add('file')
            ->add('tags')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hamdi\BlogBundle\Entity\Blog'
        ));
    }

    public function getName()
    {
        return 'hamdi_blogbundle_blogtype';
    }
}
