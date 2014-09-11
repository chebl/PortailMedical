<?php
namespace Portail\NewsBundle\Entity;
use Doctrine\ORM\EntityRepository;
 
class NewsRepository extends EntityRepository
{
  public function getNews($em)
  {
   
         $query = $em->createQuery(
    'SELECT p.id as idart,p.titre,p.logo,p.extrait,p.contenu,p.datepublication FROM PortailNewsBundle:News p
            
            '
        );
    return $query->getResult();
  }
  public function getNewsOrderBy($em) {
      
  $query = $em->createQuery(
    'SELECT p FROM PortailNewsBundle:News p  ORDER BY p.datepublication DESC');
            
    return $query->getResult();
      
  }
}