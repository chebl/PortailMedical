<?php

namespace Portail\BoiteBundle\Controller;
use Hamdi\ContactBundle\Entity\Contact;
use Hamdi\ContactBundle\Form\ContactType;

use Portail\FrontBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BoiteReceptionController extends Controller {
  
    
    public function envoiAction(Request $request) 
    {  
if ('POST' === $request->getMethod()) {
    $destinataire=$request->request->get('destinataire');
    $sujet=  $request->request->get('sujet');
    $msg=  $request->request->get('message');
  
    
   $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
    $user=$repository->findOneBy(array('username' =>$destinataire));
    
    
     $usercurrent = $this->get('security.context')->getToken()->getUser();
      
    
    $em = $this->getDoctrine()->getEntityManager();
       $email=new Contact();
       $email->setSujet($sujet);
      
       $email->setMessage($msg);
        $email->setExpediteur($usercurrent);
       $email->setDestinataire($user);
       $email->setDateenvoi(new \DateTime());
       $em->persist($email);
       $em->flush();
    $message = \Swift_Message::newInstance()
        ->setSubject($sujet)
        ->setFrom(array($usercurrent->getEmail()=>'ContactHorus'))
         ->setTo($user->getEmail())
        ->setBody($msg);
    $this->get('mailer')->send($message);
   
        
    }
    
 return $this->render('PortailFrontBundle:Accueil:validation.html.twig',array('return'=>'Message Envoyé'));   
}

public function envoicontactAction(Request $request) {
    
	  $email=new Contact();
           $form = $this->createForm(new ContactType(), $email);

       
	
    if ('POST' === $request->getMethod()) {
  
   
    $em = $this->getDoctrine()->getEntityManager();
      
	
        $form->bind($request);
           $email->setDateenvoi(new \DateTime());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();

    $message = \Swift_Message::newInstance()
        ->setSubject($email->getSujet())
        ->setFrom(array($email->getEmail()=>'ContactHorus'))
         ->setTo('lellahemhamdi@gmail.com')
        ->setBody($email->getMessage());
    $this->get('mailer')->send($message);
	 return $this->redirect($this->generateUrl('contact'));
   }
 return $this->render('PortailFrontBundle:Accueil:contact.html.twig', array(
            'entity' => $email,
            'form'   => $form->createView(), ));
    
    }
   
       
}

 public function deleteAction(Request $request)
 {
     
     
     $idEmail=$request->request->get('mailid');
      $em = $this->getDoctrine()->getManager();
	  
     $email= $this->getDoctrine()->getRepository('HamdiContactBundle:Contact')->find($idEmail);  
     
     
    
          $em ->remove($email);
           $em ->flush();
     
return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:validation.html.twig',array('return'=> 'Message Supprimé'));
    
 }   
 
 public function msgenvoiAction()
  {
     
        $user = $this->get('security.context')->getToken()->getUser();
      $repository = $this->getDoctrine()->getRepository('HamdiContactBundle:Contact');  
    $monboite=$repository->findBy(array('expediteur' => $user->getId()),array('dateenvoi' => 'DESC'));
   return $this->render('PortailBoiteBundle:BoiteReception:MailEnvoyee.html.twig',array('listEnvoyee'=>$monboite));   
    
     
     
     
 }
 
 public function listdestinataireAction(Request $request) {
 
 
         

            $term = $request->request->get('motcle');
             
           $arrayAss= $this->getDoctrine()->getRepository('PortailFrontBundle:User')
                ->createQueryBuilder('u')
         
            ->select('u.username')
            ->where('u.username LIKE :term')
            ->setParameter('term', '%'.$term.'%')
             ->getQuery()
             ->getArrayResult();
         
        // Transformer le tableau associatif en un tableau standard
        $array = array();
        foreach($arrayAss as $data)
        {
            $array[] = $data['username'];
        }
            $response = new Response(json_encode($array));
             
            $response -> headers -> set('Content-Type', 'application/json');
    
}
}
?>
