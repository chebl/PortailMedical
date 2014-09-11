<?php

namespace Hamdi\PartenaireBundle\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Portail\FrontBundle\Entity\User;
use Portail\FrontBundle\Form\UserType;

use Hamdi\MediaBundle\Entity\GalleryImage;
use Hamdi\MediaBundle\Form\GalleryImageType;

use Hamdi\MediaBundle\Entity\Images;
use Hamdi\MediaBundle\Form\ImagesType;

use Hamdi\PartenaireBundle\Entity\Partenaire;
use Hamdi\PartenaireBundle\Form\PartenaireType;
/**
 * User controller.
 *
 */
class PartenaireController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function createPartnerAction()
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $formpart->bindRequest($request); 
            
    	//if ($form1->isValid()) {
               $entity2->upload('partenaires');
               $entity2->redimensionner_image($entity1->getUploadRootDir('partenaires').'/'.$entity2->getPath(), 214, 194);
               $em->persist($entity2);
               $em->flush();
               
               
               $em->persist($entity2);
               $em->flush();
               
               return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
               /*$msg_notif = 'Partenaire ajouté avec succés';
               $id_notif = 3;
               return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif,'id_notif'=>$id_notif,
             'form'   => $form->createView(),'form1'   => $form1->createView(),
             'formpart'   => $formpart->createView()      
        ));*/
        //}
        }
        
        
        
        
        
               $msg_notif = 'Error lors d\'opération ';
               $id_notif=4;
        return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView()
        ));
    }
    
    
    public function listPartnersAction()
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        $partners = $em->getRepository('HamdiPartenaireBundle:Partenaire')->findAll();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        
        $msg_notif='Ajout effectué avec succés ...';
        $id_notif=3;
        
        
        
               
        return $this->render('HamdiPartenaireBundle:Admin:Gallery_partenaires.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),'partners'=>$partners
        ));
    }
    
    
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        $partner = $em->getRepository('HamdiPartenaireBundle:Partenaire')->find($id);
        $em->remove($partner);
        $em->flush();
        
        $partners = $em->getRepository('HamdiPartenaireBundle:Partenaire')->findAll();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        
        
        $msg_notif='Suppression effectué avec succés ...';
        $id_notif=3;
        
        
        
               
        return $this->render('HamdiPartenaireBundle:Admin:Gallery_partenaires.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),'partners'=>$partners
        ));
    }
}

?>
