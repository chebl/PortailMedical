<?php
namespace Portail\NewsletterBundle\Entity;
use Doctrine\ORM\EntityRepository;


class UserNewsletterInscrisRepository extends EntityRepository {
   
     public function findEmail($em,$email) {
       $query = $em->createQuery(
    'SELECT p.id FROM PortailNewsletterBundle:UserNewsletterInscris p
            WHERE p.Estconfirm=0 and p.email =:email')
               ->setParameter('email',$email);
            
        
    return $query->getResult();
        
    }
    
            
     public function update($em,$id) {
       $query = $em->createQuery(
    'update PortailNewsletterBundle:UserNewsletterInscris p set p.Estconfirm=1
            WHERE  p.id =:id')
               ->setParameter('id',$id);
            
        
    return $query->getResult();
        
    }
}

?>
