<?php

namespace Portail\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
class UserType extends AbstractType
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    private function getGroupes()
   {
        $choix = array();
        $groupes = $this->doctrine->getRepository('PortailFrontBundle:District')->findAll();

        foreach ($groupes as $group) {
            $choix[$group->getId()] = $group->getName();
        }

        return $choix;
    } 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $choices = array('h'=>'Homme','f'=>'Femme');
        $roles = array('ROLE_SUPER_ADMIN'=>'ROLE_SUPER_ADMIN','ROLE_ADMIN'=>'ROLE_ADMIN','ROLE_USER'=>'ROLE_USER',
            'ROLE_MODERATEUR'=>'ROLE_MODERATEUR','ROLE_AUTEUR'=>'ROLE_AUTEUR');
        
        $builder
            ->add('username')
            
            ->add('email')
            
            ->add('enabled')
            
            ->add('roles', 'choice', array(
            'choices' => $roles,
            'multiple' => true,
            'expanded' => true,
        )) 
            
            ->add('nom')
            ->add('logo')
            ->add('prenom')
            ->add('adresse')
            ->add('ville')
            ->add('telephone')
            ->add('datenaissance')
            ->add('sexe','choice',array(
                  'choices'  => $choices,
                  'expanded' => true,
                ))
                     
            ->add('profession')
            ->add('specialite')
            
            ->add('groups', 'choice', array(
                    'choices' => getGroupes(),
                    'multiple' => true,
                    'expanded' => true,
                 )) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portail\FrontBundle\Entity\User',
            
        ));
    }

    public function getName()
    {
        return 'portail_frontbundle_usertype';
    }
    
}
