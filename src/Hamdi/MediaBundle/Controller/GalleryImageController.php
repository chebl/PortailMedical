<?php

namespace Hamdi\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hamdi\MediaBundle\Entity\GalleryImage;
use Hamdi\MediaBundle\Form\GalleryImageType;

/**
 * GalleryImage controller.
 *
 */
class GalleryImageController extends Controller
{
    
    public function creeGalerieAction(request $request)
    {
        
        $entity  = new GalleryImage();
        $form = $this->createForm(new GalleryImageType(), $entity);
        $form->bind($request);
        $entity->setUrlImg('bundles/hamdimedia/gallery/'.$entity->getName());
        $ur = 'bundles/hamdimedia/gallery/'.$entity->getName();
        $url =$this->get('kernel')->getRootDir() . '/../web/' . $ur;
        
       
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();

        if (is_dir($url)) {
               
            $exi=4;
            return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,'galerie_img'=>$galeries_img,
                'form'   => $form->createView(),
                 'id_notif'=>$exi   ,'msg_notif'=>'Le dossier existe déja'));
            }
                
            mkdir($url);
            $em->persist($entity);
            $em->flush();
            
            $exi=3;
        return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'form'   => $form->createView(),
            'id_notif'=>$exi   ,'msg_notif'=>'Galerie crée avec succés'
        ));
    }
    /**
     * Lists all GalleryImage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HamdiMediaBundle:GalleryImage')->findAll();

        return $this->render('HamdiMediaBundle:GalleryImage:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a GalleryImage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiMediaBundle:GalleryImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GalleryImage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HamdiMediaBundle:GalleryImage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new GalleryImage entity.
     *
     */
    public function newAction()
    {
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);

        return $this->render('HamdiMediaBundle:GalleryImage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new GalleryImage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new GalleryImage();
        $form = $this->createForm(new GalleryImageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('id' => $entity->getId())));
        }

        return $this->render('HamdiMediaBundle:GalleryImage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GalleryImage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiMediaBundle:GalleryImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GalleryImage entity.');
        }

        $editForm = $this->createForm(new GalleryImageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HamdiMediaBundle:GalleryImage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing GalleryImage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiMediaBundle:GalleryImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GalleryImage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new GalleryImageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_edit', array('id' => $id)));
        }

        return $this->render('HamdiMediaBundle:GalleryImage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GalleryImage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HamdiMediaBundle:GalleryImage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GalleryImage entity.');
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
