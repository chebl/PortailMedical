<?php

namespace Portail\FrontBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      // parent::buildForm($builder, $options);
$builder
         ->add('username',null, array('attr'=>array('class'=>'input'),'label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('attr'=>array('class'=>'input'),'label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array('attr'=>array('class'=>'input'),
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('attr'=>array('class'=>'input'),'label' => 'form.password'),
                'second_options' => array('attr'=>array('class'=>'input'),'label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))       
        ->add('nom','text',array('attr'=>array('oninvalid' =>
            'if(this.value.length==0)this.setCustomValidity(\'Le nom ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
            'class'=>'input')
                ))
        ->add('prenom','text',array('attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'Le prenom ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
                  'class'=>'input'  )
                ))
       
        
        ->add('adresse','text',array('attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'adresse ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
                 'class'=>'input'  )
                ))
        ->add('sexe', 'choice', array(
    'choices'   => array('h' => 'Homme', 'f' => 'Femme'),
    'required'  => true,))
        ->add('telephone','text',array('attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'Le telephone ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
                   'class'=>'input' )
                ))
       
        ->add('datenaissance','date',array('attr'=>array('class'=>'input'),'widget'=>'single_text',
            'format'=>'yyyy-MM-dd'))
        
       ->add('ville','choice', array(
    'choices'   => array('Tunis' => 'Tunis', 'Ariana' => 'Ariana','Tunis' => 'Tunis', 'Mannouba' => 'Mannouba','Ben Arous' => 'Ben Arous','Bizerte' => 'Bizerte','Nabeul' => 'Nabeul','Sousse' => 'Sousse','Mahdia' => 'Mahdia','Monastir' => 'Monastir','Sfax' => 'Sfax'),
    'required'  => true,))
      ->add('latitude')
      ->add('longitude');
      
        
        // add your custom field
       
    }
   public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\FrontBundle\Entity\User'
        ));
    } 
    
    public function getName()
    {
        return 'acme_user_profile';
    }
}