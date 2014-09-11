<?php

namespace Portail\EtablissementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('ville')
            ->add('adresse')
            ->add('telephone')
            ->add('siteweb')
              ->add('longitude')
                ->add('latitude')
                ->add('categorie')
                ->add('file')
                
            
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\EtablissementBundle\Entity\Etablissement'
        ));
    }

    public function getName()
    {
        return 'portail_etablissement';
    }
}
