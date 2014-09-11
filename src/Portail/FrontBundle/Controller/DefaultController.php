<?php

namespace Portail\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Hamdi\ContactBundle\Entity\Contact;
use Hamdi\ContactBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Hamdi\BlogBundle\Entity\Comment;
class DefaultController extends Controller
{
    public function indexAction($page)
    {
      
      
    }
    public function voirAction()
    {
        return $this->render('PortailFrontBundle:Accueil:comment.html.twig');
    }
    
    
      public function contactAction()
    {
        
         $entity = new Contact();
        $form   = $this->createForm(new ContactType(), $entity);

        return $this->render('PortailFrontBundle:Accueil:contact.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
     public function blogAction()
    {
        return $this->render('PortailFrontBundle:Accueil:blog.html.twig');
    }
    public function listcommentAction(Request $request)
    {
        if ('POST' === $request->getMethod()) {
    $nom=$request->request->get('auteur');
    $msg=  $request->request->get('message');
$id=$request->request->get('idblog');
        
         $em = $this->getDoctrine()->getEntityManager();

        $blog = $em->getRepository('HamdiBlogBundle:Blog')->find($id);
        
         
        $comment=new Comment();
        $comment->setUser($nom);
        $comment->setComment($msg);
        
         $comment->setBlog($blog);
      $em->persist($comment);
            $em->flush();
  }
	 return $this->redirect($this->generateUrl('HamdiBlogBundle_blog_show',array('id' =>$id))); 
        
  
    }

    public function getTokenAction()
{
    return new Response($this->container->get('form.csrf_provider')
                            ->generateCsrfToken('authenticate'));
}
 
}
