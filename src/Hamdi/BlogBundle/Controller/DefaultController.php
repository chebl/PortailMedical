<?php

namespace Hamdi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HamdiBlogBundle:Default:index.html.twig', array('name' => $name));
    }
}
