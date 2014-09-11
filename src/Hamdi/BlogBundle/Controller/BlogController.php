<?php
namespace Hamdi\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Portail\FrontBundle\Entity\User;
//use Portail\FrontBundle\Form\UserType;

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
class BlogController extends Controller
{
    
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $blog = $em->getRepository('HamdiBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        $comments = $em->getRepository('HamdiBlogBundle:Comment')
                   ->getCommentsForBlog($blog->getId());
        
        return $this->render('PortailFrontBundle:Accueil:articleblog.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
    
    
    public function indexAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $blogs = $em->getRepository('HamdiBlogBundle:Blog')
                    ->getLatestBlogs();

        return $this->render('HamdiBlogBundle:Blog:index.html.twig', array(
            'blogs' => $blogs
        ));
    }
    
    /**
     * Ajouter un nouveau blog.
     *
     */
    public function ajouterAction()
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        $blogs=$em->getRepository('HamdiBlogBundle:Blog')->findAll();
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
        
        
        
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $formblog->bindRequest($request); 
            
    	//if ($form1->isValid()) {
               $entity3->upload('blog');
               $entity3->redimensionner_image($entity3->getUploadRootDir('blog').'/'.$entity3->getPath(), 1024, 768);
               $entity3->setAuteur($user);
               $em->persist($entity3);
               $em->flush();
               
               
               
               
               
               
               $id_notif = 3;
               return $this->render('HamdiBlogBundle:Admin:list_blog.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'id_notif'=>$id_notif,
             'form'   => $form->createView(),'form1'   => $form1->createView(),
             'formpart'   => $formpart->createView(),
             'formblog'   => $formblog->createView(),
             'blogs' => $blogs      
        ));
        //}
        }
        
        
        
        
        
               
               $id_notif=5;
        return $this->render('HamdiAdminBundle:Admin:accueil.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),
            'formblog'   => $formblog->createView(),
            'blogs' => $blogs
        ));
    }
    
    /**
     * Ajouter un nouveau blog.
     *
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        $blogs = $em->getRepository('HamdiBlogBundle:Blog')->findAll();
        
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
        
        
        
        
        
               $msg_notif = '';
               $id_notif=0;
        return $this->render('HamdiBlogBundle:Admin:list_blog.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),
            'formblog'   => $formblog->createView(),
            'blogs'   => $blogs,
            'formgroup'=>$formgroup->createView(),
        ));
    }
    
    public function commentsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        
        $comments = $this->getDoctrine()->getEntityManager()->createQuery('select p FROM HamdiBlogBundle:Comment p where p.blog = :id')
                                                            ->setParameter('id', $id)
                                                            ->getResult();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
                
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        
        
        
        
        
        
               $msg_notif = '';
               $id_notif=0;
        return $this->render('HamdiBlogBundle:Admin:list_comments.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),
            'formblog'   => $formblog->createView(),
            'comments'   => $comments
        ));
    }
    
    public function deleteCommentAction($id)
    {
        
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HamdiBlogBundle:Comment')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comment entity.');
            }

            $em->remove($entity);
            $em->flush();
            var_dump($entity); 

        return $this->redirect($this->generateUrl('list_comments',array('id'=>$entity->getBlog()->getId())));
    }
    
    public function deleteBlogAction($id)
    {
                
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HamdiBlogBundle:Blog')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Blog entity.');
            }

            $em->remove($entity);
            $em->flush();
        

        return $this->redirect($this->generateUrl('list_blog'));
    }
    
    
    public function updateBlogAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HamdiBlogBundle:Blog')->find($id);
        $path = $entity->getPath();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $request = $this->get('request');
        $editForm = $this->createForm(new BlogType(), $entity);
        $editForm->bind($request);
        $entity->setPath($path);
        
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('list_blog'));
        

        
    }
    
    public function changeImageBlogAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        
        $entity = $em->getRepository('HamdiBlogBundle:Blog')->find($id);
        $title = $entity->getTitle();
        $blog = $entity->getBlog();
        $tags = $entity->getTags();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $request = $this->get('request');
        $editForm = $this->createForm(new BlogType(), $entity);
        $editForm->bind($request);
        $entity->upload('blog');
        $entity->redimensionner_image($entity->getUploadRootDir('blog').'/'.$entity->getPath(), 600, 400);
               
        $entity->setTitle($title);
        $entity->setBlog($blog);
        $entity->setTags($tags);
        
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('list_blog'));
        

        
    }
    
    public function showBlogAction($id)
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        
        $comments = $this->getDoctrine()->getEntityManager()->createQuery('select p FROM HamdiBlogBundle:Comment p where p.blog = :id')
                                                            ->setParameter('id', $id)
                                                            ->getResult();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
                
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        $entity4 = new Blog();
        $formblo   = $this->createForm(new BlogType(), $entity4);
        
        $blog = $em->getRepository('HamdiBlogBundle:Blog')->find($id);
        
        
        
        
        
               $msg_notif = '';
               $id_notif=0;
        return $this->render('HamdiBlogBundle:Admin:update_blog.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),
            'formblog'   => $formblog->createView(),
            'formblo'   => $formblo->createView(),
            'comments'   => $comments,
            'blog' => $blog
        ));
    }
    
    public function showImageBlogAction($id)
    {
        $em = $this->getDoctrine()->getManager();
       
        //print_r($file->getRealpath());
        
         
        $user = $this->get('security.context')->getToken()->getUser();
        
        $msgs = $em->getRepository('HamdiContactBundle:Contact')->findAll(); 
        $n = $this->getDoctrine()->getEntityManager()->createQuery('select COUNT(p) as nb FROM HamdiContactBundle:Contact p where p.msg_vue = 0')->getResult();
        $galeries_img = $em->getRepository('HamdiMediaBundle:galleryImage')->findAll();
        $entities = $em->getRepository('HamdiMediaBundle:Images')->findAll();
        
        $comments = $this->getDoctrine()->getEntityManager()->createQuery('select p FROM HamdiBlogBundle:Comment p where p.blog = :id')
                                                            ->setParameter('id', $id)
                                                            ->getResult();
        
        $entity = new GalleryImage();
        $form   = $this->createForm(new GalleryImageType(), $entity);
        
        $entity1 = new Images();
        $form1   = $this->createForm(new ImagesType(), $entity1);
                
        $entity2 = new Partenaire();
        $formpart   = $this->createForm(new PartenaireType(), $entity2);
        
        $entity3 = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity3);
        
        $entity4 = new Blog();
        $formblo   = $this->createForm(new BlogType(), $entity4);
        
        $blog = $em->getRepository('HamdiBlogBundle:Blog')->find($id);
        
        
        
        
        
               $msg_notif = '';
               $id_notif=0;
        return $this->render('HamdiBlogBundle:Admin:update_blog_image.html.twig', array(
            'entities' => $entities,'user'=>$user,'n'=>$n[0]['nb'],'msgs'=>$msgs,
            'galerie_img'=>$galeries_img,'msg_notif'=>$msg_notif ,'id_notif'=>$id_notif,
            'form'   => $form->createView(),'form1'   => $form1->createView(),
            'formpart'   => $formpart->createView(),
            'formblog'   => $formblog->createView(),
            'formblo'   => $formblo->createView(),
            'comments'   => $comments,
            'blog' => $blog
        ));
    }
}
?>
