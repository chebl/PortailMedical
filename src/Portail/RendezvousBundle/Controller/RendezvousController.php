<?php
namespace Portail\RendezvousBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Portail\RendezvousBundle\Entity\Rendezvous;
use Doctrine\ORM\Mapping as ORM;
class RendezvousController extends Controller
{
    
        public function demanderendezvousAction(Request $request) 
    {  
if ('POST' === $request->getMethod()) {
    $destinataire=$request->request->get('destinataire');
    $date=$request->request->get('date');
    $msg=  $request->request->get('message');
  
    
   $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
    $user=$repository->findOneBy(array('username' =>$destinataire));
    
    
     $usercurrent = $this->get('security.context')->getToken()->getUser();
      
    
    $em = $this->getDoctrine()->getEntityManager();
       $rendevous=new Rendezvous();
       $rendevous->setMessageexpediteur($msg);
      
        $rendevous->setExpediteur($usercurrent);
       $rendevous->setDestinataire($user);
       $rendevous->setDateenvoi(new \DateTime());
       $rendevous->setEstfixe(false);
       $rendevous->setDaterendezvous(new \DateTime($date));
       $em->persist($rendevous);
       $em->flush();
    $message = \Swift_Message::newInstance()
        ->setSubject('Demande Rendez-vous')
        ->setFrom(array($usercurrent->getEmail()=>'PortailHorus'))
         ->setTo($user->getEmail())
        ->setBody($msg+"<br><label>Date souhaité pour le rendezvous :</label>"+$date);
    $this->get('mailer')->send($message);
   
        
    }
    
 return $this->render('PortailFrontBundle:Accueil:validation.html.twig',array('return'=>'Message Envoyé'));   
}
public function rendezvousreçuAction() {
  $user = $this->get('security.context')->getToken()->getUser();
      $repository = $this->getDoctrine()->getRepository('PortailRendezvousBundle:Rendezvous');  
    $mesrendezvous=$repository->findBy(array('expediteur' => $user->getId()),array('daterendezvous' => 'DESC'));
   return $this->render('PortailRendezvousBundle::Rendezvousreçu.html.twig',array('listrendezvous'=>$mesrendezvous));   
    
}
public function acceptAction() {
    
   return $this->render('PortailRendezvousBundle::formaccept.html.twig',array('expediteur'=>$_POST['expediteur'],'idrendezvous'=>$_POST['idrendezvous']));   
    
}

public function validAction(Request $request) {
    if('POST'===$request->getMethod()) {
        //echo "<script>alert('fff');</script>";
     $em = $this->getDoctrine()->getEntityManager();
    $idrdv=  $request->request->get('idrdv');
    $msg=  $request->request->get('msg');
    $daterdv=$request->request->get('daterendezvous');
  $expediteur=$request->request->get('expediteur');
    $user=$this->getDoctrine()->getRepository('PortailFrontBundle:User')->findOneBy(array('username' =>$expediteur));
       $rdv = $this->getDoctrine()->getRepository('PortailRendezvousBundle:Rendezvous')->find( $idrdv);  
      $usercurrent=$this->get('security.context')->getToken()->getUser();
        
         $rdv-> setMessagedestinataire($msg);
        $rdv-> setDaterendezvous(new \DateTime( $daterdv));
        $rdv->setDateenvoi(new \DateTime());
        $rdv->setEstfixe(true);
        
        $em->persist($rdv);
       $em->flush();
       $message = \Swift_Message::newInstance()
        ->setSubject('Validation date de Rendez-vous')
               
        ->setFrom(array($usercurrent->getEmail()=>'PortailHorus'))
         ->setTo($user->getEmail())
        ->setBody($msg);
    $this->get('mailer')->send($message);
      
       
    }
      return $this->render('PortailRendezvousBundle::validationRendezvous.html.twig',array('return'=>'Rendez-Vous validé'));
    
}

public function listvalideAction()
{
    
    $user = $this->get('security.context')->getToken()->getUser();
      $repository = $this->getDoctrine()->getRepository('PortailRendezvousBundle:Rendezvous');  
    $mesrendezvous=$repository->findBy(array('destinataire' =>$user->getId(),'estfixe'=>1),array('daterendezvous' => 'DESC'));
    return $this->render('PortailRendezvousBundle::listerdvvalide.html.twig',array('mrendezvous'=>$mesrendezvous));
}

public function validerdvAction(Request $request) {
   
    $idrdv=$request->request->get('idrdv');
    $expediteur=$request->request->get('expediteur');
    
  return $this->render('PortailRendezvousBundle::lancerframe.html.twig',array('idrdv'=>$idrdv,'expediteur'=>$expediteur));
  
    
}
public function deleteAction() {
    
             $user = $this->get('security.context')->getToken()->getUser();
         $request = $this->get('request');
         $em = $this->getDoctrine()->getManager();
           $id=$request->request->get('idrdv');
           $rendezvous = $this->getDoctrine()->getRepository('PortailRendezvousBundle:Rendezvous')->find($id);  
    
           $em->remove($rendezvous);
            $em->flush();
           //}
       return true;
    
}
}
?>
