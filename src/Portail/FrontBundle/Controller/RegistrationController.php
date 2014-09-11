<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Portail\FrontBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use  Portail\NewsletterBundle\Entity\UserNewsletterInscris;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
 use \Symfony\Component\DependencyInjection\ContainerAware;
 
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Hamdi\BlogBundle\Entity\Blog;
use Hamdi\BlogBundle\Form\BlogType;
use Portail\FrontBundle\Entity\FicheMaladie;
use Portail\FrontBundle\Form\Type\FicheMaladieType;
use Portail\FicheMedicamentBundle\Form\FichemedicamentType;
use Portail\FicheMedicamentBundle\Entity\FicheMedicament;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */

class RegistrationController extends Controller
{  

    
    
    function getXmlCoordsFromAdress($address)
{
$coords=array();
$base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
// ajouter &region=FR si ambiguité (lieu de la requete pris par défaut)
$request_url = $base_url . "address=" . urlencode($address).'&sensor=false';
$xml = simplexml_load_file($request_url) or die("url not loading");
//print_r($xml);
$coords['lat']=$coords['lon']='';
$coords['status'] = $xml->status ;
if($coords['status']=='OK')
{
 $coords['lat'] = $xml->result->geometry->location->lat ;
 $coords['lon'] = $xml->result->geometry->location->lng ;
}
return $coords;
}
  
   
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');
              
        $user = $userManager->createUser();
       
         
            
       $user->setEnabled(true);
         $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, new UserEvent($user, $request));
       
            
          
        $form = $formFactory->createForm();
        
        $form->setData($user);
        
        
                     

          
         
         //$ville= $this->getRequest()->request->get('ville');
       // $ville=$request->request->get('fos_user_registration_form[ville]');
        $ville=$form->get('ville')->getData();
        if ('POST' === $request->getMethod()) {
           
            // $ville=$request->request->get('fos_user_registration_form');
             
            
            if(isset($_POST['newsletter']))
            {$en = '1';

        setcookie("verifnewsletter", $en);
            
            }
            
          
            
               //  echo "<script language='javascript'>alert('hello');</script>";
            
            $form->bind($request);
     
        
               
            $data = $form->getData();
          $adresse=$data->getAdresse();
            $ville = $data->getVille();
            $address=$adresse.','.$ville;
            
    $coords=$this->getXmlCoordsFromAdress($address);      
         if($coords['status']=='OK')
             { $user->setLatitude($coords['lat']);
               $user->setLongitude($coords['lon']);
               }
               else {
                 $coords=$this->getXmlCoordsFromAdress($ville);   
                   $user->setLatitude($coords['lat']);
               $user->setLongitude($coords['lon']);
               }
                
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);
                      
                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
         
         // echo "<script language='javascript'>alert('hello');</script>";
             
             
        }

        return $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:inscription.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            
        ));
    }
    
   
    

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction()
    {
        $email = $this->container->get('session')->get('fos_user_send_confirmation_email/email');
        $this->container->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->container->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }
        if(isset($_COOKIE["verifnewsletter"])) {
 if( $_COOKIE["verifnewsletter"]==='1'){
              
             $em=$this->container->get('doctrine')->getEntityManager();
              $this->EnvoiMailConfirmation($em, $email);
              unset($_COOKIE["verifnewsletter"]);
          }
        }
        return $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:checkEmail.html.'.$this->getEngine(), array(
            'user' => $user,
            
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->container->get('router')->generate('user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
       
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        return $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:confirmed.html.'.$this->getEngine(), array(
            'user' => $user,
            
            
        ));
    }
    
  
    

  protected function getEngine()
    {
        return 'twig';
    }
  
    
    
    
    public function EnvoiMailConfirmation($em,$email)
    {
        
        
        // $entity = $em->getRepsository('PortailFrontBundle:Newsletter')->ExistEmail($em,$email);
       //if(!$entity) {    
        $entity1=new UserNewsletterInscris();
        $entity1->setEstconfirm(false);
        $entity1->setEmail( $email);
    $em->persist($entity1);
     $message = \Swift_Message::newInstance()
        ->setSubject('Confirmation d"inscription Newsletter')
        ->setFrom(array('chebl.mahmoud@gmail.com'=>'PortailHorus'))
        ->setTo($email)
        ->setBody($this->container->get('templating')->renderResponse(
          'PortailFrontBundle:Newsletter:confirm.html.twig',array('email'=>$email)),'text/html');
      $this->container->get('mailer')->send($message);
             
    $em->flush();
    
       //}
      return true;  
    }  
    
    
    
    public function TestusernameAction() {
        
     
       $input=$_POST['var'];
        
           $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($input);
       if($user) {
           return $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:mess.html.twig',array('return'=>'Utilisateur Existe déjà')); 
            
    }
     else {
                return  $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:mess.html.twig',array('return'=>'')); 
            
        }
       
       
        
    }
    
     public function TestemailAction() {
        
     
       $input=$_POST['var1'];
        
           $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByEmail($input);
       if($user) {
           return $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:mess.html.twig',array('return'=>'Email Existe dejà')); 
            
    }
     else {
                return  $this->container->get('templating')->renderResponse('PortailFrontBundle:Accueil:mess.html.twig',array('return'=>'')); 
            
        }
       
       
        
    }
    
     public function ProfilAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.profile.form.factory');
    
        $form = $formFactory->createForm();
        $form->setData($user);
         //$latitude=$user-> getLatitude();
         //$longitude=$user->getLongitude();
         
  if ('POST' === $request->getMethod()) {
               
      
            $form->bind($request);

            if ($form->isValid()) {
                 echo "<script language='javascript'>alert('hello');</script>";
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $userManager = $this->container->get('fos_user.user_manager');
                
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
                 
                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('portail_profil');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
             
        }

       $repository = $this->getDoctrine()->getRepository('HamdiContactBundle:Contact');  
    $monboite=$repository->findBy(array('destinataire' => $user->getId()),array('dateenvoi' => 'DESC'));
    
       $repository = $this->getDoctrine()->getRepository('PortailRendezvousBundle:Rendezvous');  
    $mesrendezvous=$repository->findBy(array('destinataire' => $user->getId(),'estfixe'=>0),array('dateenvoi' => 'DESC'));
        $entity = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity);
        $repositorycat = $this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie');  
          // $repository1 = $this->getDoctrine()->getRepository('PortailBlogBundle:SousCategorie');  
           $categorie=$repositorycat ->findAll();
           
      $fichm=new FicheMaladie();
    $formfich   = $this->createForm(new FicheMaladieType(), $fichm);       
       
     $med=new FicheMedicament();
    $formmed   = $this->createForm(new FichemedicamentType(), $med);    
    
          $em = $this->getDoctrine()->getEntityManager(); 
           
        $repository= $this->getDoctrine()->getRepository('HamdiBlogBundle:Blog');
        $blogs=$repository->findBy(array('auteur' => $user->getId()));
       $repository= $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie');
         $fichemaladie=$repository->findBy(array('auteur' => $user->getId()));
       $repository= $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament');
         
   $fichemedicament=$repository->findBy(array('auteur' => $user->getId()));          
//$query = $em->createQuery('select f,u.nom from PortailFrontBundle:FicheMaladie f,PortailBlogUserBundle:SousCategorie u where f.souscategorie=u.id and f.auteur=:auteur')->setParameter('auteur',$user->getId());
         //$fichemaladie=$query->getResult();
     // $widget = $this->generateUrl('calendar_event_list_by_month5');
          return $this->container->get('templating')->renderResponse(
            'PortailProfilBundle:Profile:profile.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),'user'=>$user,'boitereception'=>$monboite,'rendezvous'=>$mesrendezvous,
                'formblog'=>$formblog->createView(),'categorie'=>$categorie,
                'formfiche'=>$formfich->createView(),
                'blogs'=>$blogs,
                'fichemaladies'=>$fichemaladie,
                'formmedicament'=>$formmed->createView(), 
                'fichemedicaments'=>$fichemedicament,
              
                )
        );
    
    }
    function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
} 
  public function updateavatarAction()
    {
       

$sFileName = $_FILES['image_file']['name'];
$sFileType = $_FILES['image_file']['type'];
$sFileSize = $this->bytesToSize1024($_FILES['image_file']['size'], 1);
$path = 'C:/wamp/www/PortailMedical/web/bundles/portailbloguser/uploads/' . basename($_FILES['image_file']['name']);
move_uploaded_file($_FILES['image_file']['tmp_name'],$path);
echo <<<EOF
<p>Your file: {$sFileName} has been successfully received.</p>
<p>Type: {$sFileType}</p>
<p>Size: {$sFileSize}</p>
EOF;
       
 $user = $this->container->get('security.context')->getToken()->getUser();
   $userManager = $this->container->get('fos_user.user_manager');
  $user-> setLogo($sFileName);
   $userManager->updateUser($user);
  
              return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:validation.html.twig',array('return'=>'upload ok'));
    }
        

    
}
