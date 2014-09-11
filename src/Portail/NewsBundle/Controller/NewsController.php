<?php

namespace Portail\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
  
  public function indexAction() 
  {
   $em = $this->getDoctrine()->getManager();
       
  
   $news= $this->getDoctrine()->getRepository('PortailNewsBundle:News')->createQueryBuilder('p')
   ->select('p')
   ->addOrderBy('p.datepublication','DESC')
   ->setMaxResults(3)
   ->getQuery()->getResult();
  $restenews= $this->getDoctrine()->getRepository('PortailNewsBundle:News')->createQueryBuilder('p')
   ->select('p')
   ->addOrderBy('p.datepublication','DESC')
   ->setFirstResult(3)
   ->setMaxResults(50)
   ->getQuery()->getResult();
  

 $partenaires = $this->getDoctrine()->getRepository('HamdiPartenaireBundle:Partenaire')->findAll();
        return $this->render('PortailFrontBundle:Accueil:index.html.twig',array('news'=>$news,'restenews'=>$restenews,'partenaires'=>$partenaires));
            
  }
  
  
public function LireSuiteAction($idnews)
{
     $em = $this->getDoctrine()->getManager();
       
    $entity = $em->getRepository('PortailNewsBundle:News')->find($idnews);
//print_r ($entity,false);
   $entitylast = $em->getRepository('PortailNewsBundle:News')->getNewsOrderBy($em);
   
       return $this->render('PortailNewsBundle:News:Readmore.html.twig', array(
            'entities'=>$entity,
            'entitylast'=>$entitylast)
           ); 
}
public function getLatestNewsAction() {
 $em = $this->getDoctrine()->getManager();
       
  
   $news= $this->getDoctrine()->getRepository('PortailNewsBundle:News')->createQueryBuilder('p')
   ->select('p')
   ->addOrderBy('p.datepublication','DESC')
   ->setMaxResults(5)
   ->getQuery()->getResult();
      return $this->render('PortailNewsBundle:News:lastnews.html.twig',array('news'=>$news));
            
}

}
