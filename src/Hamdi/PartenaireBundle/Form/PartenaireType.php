<?php

namespace Hamdi\PartenaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('site','url', array('default_protocol' => 'http', 'max_length' => 120, 'required' => false))
            ->add('file')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hamdi\PartenaireBundle\Entity\Partenaire'
        ));
    }

    public function getName()
    {
        return 'hamdi_partenairebundle_partenairetype';
    }
}
