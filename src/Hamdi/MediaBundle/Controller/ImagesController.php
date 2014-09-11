<?php

namespace Hamdi\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Hamdi\MediaBundle\Entity\Images;
use Hamdi\MediaBundle\Form\ImagesType;
use Hamdi\MediaBundle\Entity\GalleryImage;
use Hamdi\MediaBundle\Form\GalleryImageType;
use Hamdi\PartenaireBundle\Entity\Partenaire;
use Hamdi\PartenaireBundle\Form\PartenaireType;
/**
 * Images controller.
 *
 */
class ImagesController extends Controller
{
    /**
     * Lists all Images entities.
     *
     */
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();

        
        
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();

        return $this->render('HamdiMediaBundle:Images:index.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img
        ));
    }

    public function uploadImgAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $gal_id=$this->getRequest()->request->get('gallery_img');
        $galerie = $em->getRepository('HamdiMediaBundle:galleryImage')->find($gal_id);
         
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
            $form1->bindRequest($request); 
            
    	//if ($form1->isValid()) {
               $entity1->upload('partenaires');
               $entity1->redimensionner_image($entity1->getUploadRootDir('partenaires').'/'.$entity1->getPath(), $galerie->getLongueur(), $galerie->getLargeur());
               $em->persist($entity1);
               $em->flush();
               
               $galerie->addImage($entity1);
               $em->persist($galerie);
               $em->flush();
               
               
               $msg_notif = 'Image téléchargé avec succés';
               $id_notif = 3;
               return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif,'id_notif'=>$id_notif,
             'form'   => $form->createView(),'form1'   => $form1->createView(),
             'formpart'   => $formpart->createView()
        ));
        //}
        }
        
        
        
        
        
               $msg_notif = 'Error lors de téléchargemnt vérifier la taille de fichier ou bien le type ';
               $id_notif=4;
        return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=> $msg_notif,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView()
        ));
    }
    
  
   /**
     * Finds and displays a Images entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiMediaBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HamdiMediaBundle:Images:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Images entity.
     *
     */
    public function newAction()
    {
        $entity = new Images();
        $form   = $this->createForm(new ImagesType(), $entity);

        return $this->render('HamdiMediaBundle:Images:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Images entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Images();
        $form = $this->createForm(new ImagesType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('id' => $entity->getId())));
        }

        return $this->render('HamdiMediaBundle:Images:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Images entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiMediaBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $editForm = $this->createForm(new ImagesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HamdiMediaBundle:Images:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Images entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiMediaBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ImagesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_edit', array('id' => $id)));
        }

        return $this->render('HamdiMediaBundle:Images:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Images entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HamdiMediaBundle:Images')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Images entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl(''));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    
	

}
