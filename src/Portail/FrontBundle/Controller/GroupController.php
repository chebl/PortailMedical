<?php

namespace Portail\FrontBundle\Controller;

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

use Hamdi\BlogBundle\Entity\Blog;
use Hamdi\BlogBundle\Form\BlogType;

use Portail\FrontBundle\Entity\Group;
use Portail\FrontBundle\Form\GroupType;
/**
 * Group controller.
 *
 */
class GroupController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function showAction()
    {
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        $entity4 = new Group('');
        $formgroup   = $this->createForm(new GroupType(), $entity4);
        
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();

        $exi=0;
        return $this->render('HamdiAdminBundle:Admin:accueil.html.twig',array('user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'form'   => $form->createView(),
            'form1'   => $form1->createView(),
            'id_notif'=>$exi   ,'msg_notif'=>'',
            'formpart'=>$formpart->createView(),
            'formblog'=>$formblog->createView(),
            'formgroup'=>$formgroup->createView(),
            ));
    }
    
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();
    
        $request = $this->get('request');
        $gro  = new Group('');
        $formgro = $this->createForm(new GroupType(), $gro);
        $formgro->bind($request);

        $em->persist($gro);
        $em->flush();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        $entity4 = new Group('');
        $formgroup   = $this->createForm(new GroupType(), $entity4);
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();

        $exi=3;
        return $this->render('HamdiAdminBundle:Admin:accueil.html.twig',array('user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'form'   => $form->createView(),
            'form1'   => $form1->createView(),
            'id_notif'=>$exi   ,'msg_notif'=>'',
            'formpart'=>$formpart->createView(),
            'formblog'=>$formblog->createView(),
            'formgroup'=>$formgroup->createView(),
            ));
    }
    
    
    public function listAction()
    {
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        $entity4 = new Group('');
        $formgroup   = $this->createForm(new GroupType(), $entity4);
        
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $groups = $em->getRepository('PortailFrontBundle:Group')->findAll();
       
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();

        $exi=0;
        return $this->render('PortailFrontBundle:Group:index.html.twig',array('user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'form'   => $form->createView(),
            'form1'   => $form1->createView(),
            'id_notif'=>$exi   ,'msg_notif'=>'',
            'formpart'=>$formpart->createView(),
            'formblog'=>$formblog->createView(),
            'formgroup'=>$formgroup->createView(),
            'groups'=>$groups));
    }

    

    

    
}
