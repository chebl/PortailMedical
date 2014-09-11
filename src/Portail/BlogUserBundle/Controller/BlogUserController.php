<?php
namespace Portail\BlogUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Hamdi\BlogBundle\Entity\Blog;
use Hamdi\BlogBundle\Form\BlogType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Portail\BlogUserBundle\Entity\SousCategorie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping as ORM;
class BlogUserController extends Controller
{
    
     public function sousCategorieAction(Request $request)
    {  
         
       if('POST' === $request->getMethod()) {
                
               $categorie=$request->request->get('categ');
         
           $repository = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie');  
    $souscategorie=$repository->findBy(array('categorie' =>$categorie));
     
     // $m=$request->request->get('cate');
 
}
return $this->render('PortailBlogUserBundle::listsouscategorie.html.twig',array('souscategorie'=>$souscategorie));  
    }
    
     public function listsouscategorieAction($categorie)
    {   
         
    $repository = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie');  
    $souscategorie=$repository->findBy(array('categorie' =>$categorie));
     
     // $m=$request->request->get('cate');
 return $this->render('PortailBlogUserBundle::listesouscategorie.html.twig',array('souscategorie'=>$souscategorie));
  }
    
    public function ajouterAction() {
          $em = $this->getDoctrine()->getManager();
       
       $entity = new Blog();
        $formblog   = $this->createForm(new BlogType(), $entity);
          $user = $this->get('security.context')->getToken()->getUser();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $formblog->bindRequest($request); 
            $souscategorie=$request->request->get('souscategorie');
            $souscateg = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->find( $souscategorie);
    	//if ($form1->isValid()) {
               $entity->upload('blog');
               
               $entity->redimensionner_image($entity->getUploadRootDir('blog').'/'.$entity->getPath(), 1024, 768);
               $entity->setAuteur($user);
               $entity->setSouscategorie($souscateg);
               $em->persist($entity);
               $em->flush();
        }
         //return $this->redirect('profilinfo');  
          $url = $this->get('router')->generate('profilinfo');
                    $response = new RedirectResponse($url);
                    return $response; 
                }
public function editAction(Request $request) 
        {
    
        $id=$request->request->get('idblog');
       $blog = $this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->find($id); 
        $formblog   = $this->createForm(new BlogType(),$blog);
       
      
         // $user = $this->get('security.context')->getToken()->getUser();
   
    $souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findOneBy(array('id' =>$blog->getSouscategorie()));
   //  echo $blog->getSouscategorie();
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findOneBy(array('id' =>$souscategorie->getCategorie()));
    
    return $this->render('PortailProfilBundle:Profile:articleupdate.html.twig'
   ,array('formblog' => $formblog->createView(),'blog'=> $blog,
         'souscateg'=>$souscategorie,
         'categ'=> $categorie,
       
        ));
}
public function updateAction(Request $request) {
     $id=$request->request->get('id');
       $blog = $this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->find($id); 
        $formblog   = $this->createForm(new BlogType(),$blog);
         $em = $this->getDoctrine()->getManager();
           $formblog->bindRequest($request);
           $souscategorie=$request->request->get('souscategorie');
            $souscateg = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->find( $souscategorie);
    	//if ($form1->isValid()) {
               $blog->upload('blog');
               
               $blog->redimensionner_image($blog->getUploadRootDir('blog').'/'.$blog->getPath(), 1024, 768);
               $blog->setSouscategorie($souscateg);
               $blog->setUpdated(new \DateTime());
               $em->persist($blog);
             $em->flush();
             $url = $this->get('router')->generate('portail_profil');
                    $response = new RedirectResponse($url);
                    return $response; 
           
       
    
    
}
 

public function deleteAction(Request $request) {
    
   // if('POST'===$request->getMethod()) {
        $user = $this->get('security.context')->getToken()->getUser();
         $em = $this->getDoctrine()->getManager();
           $id=$request->request->get('idblog');
           $blog = $this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->find($id);  
    
           $em->remove($blog);
            $em->flush();
			
			
			  return $this->render('PortailAnnuaireBundle:AnnuaireMedecin:validation.html.twig',array('return'=> 'Article supprimé'));
           
    //}
  
    
    
}
public function datatableAction() {
    
     return $this->render('PortailBlogUserBundle::datatable.html.twig');
    
}  

public function listarticleAction($souscategorie,$page=null) {
    //$request=$this->get('request');
      
 
   
    //$this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->
     $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getBlogBycategory($souscategorie));
  //$adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getLatestBlogs());
        
  $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3);    // We fix the number of results to 3 in each page.



            // if $page doesn't exist, we fix it to 1

            if( !$page ) {

                $page = 1;

            }

              try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 

             
     $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
         $souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll();
     
     return $this->render('PortailFrontBundle:Accueil:blog.html.twig',array('p'=>1,'categorie'=>$categorie,'souscategorie'=>$souscategorie,'pager' => $pager));
    
    
}





public function listblogAction($page=null) {
    //$request=$this->get('request');
      
 
   
    //$this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->
     $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->findAll());
  //$adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getLatestBlogs());
        
  $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3);    // We fix the number of results to 3 in each page.



            // if $page doesn't exist, we fix it to 1

            if( !$page ) {

                $page = 1;

            }

              try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 

             
     $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
         $souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll();
     
     return $this->render('PortailFrontBundle:Accueil:blog.html.twig',array('pager' => $pager,'categorie'=>$categorie,'souscategorie'=>$souscategorie));
    
    
}



/*
public function sidebarAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $tags = $em->getRepository('HamdiBlogBundle:Blog')
                   ->getTags();

        $tagWeights = $em->getRepository('HamdiBlogBundle:Blog')
                         ->getTagWeights($tags);

        
        
        $commentLimit   = $this->container
                               ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('HamdiBlogBundle:Comment')
                             ->getLatestComments($commentLimit);

    return $this->render('PortailBlogUserBundle::sidebar.html.twig', array(
        'latestComments'    => $latestComments,
        'tags'              => $tagWeights
    ));
    }
 
 */

public function sidebarAction() {
    
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 
 return $this->render('PortailFrontBundle:Accueil:sidebar.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie));
    
}
public function listbytagAction($tag,$page) {
    
      $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->createQueryBuilder('b')
                   ->select('b')
                  ->where('(b.tags like :tag)')
                  ->setParameter('tag', '%'.$tag.'%')->getQuery()
                  ->getResult());

       
  //$adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getLatestBlogs());
        
  $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3);    // We fix the number of results to 3 in each page.



            // if $page doesn't exist, we fix it to 1

            if( !$page ) {

                $page = 1;

            }

              try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 

             
     $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 

     
     return $this->render('PortailFrontBundle:Accueil:blog.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'pager' => $pager));
    
     
    
    
}
public function listbykeyAction(Request $request,$page) {
$key=$request->request->get('key');
 $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->createQueryBuilder('b')
                   ->select('b')
                  ->where('(b.title LIKE :key) or(b.blog LIKE :key) ')
                  ->setParameter('key', '%'.$key.'%')->getQuery()
                  ->getResult());

       
  //$adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getLatestBlogs());
        
  $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(3);    // We fix the number of results to 3 in each page.



            // if $page doesn't exist, we fix it to 1

            if( !$page ) {

                $page = 1;

            }

              try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 

             
     $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 

     
     return $this->render('PortailFrontBundle:Accueil:blog.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'pager' => $pager));
    
     
    
}


public function getLatestBlogAction() {
    
    $lastblogs=$this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getLatestBlogs(5);
    
     return $this->render('PortailBlogUserBundle::lastblogs.html.twig', array(
            'lastblogs'=>$lastblogs));
}
public function pluslusblogsAction() {
    
    $pluslusnews = $this->getDoctrine()->getRepository('PortailNewsBundle:News')->getBlogsPlusLus();
    
     return $this->render('PortailBlogUserBundle::pluslusblogs.html.twig', array(
            'pluslusnews'=>$pluslusnews));
    
}

public function blogpluslusAction() {
    
     $lastblogs=$this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getMostViewBlogs(3);
    return $this->render('PortailBlogUserBundle::blogpluslus.html.twig', array(
            'blogs'=>$lastblogs));
}



}
