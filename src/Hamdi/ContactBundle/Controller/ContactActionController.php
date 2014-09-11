<?php

namespace Hamdi\ContactBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hamdi\ContactBundle\Form\ContactType;
use Hamdi\ContactBundle\Entity\Contact;

class ContactActionController extends Controller
{
    public function indexAction()
    {
      //use the createForm method to get a symfony form instance of our form
       $form = $this->createForm(new ContactType());
       return $this->render('HamdiContactBundle:ContactAction:index.html.twig',
       array(
       //pass the form to our template, must be a form view using ->createView()
       'form' => $form->createView()
        ));
       
    }
    
    public function submitAction()
    {
      $contact = new Contact();
      $form = $this->createForm(new ContactType(),$contact);
      $form->bind($this->getRequest());

      if($form->isValid()){
       //Get the entity manager and persist the contact
       $em = $this->getDoctrine()->getManager();
       $em->persist($contact);
       $em->flush();
       
       $response = $this->render(
       $this->container->getParameter('contact.notification_template'),
       array('contact' => $contact)
       );
       //Redirect the user and add a thank you message
        $message1 = $this->get('translator')->trans('ContactThanksMessage');
        $this->get("session")->setFlash('contact_thanks', $message1);
       //Redirect the user and add a thank you flash message
       $notification = \Swift_Message::newInstance()
            ->setSubject($message1)
            ->setFrom($contact->getEmail())
            ->setTo('lellahemhamdi@gmail.com')
            ->setBody($response->getContent(), 'text/html');
        $this->get('mailer')->send($notification);

                

       $response1 = $this->render(
       $this->container->getParameter('contact.confirmation_template'),
       array('contact' => $contact)
       );
        //Redirect the user and add a thank you message
        $message3 = $this->get('translator')->trans('ContactThanksMessage');
        $this->get("session")->setFlash('contact_thanks', $message3);
          //Send the contacter a message with translation subject
         $confirmation = \Swift_Message::newInstance()
            ->setSubject($message3)
            ->setFrom(array('lellahemhamdi@gmail.com'=>'Portail Medical'))
            ->setTo($contact->getEmail())
            ->setBody($response1->getContent(), 'text/html');
        $this->get('mailer')->send($confirmation);

        
        
        return $this->redirect($this->generateUrl("hamdi_contact"));
       }

      //$content= 
      return $this->render('HamdiContactBundle:ContactAction:index.html.twig',array(
         'form' => $form->createView()
         ));
      //return new response($content);
    }
    
    
    public function EnvoiAction()
    {
        $suj=$this->getRequest()->request->get('suj');
        $email=$this->getRequest()->request->get('email');
        $msg=$this->getRequest()->request->get('msg');
                
         $confirmation = \Swift_Message::newInstance()
            ->setSubject($suj)
            ->setFrom(array('lellahemhamdi@gmail.com'=>'Portail Medical'))
            ->setTo($email)
            ->setBody($msg, 'text/html');
        $this->get('mailer')->send($confirmation);
        
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('HamdiContactBundle:Contact')->findAll();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        
      //$content= 
       return $this->render('HamdiContactBundle:Contact:index.html.twig',array('user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,'entities'=>$entities));
      //return new response($content);
    }
    
    public function RepondreAction()
    {
        $id=$this->getRequest()->get('id');
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $myMsg = $em->getRepository('HamdiContactBundle:Contact')->find($id);
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        
      //$content= 
      return $this->render('HamdiContactBundle:Contact:repondre.html.twig',array('user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,'msg'=>$myMsg));
      //return new response($content);
    }
    
}
?>
