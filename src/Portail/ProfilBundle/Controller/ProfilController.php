<?php
namespace Portail\ProfilBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

class ProfilController extends Controller {
    
     public function indexAction()
    {
        return $this->render('PortailProfilBundle:Front:accueil.html.twig');
    }

    public function profilAction()
    {
     //   return $this->render('PortailProfilBundle:Profile:profile.html.twig');
    }
    public function testAction()
    {
        return $this->render('PortailProfilBundle:Profile:test.html.twig');
    }
    
}

?>
