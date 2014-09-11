<?php
namespace Portail\FrontBundle\Controller;
use Portail\FrontBundle\Entity\FicheMaladie;
use Portail\FrontBundle\Form\Type\FichemaladieType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
 use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
class FichemaladieController extends Controller
{
    public function ajouterAction()
    {
        
        $em = $this->getDoctrine()->getManager();
       
       $entity = new FicheMaladie();
        $formfiche   = $this->createForm(new FichemaladieType(), $entity);
          $user = $this->get('security.context')->getToken()->getUser();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $formfiche->bindRequest($request); 
            $souscategorie=$request->request->get('souscategoriemaladie');
            $souscateg = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->find( $souscategorie);
    	//if ($form1->isValid()) {
               $entity->upload('maladies');
               
               $entity->redimensionner_image($entity->getUploadRootDir('maladies').'/'.$entity->getPath(), 1024, 768);
               $entity->setAuteur($user);
               $entity->setDatepublication(new \DateTime());
               $entity->setUpdated(new \DateTime());
               
               $entity->setSouscategorie($souscateg);
               $em->persist($entity);
               $em->flush();
        }
         //return $this->redirect('profilinfo');  
          $url = $this->get('router')->generate('profilinfo');
                    $response = new RedirectResponse($url);
                    return $response; 
                }
 public function editAction() {
     $request = $this->get('request');
     $id=$request->request->get('idfiche');
       $fichemaladie = $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->find($id); 
        $formfich   = $this->createForm(new FichemaladieType,$fichemaladie );
       
      
         // $user = $this->get('security.context')->getToken()->getUser();
   
    $souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findOneBy(array('id' =>$fichemaladie->getSouscategorie()));
   
//  echo $blog->getSouscategorie();
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findOneBy(array('id' =>$souscategorie->getCategorie()));
    $touscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->createQueryBuilder('c')
                   ->select('c')
                  ->where('c.id<>:id')
                  ->setParameter('id',$souscategorie->getCategorie())
                   ->getQuery()
                  ->getResult();
    
    return $this->render('PortailFrontBundle:FicheMaladie:fichemaladieupdate.html.twig'
   ,array('formfiche' => $formfich->createView(),'fichemaladie'=>$fichemaladie,
         'souscateg'=>$souscategorie,
         'categ'=> $categorie,
        'touscategorie'=>$touscategorie,
       
       
     ));
     
     
 }
 public function updateAction() {
      $request = $this->get('request');
     $id=$request->request->get('id');
       $fichemaladie= $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->find($id); 
       $formfich   = $this->createForm(new FichemaladieType(),$fichemaladie);
         $em = $this->getDoctrine()->getManager();
           $formfich->bindRequest($request);
           $souscategorie=$request->request->get('souscategoriemaladie');
            $souscateg = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->find( $souscategorie);
    	//if ($form1->isValid()) {
              $fichemaladie->upload('maladies');
               
              $fichemaladie->redimensionner_image( $fichemaladie->getUploadRootDir('maladies').'/'. $fichemaladie->getPath(), 1024, 768);
              $fichemaladie->setSouscategorie($souscateg);
               $fichemaladie->setUpdated(new \DateTime());
               $em->persist($fichemaladie);
             $em->flush();
             $url = $this->get('router')->generate('profilinfo');
                    $response = new RedirectResponse($url);
                    return $response; 
   
}
public function deleteAction() {
    
          $user = $this->get('security.context')->getToken()->getUser();
         $request = $this->get('request');
         $em = $this->getDoctrine()->getManager();
           $id=$request->request->get('idfiche');
           $fichemaladie = $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->find($id);  
    
           $em->remove($fichemaladie);
            $em->flush();
          
    //}
       return true;
    
    
}
public function listAction($page) {
    
           $adapter = new ArrayAdapter( $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->findAll());
                  
           $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }       
 
    
 return $this->render('PortailFrontBundle:FicheMaladie:listmaladie.html.twig',array('pager'=>$pager)); 
 
}
public function detailmaladieAction($id) {
     $maladie = $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->find($id);
	  $em = $this->getDoctrine()->getManager();
	 $maladie->setNbvue($maladie->getNbvue()+1);
	 $em->persist($maladie);
	 $em->flush();
    $idauteur=$this->getDoctrine()->getRepository('PortailFrontBundle:User')->findOneBy(array('id'=>$maladie->getAuteur()));
     return $this->render('PortailFrontBundle:FicheMaladie:detailmaladie.html.twig',array('maladie'=>$maladie,'auteurid'=>$idauteur->getId()));  
    
}


public function rechercheparalphabetAction($page,$lettre) {
    $em = $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->getMaladieBy($lettre);
    $adapter = new ArrayAdapter($em);
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 
            
     return $this->render('PortailFrontBundle:FicheMaladie:listmaladie.html.twig',array('pager'=>$pager));  
}
public function rechercheparmotcleAction($page) {
    $request=$this->get('request');
      $em = $this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->getMaladieByMotCle($request->request->get('key'));
      
    $adapter = new ArrayAdapter($em);
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
 
            
     return $this->render('PortailFrontBundle:FicheMaladie:listmaladie.html.twig',array('pager'=>$pager));  

    
}

public function rechercheparsouscategorieAction($page,$souscategorie) {
    
   
    //$this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->
     $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->findBy(array('souscategorie'=>$souscategorie)));
  //$adapter = new ArrayAdapter($this->getDoctrine()->getRepository('HamdiBlogBundle:Blog')->getLatestBlogs());
        
  $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5);    // We fix the number of results to 3 in each page.



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
     
     return $this->render('PortailFrontBundle:FicheMaladie:listmaladie.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'pager' => $pager));
    
    
}

public function articleplusluAction() {

 $articlepluslu=$this->getDoctrine()->getRepository('PortailFrontBundle:FicheMaladie')->getPlusLu(5);
 
 return $this->render('PortailFrontBundle:FicheMaladie:articlepluslu.html.twig',array('maladie'=> $articlepluslu));

}


public function sidebarAction() {
    
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 
 return $this->render('PortailFrontBundle:Accueil:sidebarmaladie.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie));
    
}
        
        
}
