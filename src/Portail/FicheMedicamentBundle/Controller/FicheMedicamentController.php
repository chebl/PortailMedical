<?php

namespace Portail\FicheMedicamentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 

use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping as ORM;
use  Portail\FicheMedicamentBundle\Entity\FicheMedicament;
use Portail\FicheMedicamentBundle\Form\FichemedicamentType;
 use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
         
class FicheMedicamentController extends Controller
{
    
    public function ajouterAction()
    {
        
        $em = $this->getDoctrine()->getManager();
       
       $entity = new FicheMedicament();
        $formfiche   = $this->createForm(new FichemedicamentType(), $entity);
          $user = $this->get('security.context')->getToken()->getUser();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $formfiche->bindRequest($request); 
            $souscategorie=$request->request->get('souscategoriemedicament');
            $souscateg = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->find( $souscategorie);
    	//if ($form1->isValid()) {
               //$entity->upload('maladies');
               
               //$entity->redimensionner_image($entity->getUploadRootDir('maladies').'/'.$entity->getPath(), 1024, 768);
            $entity->setLaboratoire($user->getEtablissement());
            
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
     $id=$request->request->get('idmed');
       $fichemed = $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->find($id); 
        $formfich   = $this->createForm(new FichemedicamentType, $fichemed);
       
      
         // $user = $this->get('security.context')->getToken()->getUser();
   
    $souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findOneBy(array('id' => $fichemed->getSouscategorie()));
   //  echo $blog->getSouscategorie();
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findOneBy(array('id' =>$souscategorie->getCategorie()));
      $touscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->createQueryBuilder('c')
                   ->select('c')
                  ->where('c.id<>:id')
                  ->setParameter('id',$souscategorie->getCategorie())
                   ->getQuery()
                  ->getResult();
    return $this->render('PortailFicheMedicamentBundle::fichemedicamentupdate.html.twig'
   ,array('formmedicament' => $formfich->createView(),'fichemedicament'=>$fichemed,
         'souscateg'=>$souscategorie,
         'categ'=> $categorie,
       'touscategorie'=>$touscategorie,
       
     ));
     
     
 }
 
 public function updateAction() {
      $request = $this->get('request');
     $id=$request->request->get('id');
       $fichemed= $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->find($id); 
       $formfich   = $this->createForm(new FichemedicamentType(), $fichemed);
         $em = $this->getDoctrine()->getManager();
           $formfich->bindRequest($request);
           $souscategorie=$request->request->get('souscategoriemedicament');
            $souscateg = $this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->find( $souscategorie);
    	//if ($form1->isValid()) {
              //$fichemaladie->upload('maladies');
               
              //$fichemaladie->redimensionner_image( $fichemaladie->getUploadRootDir('maladies').'/'. $fichemaladie->getPath(), 1024, 768);
              $fichemed->setSouscategorie($souscateg);
               $fichemed->setUpdated(new \DateTime());
               $em->persist($fichemed);
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
           $fichemedicament = $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->find($id);  
    
           $em->remove($fichemedicament);
            $em->flush();
           $fichemedicament = $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->findBy(array('auteur'=> $user->getId()));
    //}
       return $this->render('PortailFicheMedicamentBundle::mesarticles.html.twig',array('fichemedicaments'=> $fichemedicament));
    
    
}
 
    
                
                
                
    
    
    public function listAction($page) {
        
          $adapter = new ArrayAdapter( $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->findAll());
                  
           $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }       
 
$categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 
$laboratoire=$this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll();
  $classetherapeutique=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:Classetherapeutique')->findAll();
  
  return $this->render('PortailFicheMedicamentBundle::medicaments.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'laboratoire'=>$laboratoire,'classetherapeutique'=>$classetherapeutique,'pager'=>$pager));      
    }
    public function listparalphabetAction($page,$lettre) {
        
        
        $adapter = new ArrayAdapter( $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->createQueryBuilder('m')
                   ->select('m')
                  ->where('m.nom LIKE :lettre')
                  ->setParameter('lettre', $lettre.'%')->getQuery()->getResult());
      $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }       
      
        
     
$categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 

$laboratoire=$this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll();
  $classetherapeutique=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:Classetherapeutique')->findAll();
    
  
  return $this->render('PortailFicheMedicamentBundle::medicaments.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'laboratoire'=>$laboratoire,'classetherapeutique'=>$classetherapeutique,'pager'=>$pager));      
  
    }

    public function listparmotcleAction($page) {
             $request=$this->get('request');
      $em = $this->getDoctrine()->getRepository('PortailMedicamentBundle:FicheMedicament')->getMaladieByMotCle($request->request->get('search'));
      
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
    
          
     

$laboratoire=$this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll();
  $classetherapeutique=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:Classetherapeutique')->findAll();
  
     return $this->render('PortailFicheMedicamentBundle::medicaments.html.twig',array('laboratoire'=>$laboratoire,'classetherapeutique'=>$classetherapeutique,'pager'=>$pager));      
    }
public function listparclassAction($page) {
   
    $request=$this->get('request');
      
    $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->findBy(array('classetherapeutique'=>$request->request->get('classe'))));
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
    
          
    
    
    
    
$laboratoire=$this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll();
  $classetherapeutique=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:Classetherapeutique')->findAll();
   return $this->render('PortailFicheMedicamentBundle::medicaments.html.twig',array('laboratoire'=>$laboratoire,'classetherapeutique'=>$classetherapeutique,'pager'=>$pager));      
   
    
    
    
}    
    
public function listparlaboAction($page) {
   
    $request=$this->get('request');
      
    $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->findBy(array('laboratoire'=>$request->request->get('labo'))));
   $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
    
    
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 
$laboratoire=$this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll();
  $classetherapeutique=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:Classetherapeutique')->findAll();
   return $this->render('PortailFicheMedicamentBundle::medicaments.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'laboratoire'=>$laboratoire,'classetherapeutique'=>$classetherapeutique,'pager'=>$pager));      
    
    
}

public function listparcategorieAction($souscategorie,$page) {
    
    $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->findBy(array('souscategorie'=>$souscategorie)));
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
$laboratoire=$this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll();
  $classetherapeutique=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:Classetherapeutique')->findAll();
   return $this->render('PortailFicheMedicamentBundle::medicaments.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie,'laboratoire'=>$laboratoire,'classetherapeutique'=>$classetherapeutique,'pager'=>$pager));      
    
    
}
public function detailmedicamentAction($id) {
     $med = $this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')->find($id);
	  $em = $this->getDoctrine()->getManager();
	 $med->setNbvue($med->getNbvue()+1);
	 $em->persist($med);
	 $em->flush();
    $idauteur=$this->getDoctrine()->getRepository('PortailFrontBundle:User')->findOneBy(array('id'=>$med->getAuteur()));
     return $this->render('PortailFicheMedicamentBundle::detailmedicament.html.twig',array('medicament'=>$med,'auteurid'=>$idauteur->getId()));  
    
}

public function articleplusluAction() {

 $articlepluslu=$this->getDoctrine()->getRepository('PortailFicheMedicamentBundle:FicheMedicament')
 ->createQueryBuilder('m')
                   ->select('m')
				   ->addOrderBy('m.nbvue', 'DESC')
				   ->setMaxResults(5)
				   ->getQuery()
                  ->getResult();
 
 return $this->render('PortailFicheMedicamentBundle::articlepluslu.html.twig',array('medicament'=> $articlepluslu));

}

public function sidebarAction() {
    
    $categorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:Categorie')->findAll(); 
$souscategorie=$this->getDoctrine()->getRepository('PortailBlogUserBundle:SousCategorie')->findAll(); 
 return $this->render('PortailFicheMedicamentBundle::sidebarmedicament.html.twig',array('categorie'=>$categorie,'souscategorie'=>$souscategorie));
    
}
    
}
