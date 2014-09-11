<?php
namespace Portail\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Portail\ForumBundle\Entity\Reponse;
use Portail\ForumBundle\Entity\Question;
use Portail\ForumBundle\Form\ReponseType;
use Portail\ForumBundle\Entity\SousCategorie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping as ORM;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

class ForumController  extends Controller {

    
public function listcategoryAction() {
    
    $em = $this->getDoctrine()->getEntityManager();

 $categories=$this->getDoctrine()->getRepository('PortailForumBundle:Categorie')->findAll();
// $em = $this->getDoctrine()->getEntityManager();
 /*   
 $derniermsgs=$em->createquery('SELECT s,q,c.id as categorie,u.username as username FROM PortailForumBundle:Question q,PortailForumBundle:SousCategorie s,PortailFrontBundle:User u,PortailForumBundle:Categorie c where 
s.categorie=c.id and
q.souscategorie=s.id and u.id=q.membre and 
q.datepublication in (select max(q1.datepublication) from PortailForumBundle:Question q1 group by q1.souscategorie)');
  $dernierquestion=$derniermsgs->getArrayResult();
 */
 //$dernierquestion=$this->getDoctrine()->getRepository('PortailForumBundle:Question') ->createQueryBuilder('q')
   $dernierquestion=$this->getDoctrine()->getRepository('PortailForumBundle:Question')->createQueryBuilder('q')
           ->select('q')
          
           ->where ('q.datepublication in (select max(q1.datepublication) from PortailForumBundle:Question q1 group by q1.souscategorie)')
          
           ->getQuery()
          ->getResult();
   
          
  $souscategrestants=$this->getDoctrine()->getRepository('PortailForumBundle:SousCategorie') ->createQueryBuilder('s')
    ->select('s')
    ->where('s.id not in (select s1 from PortailForumBundle:Question q,PortailForumBundle:SousCategorie s1 where q.souscategorie=s1.id )')
          
      ->getQuery()
          ->getResult();    
         

   return $this->render('PortailForumBundle:Front:categorie.html.twig',array('categorie'=>$categories,'dernierquestion'=>$dernierquestion,'souscategrestant'=>$souscategrestants));
    
}

public function ajoutsouscategorieAction(Request $request) {
       $em=$this->getDoctrine()->getManager();
     $user = $this->get('security.context')->getToken()->getUser();
    $designation=$request->request->get('designation');
     $categorie=$request->request->get('categorie');
    $categorie=$this->getDoctrine()->getRepository('PortailForumBundle:Categorie')->find($categorie);
    $souscategorie=new SousCategorie();
 $souscategorie->setDesignation($designation);
 $souscategorie->setMembre($user);
 $souscategorie->setDatepublication(new \DateTime());
 $souscategorie->setCategorie($categorie);
 $em->persist($souscategorie);
 $em->flush();
  return $this->redirect($this->generateUrl('listcategorie'));
 
}

public function suppsouscategorieAction($idsouscategorie) {
     $em=$this->getDoctrine()->getManager();
     $souscategorie=$this->getDoctrine()->getRepository("PortailForumBundle:SousCategorie")->find($idsouscategorie);
   
    $em->remove($souscategorie);
    $em->flush();     
    return $this->redirect($this->generateUrl('listcategorie'));
     
    
}
public function listquestionAction($souscategorie,$page) {
    
  $adapter = new ArrayAdapter($this->getDoctrine()->getRepository('PortailForumBundle:Question')->createQueryBuilder('q')
                   ->select('q,r')
                    
                   ->LeftJoin('q.reponses','r')
                   
                  ->where('q.souscategorie=:souscategorie')
                 ->addOrderBy('q.datepublication','DESC')
               
          ->setParameter('souscategorie',$souscategorie)->getQuery()->getResult());
  
  $pager = new Pagerfanta($adapter);
   $pager->setMaxPerPage(8);
   
                
            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }       
      
    $souscategories=$this->getDoctrine()->getRepository('PortailForumBundle:SousCategorie')->find($souscategorie);
    return $this->render('PortailForumBundle:Front:questions.html.twig',array('pager'=>$pager,'souscategorie'=> $souscategories));
}
public function listreponseAction($page,$question) {
    
	 $em=$this->getDoctrine()->getManager();
	$question=$this->getDoctrine()->getRepository('PortailForumBundle:Question')->find($question);
	$question->setNbvue($question->getNbvue()+1);
	$em->persist($question);
	$em->flush();
 $reponses= $this->getDoctrine()->getRepository('PortailForumBundle:Reponse')->createQueryBuilder('r')
                   ->select('r')
                  ->where('r.question=:question')
                ->setParameter('question',$question)
               ->addOrderBy('r.datepublication', 'ASC')
         
          ->getQuery()
          ->getResult();
    $adapter = new ArrayAdapter($reponses);
	 $pager = new Pagerfanta($adapter);
	
	$pager->setMaxPerPage(8);
   
                
            try {

                $pager->setCurrentPage($page);

            } catch (NotValidCurrentPageException $e) {

                throw new NotFoundHttpException();

            }       
	 
  $contenuquestion= $this->getDoctrine()->getRepository('PortailForumBundle:Question')->createQueryBuilder('q')
                   ->select('q')
                  ->where('q.id=:question')
                ->setParameter('question',$question)
           ->getQuery()
          ->getResult();
  return $this->render('PortailForumBundle:Front:listreponses.html.twig',array('reponses'=>$pager,'question'=> $contenuquestion));
      
    
    
}
public function dernierreponseAction($idquestion) {
$dernierrep=$this->getDoctrine()->getRepository('PortailForumBundle:Reponse')->createQueryBuilder('r')
                   ->select('r')
                  ->where('r.question=:question')
				   ->setParameter('question',$idquestion)
				   ->addOrderBy('r.datepublication','DESC')
                    ->setMaxResults(1)
                     ->getQuery()
          ->getResult();
		  return $this->render('PortailForumBundle:Front:dernierreponse.html.twig',array('dernierreponse'=>$dernierrep));
}

public function ajoutreponseAction(Request $request) {
    
          $em = $this->getDoctrine()->getManager();
$idquestion=$request->request->get('question');    
 $question=$this->getDoctrine()->getRepository('PortailForumBundle:Question')->find($idquestion);
  $reponse= new Reponse();
$reponse->setMessage($request->request->get('msg'));
  $user = $this->get('security.context')->getToken()->getUser();
  $reponse->setMembre($user);
  $reponse->setDatepublication(new \DateTime());
  $reponse->setQuestion($question);
  $em->persist($reponse);
          
          $em->flush();
    return $this->redirect($this->generateUrl('listdiscussion',array('question' =>$idquestion)));       
        }
   

public function ajoutquestionAction(Request $request) {
      $em = $this->getDoctrine()->getManager();
$souscategorie=$request->request->get('souscategorie');    
 $souscategories=$this->getDoctrine()->getRepository('PortailForumBundle:SousCategorie')->find($souscategorie);
  $question= new Question();
$question->setMessage($request->request->get('msg'));
  $user = $this->get('security.context')->getToken()->getUser();
  $question->setMembre($user);
  $question->setDatepublication(new \DateTime());
  $question->setSouscategorie( $souscategories);
  $em->persist($question);
          
          $em->flush();
          return $this->redirect($this->generateUrl('listquestions',array('souscategorie' =>$souscategorie)));
           
          
}


public function signalerquestionAction($idquestion) {
    $em=$this->getDoctrine()->getManager();
    $question=$this->getDoctrine()->getRepository("PortailForumBundle:Question")->find($idquestion);
    
    $question->setNbrsignal($question->getNbrsignal()+1);
    $em->persist($question);
    $em->flush();
     return $this->redirect($this->generateUrl('listdiscussion',array('question' =>$idquestion)));
}

public function supprimerquestionAction($idquestion) {
     $em=$this->getDoctrine()->getManager();
      $question=$this->getDoctrine()->getRepository("PortailForumBundle:Question")->find($idquestion);
    $souscategorie=$question->getSouscategorie()->getId();
    $em->remove($question);
    $em->flush();     
    return $this->redirect($this->generateUrl('listquestions',array('souscategorie' =>$souscategorie)));
    
}

public function signalerreponseAction($idreponse) {
    $em=$this->getDoctrine()->getManager();
    $reponse=$this->getDoctrine()->getRepository("PortailForumBundle:Reponse")->find($idreponse);
       $idquestion=$reponse->getQuestion()->getId();
    $reponse->setNbrsignal($reponse->getNbrsignal()+1);
    $em->persist($reponse);
    $em->flush();
   return $this->redirect($this->generateUrl('listdiscussion',array('question' =>$idquestion)));
}
public function supprimerreponseAction($idreponse) {
     $em=$this->getDoctrine()->getManager();
      $reponse=$this->getDoctrine()->getRepository("PortailForumBundle:Reponse")->find($idreponse);
    $idquestion=$reponse->getQuestion()->getId();
    $em->remove($reponse);
            $em->flush();
    return $this->redirect($this->generateUrl('listdiscussion',array('question' =>$idquestion)));
    
}
}



?>
