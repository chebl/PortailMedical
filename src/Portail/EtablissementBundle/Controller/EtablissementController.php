<?php

namespace Portail\EtablissementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Portail\EtablissementBundle\Entity\Etablissement;
use Portail\EtablissementBundle\Form\EtablissementType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping as ORM;
 use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
         
class EtablissementController extends Controller
{
    public function ajouterAction() {
        
        $em = $this->getDoctrine()->getManager();
       
  
        $etab = new Etablissement();
        $formetab   = $this->createForm(new EtablissementType(), $etab);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $formetab->bindRequest($request); 
            
    	//if ($form1->isValid()) {
              //$etab->upload('logo');
              
               $em->persist($etab);
               $em->flush();
              $url = $this->get('router')->generate('listetablissement');
                    $response = new RedirectResponse($url);
                    return $response; 
       
        }
         return $this->render('PortailEtablissementBundle::ajouter.html.twig',array('etablissement'=>$etab,'formetab'=>$formetab->createView()));
       
        
        
    }
    
    
    public function listAction($page) {
     
     $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findAll());
        
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
     return $this->render('PortailEtablissementBundle::list.html.twig',array('pager'=>$pager));
       
        
    }
    
    
    public function deleteAction($id) {
    
        
         $em = $this->getDoctrine()->getManager();
           
           $etab = $this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->find($id);  
    
           $em->remove( $etab);
            $em->flush();
          $url = $this->get('router')->generate('listetablissement');
                    $response = new RedirectResponse($url);
                    return $response;   
    }
    
    public function listlaboAction() {
        
        $request = $this->get('request');
      // $id= $request->request->get('idpro');
      
 $categetab = $this->getDoctrine()->getRepository('PortailEtablissementBundle:CategorieEtab')->findOneBy(array('nom'=>'Laboratoire'));  
        
         $labos = $this->getDoctrine()->getRepository('PortailEtablissementBundle:Etablissement')->findBy(array('categorie'=>$categetab->getId()));  
          
         return $this->render('PortailEtablissementBundle::listlabo.html.twig',array('labo'=>$labos));
    }
}
