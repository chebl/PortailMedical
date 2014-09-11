<?php

namespace Portail\FrontBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class RegistrationFormType extends BaseType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
       parent::buildForm($builder, $options);
$builder
            
        ->add('nom','text',array('label'=>'Nom * :','attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'Le nom ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
             )
                ))
        ->add('prenom','text',array('label'=>'Prenom * :','attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'Le prenom ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
                    )
                ))
        ->add('profession','entity',array('class'=>'Portail\FrontBundle\Entity\Profession','attr'=>array('onchange'=>'rempliretablissement()')))
         ->add('specialite')
        ->add('adresse','text',array('label'=>'Adresse * :','attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'adresse ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
                   )
                ))
        ->add('sexe', 'choice', array(
    'choices'   => array('h' => 'Homme', 'f' => 'Femme'),
    'required'  => true,))
        ->add('telephone','text',array('label'=>'Télephone * :','attr'=>array('oninvalid' => 'if(this.value.length==0)this.setCustomValidity(\'Le telephone ne peut pas être vide\');else {this.setCustomValidity(\'\'); return false;}',
                    )
                ))
       
        ->add('datenaissance','date',array('label'=>'Date de naissance * :','widget'=>'single_text',
            'format'=>'yyyy-MM-dd'))
        
        ->add('ville','choice', array(
    'choices'   => array( 'Ariana' => 'Ariana','Ben Arous'=>'Ben Arous','Béjà'=>'Béjà','Bizerte'=>'Bizerte','El Kef'=>'El Kef','Gabes'=>'Gabes','Gafsa'=>'Gafsa','Jendouba'=>'Jendouba','Kasserine'=>'Kasserine','Kairouan'=>'Kairouan','Kebili'=>'Kebili','Mahdia'=>'Mahdia','Mannouba'=>'Mannouba','Mednine'=>'Mednine','Monastir'=>'Monastir','Nabeul'=>'Nabeul', 'Sousse'=>'Sousse','Sidi Bouzid'=> 'Sidi Bouzid','Siliana'=> 'Siliana','Sfax'=>'Sfax','Tataouine'=>'Tataouine','Tozeur'=>'Tozeur','Tunis'=>'Tunis','Zaghouan'=>'Zaghouan'),
    'required'  => true,))
        
       ->add('captcha','captcha')
        // add your custom field
       ->add('etablissement')
        ;
    }
   public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\FrontBundle\Entity\User'
        ));
    } 
    
    public function getName()
    {
        return 'acme_user_registration';
    }
}