<?php
namespace Portail\NewsletterBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class UserNewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
$builder
            
        ->add('$email')     
       
;
        // add your custom field
       
    }
     public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\NewsletterBundle\Entity\UserNewsletterInscris'
        ));
    }
    
    public function getName()
    {
        return 'UserNewsletter_type';
    }
}