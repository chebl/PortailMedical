<?php
namespace Portail\NewsletterBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
class NewsletterRepository extends EntityRepository  {
   
    public function ExistEmail($em,$email) {
      
        $query = $em->createQuery(
    'SELECT p.email FROM PortailNewsletterBundle:UserNewsletterInscris p
            WHERE p.email =:email')->setParameter('email',$email);
        
   return $query->getResult();   
        
        
        
    }
    
    public function ListEmail($em) {
       $query = $em->createQuery(
    'SELECT p.email FROM PortailNewsletterBundle:UserNewsletterInscris p where p.Estconfirm=1');
            
        
    return $query->getResult(Query::HYDRATE_ARRAY);
        
    }
  
}

?>
