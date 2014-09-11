<?php

namespace Portail\AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Hamdi\ContactBundle\Entity\Contact;
use Portail\FrontBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
 use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
         
class AnnuaireController extends Controller
{
    public function AnnuairemedecinAction($page)
    {
        
     
       
$em = $this->getDoctrine()->getRepository('PortailFrontBundle:User'); 
$professionmedecin= $this->getDoctrine()->getRepository('PortailFrontBundle:Profession')->findOneBy(array('designation'=>'Médecin')); 

$adapter = new ArrayAdapter($em->findBy(array('enabled' =>1,'profession'=>$professionmedecin->getId())));
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 
            
            
            
$specialite = $this->getDoctrine()->getRepository('PortailFrontBundle:Specialite')->findAll();

        return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:RechercheParcarte.html.twig',array('specialite'=>$specialite,'pager' => $pager,'Medecins'=>'Médecins'));
    }
    
     
    
    
    
    
    public function findMedecinParregionAction($ville,$page) {
       
        
/*         $query = $this->getDoctrine()->getEntityManager()
->createQuery(
'SELECT u FROM PortailFrontBundle:User u WHERE u.enabled = 1 and u.profession:=profession and  u.adresse like :adresse')->setParameter(array('adresse'=>'%'.$region.'%','profession'=>'Medecin'));

$users = $query->getResult();   
*/
            $professionmedecin= $this->getDoctrine()->getRepository('PortailFrontBundle:Profession')->findOneBy(array('designation'=>'Médecin')); 
        $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
    $adapter = new ArrayAdapter($repository->findBy(array('enabled'=>1,'profession'=>$professionmedecin->getId(),'ville'=>$ville)));
     $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();
            }
            $specialite = $this->getDoctrine()->getRepository('PortailFrontBundle:Specialite')->findAll();
         return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:RechercheParcarte.html.twig',array('pager'=> $pager,'specialite'=> $specialite));
       
     }
   
    
     
     public function ficheMedecinAction($id)
    {
  
        
         
         
         $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
    $medecin=$repository->findOneBy(array('enabled' => '1', 'id' =>$id));
     
     $user = $this->get('security.context')->getToken()->getUser();
       
      return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:fichemedecin.html.twig',array('medecin'=>$medecin,'user'=>$user));
      
         
     }
     
     
     
     
     
     public function contactAction() {
       
             
             $sujet=$_POST['sujet'];
             
             $message=  $_POST['message'];
             $destinataire=$_POST['idmedecin'];
             
              $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
              $med=$repository->findOneBy(array('id' =>$destinataire));
    
    
     $usercurrent = $this->get('security.context')->getToken()->getUser();
   
       $em = $this->getDoctrine()->getEntityManager();
       $email=new Contact();
       $email->setSujet($sujet);
       $email->setMessage($message);
        $email->setExpediteur($usercurrent);
       $email->setDestinataire($med);
       $email->setDateenvoi(new \DateTime());
       $em->persist($email);
       $em->flush();
      $msg = \Swift_Message::newInstance()
        ->setSubject($sujet)
        ->setFrom(array($usercurrent->getEmail()=>'ContactHorus'))
         ->setTo($med->getEmail())
        ->setBody($message);
    $this->get('mailer')->send($msg);
        
         return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:validation.html.twig',array('return'=> 'Message Envoyé'));
      
         
         
     }
     
     public function AnnuairepharmacieAction($page)
    {
        
     
       
$em = $this->getDoctrine()->getRepository('PortailFrontBundle:User'); 
$profession= $this->getDoctrine()->getRepository('PortailFrontBundle:Profession')->findOneBy(array('designation'=>'Pharmacien')); 

$adapter = new ArrayAdapter($em->findBy(array('enabled' =>1,'profession'=>$profession->getId())));
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 
            
            
            
$specialite = $this->getDoctrine()->getRepository('PortailFrontBundle:Specialite')->findAll();

        return $this->render('PortailAnnuaireBundle:AnnuairePharmacie:RechercheParcarte.html.twig',array('specialite'=>$specialite,'pager' => $pager));
    }
    
    
     public function findPharmacieParregionAction($ville,$page)
     {
        
            $profession= $this->getDoctrine()->getRepository('PortailFrontBundle:Profession')->findOneBy(array('designation'=>'Pharmacien')); 
        $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
    $adapter = new ArrayAdapter($repository->findBy(array('enabled'=>1,'profession'=>$profession->getId(),'ville'=>$ville)));
     $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();
            }
            $specialite = $this->getDoctrine()->getRepository('PortailFrontBundle:Specialite')->findAll();
         return $this->render('PortailAnnuaireBundle:AnnuairePharmacie:RechercheParcarte.html.twig',array('pager'=> $pager,'specialite'=> $specialite));
        
         
     }
     
    public function fichePharmacienAction($id)
    {
  
        
         
         
         $repository = $this->getDoctrine()->getRepository('PortailFrontBundle:User');  
    $pharmacien=$repository->findOneBy(array('enabled' => '1', 'id' =>$id));
     
  
       
      return $this->render('PortailAnnuaireBundle:AnnuairePharmacie:fichepharmacien.html.twig',array('pharmacien'=>$pharmacien));
      
         
     }
     
     
      public function AnnuaireetablissementAction($page)
    {
        
     
       
$em = $this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement'); 

$adapter = new ArrayAdapter($em->findAll());
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }

        return $this->render('PortailAnnuaireBundle:AnnuaireEtablissement:RechercheParcarte.html.twig',array('pager' => $pager,'Medecins'=>'Médecins'));
    }
    
 public function findEtablissementParregionAction($ville,$page) {
 
    $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findBy(array('ville'=>$ville)));
     $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();
            }
           
         return $this->render('PortailAnnuaireBundle:AnnuaireEtablissement:RechercheParcarte.html.twig',array('pager'=> $pager));
        
         
     }
     
   public function infoEtablissementAction($id) {
       
        $repository = $this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement');  
    $etab=$repository->findOneBy(array( 'id' =>$id));
     
  
       
      return $this->render('PortailAnnuaireBundle:AnnuaireEtablissement:infosEtablissement.html.twig',array('Etablissement'=>$etab));
      
       
   }  

     
     
}
