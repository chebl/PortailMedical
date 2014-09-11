<?php

namespace Portail\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FichemaladieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('description')
            ->add('extrait')    
            ->add('file')
            ->add('causes')
            ->add('symptomes')
            ->add('prevention')
                
            
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\FrontBundle\Entity\FicheMaladie'
        ));
    }

   

    public function getName() {
        return 'fichemaladie';
    }
}
