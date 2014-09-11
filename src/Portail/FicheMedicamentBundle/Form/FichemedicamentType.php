<?php

namespace Portail\FicheMedicamentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FichemedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prescription')
            ->add('presentation')    
            ->add('contreindication')
            ->add('posologie')
            ->add('effetindesirable')
            ->add('file')
             
               ->add('classetherapeutique') 
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\FicheMedicamentBundle\Entity\FicheMedicament'
        ));
    }

   

    public function getName() {
        return 'fichemedicament';
    }

   
}
