<?php

namespace Hamdi\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HamdiMediaBundle:Default:index.html.twig', array('name' => $name));
    }
}
