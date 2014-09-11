<?php 
namespace Portail\EvenementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 

use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping as ORM;
 use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
         
class EvenementController extends Controller {
    
 public function listAction($page) {
    $adapter = new ArrayAdapter( $this->getDoctrine()->getRepository('PortailEvenementBundle:Evenement')->findAll());
                  
           $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }       
 
$categorie=$this->getDoctrine()->getRepository('PortailEvenementBundle:Categorie')->findAll(); 
$type=$this->getDoctrine()->getRepository('PortailEvenementBundle:Type')->findAll();
     
  return $this->render('PortailEvenementBundle:Front:listevenement.html.twig',array('categorie'=>$categorie,'type'=>$type,'pager'=>$pager));      
     
     
 } 
 
 public function listbykeywordAction($page) {
        $request=$this->get('request');
        
        $adapter = new ArrayAdapter( $this->getDoctrine()->getRepository('PortailEvenementBundle:Evenement')->createQueryBuilder('m')
                   ->select('m')
                  ->where('m.titre LIKE :mot')
                  ->setParameter('mot','%'.  $request->request->get('search').'%')->getQuery()->getResult());
      $pager = new Pagerfanta($adapter);

            $pager->setMaxPerPage(5); 
              if( !$page ) {

                $page = 1;  }

            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }
            
            
$categorie=$this->getDoctrine()->getRepository('PortailEvenementBundle:Categorie')->findAll(); 
$type=$this->getDoctrine()->getRepository('PortailEvenementBundle:Type')->findAll();
     
  return $this->render('PortailEvenementBundle:Front:listevenement.html.twig',array('categorie'=>$categorie,'type'=>$type,'pager'=>$pager)); 
            
            
 }   
    
 public function listbycategoryAction($categorie,$page) {
     
       $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailEvenementBundle:Evenement')->findBy(array('categorie'=>$categorie)));
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
             
$categorie=$this->getDoctrine()->getRepository('PortailEvenementBundle:Categorie')->findAll(); 
$type=$this->getDoctrine()->getRepository('PortailEvenementBundle:Type')->findAll();
     
  return $this->render('PortailEvenementBundle:Front:listevenement.html.twig',array('categorie'=>$categorie,'type'=>$type,'pager'=>$pager)); 
         
}
public function listbydateAction($page)
        {
    $request=$this->get('request');
    $datedebut=new \DateTime($request->request->get('datedebut'));
    $datefin=  new \DateTime($request->request->get('datefin'));
   
      $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailEvenementBundle:Evenement')->createQueryBuilder('m')
                   ->select('m')
                  ->where('m.datedebut between :datedebut and :datefin')
                  ->setParameter('datedebut',$datedebut)
              ->setParameter('datefin',$datefin)
              ->getQuery()->getResult());
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
             
$categorie=$this->getDoctrine()->getRepository('PortailEvenementBundle:Categorie')->findAll(); 
$type=$this->getDoctrine()->getRepository('PortailEvenementBundle:Type')->findAll();
     
  return $this->render('PortailEvenementBundle:Front:listevenement.html.twig',array('categorie'=>$categorie,'type'=>$type,'pager'=>$pager)); 
          
}

public function listbytypeAction($page) {
     $request=$this->get('request');
      
       $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailEvenementBundle:Evenement')->findBy(array('type'=>$request->request->get('type'))));
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
             
$categorie=$this->getDoctrine()->getRepository('PortailEvenementBundle:Categorie')->findAll(); 
$type=$this->getDoctrine()->getRepository('PortailEvenementBundle:Type')->findAll();
     
  return $this->render('PortailEvenementBundle:Front:listevenement.html.twig',array('categorie'=>$categorie,'type'=>$type,'pager'=>$pager)); 
         
}
public function descevtAction($id) {
    
    $evt=$this->getDoctrine()->getRepository('PortailEvenementBundle:Evenement')->find($id);
  return $this->render('PortailEvenementBundle:Front:descriptionevt.html.twig',array('evt'=>$evt));
  
    
    
}

} 