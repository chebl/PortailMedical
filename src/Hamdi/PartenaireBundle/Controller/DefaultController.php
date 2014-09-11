<?php

namespace Hamdi\PartenaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HamdiPartenaireBundle:Default:index.html.twig', array('name' => $name));
    }
}
