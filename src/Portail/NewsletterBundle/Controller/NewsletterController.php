<?php

namespace Portail\NewsletterBundle\Controller;
use Portail\NewsletterBundle\Entity\UserNewsletterInscris;
use Portail\NewsletterBundle\Entity\Newsletter;
use Portail\NewsletterBundle\Form\Type\NewsletterType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends Controller
{
   public function ajouterAction() {
       
         $entity = new Newsletter();
        $form   = $this->createForm(new NewsletterType(), $entity);

        return $this->render('PortailNewsletterBundle:Newsletter:ajouter.html.twig', array(
             
            'form'   => $form->createView(),
        ));
       
       }
   
   public function inscrireAction(Request $request) {
         if ('POST' === $request->getMethod()) {
        $email=$_POST['email'];
          $em = $this->getDoctrine()->getEntityManager();
      $entity = $em->getRepository('PortailNewsletterBundle:Newsletter')->ExistEmail($em, $email);
       if(!$entity) {    
        $entity1=new UserNewsletterInscris();
        $entity1->setEstconfirm(false);
        $entity1->setEmail( $email);
    $em->persist($entity1);
     $message = \Swift_Message::newInstance()
        ->setSubject('Confirmation d"inscription Newsletter')
        ->setFrom(array('chebl.mahmoud@gmail.com'=>'PortailHorus'))
        ->setTo($email)
        ->setBody($this->renderView(
          'PortailNewsletterBundle:Newsletter:confirm.html.twig',array('email'=>$email)),'text/html');
      $this->get('mailer')->send($message);
             
    $em->flush();
       } 
        return $this->redirect($this->generateUrl('portail_front_homepage'));
    }
       return $this->redirect($this->generateUrl('portail_front_homepage'));
       
      
       
   }    
       
   public function listAction() {
         $em = $this->getDoctrine()->getEntityManager();
        $entity =$em->getRepository('PortailNewsletterBundle:Newsletter')-> findAll();
        return $this->render('PortailNewsletterBundle:Newsletter:Liste.html.twig',array(
         
       'entities'   =>$entity));
       
   } 
  public function envoiAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $entity=$em->getRepository('PortailNewsletterBundle:Newsletter')->find($id);
        $entity->setEnvoi(true);
        $em->flush();
      $listinscris =$em->getRepository('PortailNewsletterBundle:Newsletter')-> ListEmail($em);
     $list=array();
     foreach ($listinscris as $i => $value) {
    $list[$i]=$listinscris[$i]['email'];
    }
    
     
 $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom(array('chebl.mahmoud@gmail.com'=>'PortailHorus'))
      
         ->setTo($list)
        ->setBody($this->renderView(
          'PortailNewsletterBundle:Newsletter:Newsletter.html.twig'),'text/html'
            
        );
    $this->get('mailer')->send($message);
    $entity =$em->getRepository('PortailNewsletterBundle:Newsletter')-> findAll();
     return $this->render('PortailNewsletterBundle:Newsletter:Liste.html.twig',array(
         
       'entities'   =>$entity));
      
  } 
   public function creerAction(Request $request) {
       
        $entity  = new Newsletter();
        $entity->setDateCreation(new \DateTime());
        $entity->setDateModification(new \DateTime());
        $entity->setEnvoi(false);
        $form    = $this->createForm(new NewsletterType(), $entity);
  $request = $this->getRequest();
  
  if('POST'===$request->getMethod()) {
     
  $form->bindRequest($request);
 
  if ($form->isValid()) {
     
    $em = $this->getDoctrine()->getEntityManager();
      $em->persist($entity);
    $em->flush();
  }
    $entity =$em->getRepository('PortailNewsletterBundle:Newsletter')->findAll();
   return $this->render('PortailNewsletterBundle:Newsletter:Liste.html.twig', array(
             'entities' => $entity));
        
       
   }
   
   return $this->render('PortailNewsletterBundle:Newsletter:ajouter.html.twig',array(
         
       'form'   => $form->createView()
           ));
   
       
   }     
  
   

public function confirmAction($email)
{   
    
     $em = $this->getDoctrine()->getEntityManager();
    
    $entity = $em->getRepository('PortailNewsletterBundle:UserNewsletterInscris')->findEmail( $em,$email);
       if($entity!=null) { 
           

 $entity1=$em->getRepository('PortailNewsletterBundle:UserNewsletterInscris')->update($em,$entity[0]['id']);
         
      
  $em->flush($entity1);
   
    return $this->render('PortailNewsletterBundle:Newsletter:confirmNewsletter.html.twig');
}
  
}


}
