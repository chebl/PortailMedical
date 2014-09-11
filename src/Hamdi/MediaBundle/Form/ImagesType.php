<?php

namespace Hamdi\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('file','file',array('required'=>true))
            ->add('description')    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hamdi\MediaBundle\Entity\Images'
        ));
    }

    public function getName()
    {
        return 'hamdi_mediabundle_imagestype';
    }
}
