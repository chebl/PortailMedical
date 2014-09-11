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
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function accueilAction()
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
    public function indexAction()
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
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('PortailFrontBundle:User')->findAll();
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll();
        return $this->render('PortailFrontBundle:User:index.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'form'   => $form->createView(),
            'form1'   => $form1->createView(),
            'id_notif'=>0   ,'msg_notif'=>'',
            'formpart'=>$formpart->createView(),
            'formblog'=>$formblog->createView(),
            'formgroup'=>$formgroup->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortailFrontBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PortailFrontBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createForm(new UserType(), $entity);

        return $this->render('PortailFrontBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new User();
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return $this->render('PortailFrontBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll();
        $groups = $em->getRepository('PortailFrontBundle:Group')->findAll();
        $gr = array('Pharmacien'=>'Pharmacien');
        
        /*foreach ($groups as $group)
        {
            $gr[$group->getId()] = $group->getName(); 
            
        }*/
        $entity = $em->getRepository('PortailFrontBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType($em), $entity);
        

        return $this->render('PortailFrontBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'user_form'   => $editForm->createView(),
            'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            
        ));
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortailFrontBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        
        
        
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('PortailFrontBundle:User')->findAll();
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll();
        return $this->render('PortailFrontBundle:User:index.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,
            
            'id_notif'=>0   ,'msg_notif'=>'',
            
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PortailFrontBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
