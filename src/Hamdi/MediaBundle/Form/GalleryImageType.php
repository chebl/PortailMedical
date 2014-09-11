<?php

namespace Hamdi\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GalleryImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('largeur')
            ->add('longueur')
            
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hamdi\MediaBundle\Entity\GalleryImage'
        ));
    }

    public function getName()
    {
        return 'hamdi_mediabundle_galleryimagetype';
    }
}
