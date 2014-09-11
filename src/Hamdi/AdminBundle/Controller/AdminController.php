<?php

namespace Hamdi\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render('HamdiAdminBundle:Admin:index.html.twig',array('user'=>$user));
    }
    
    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;
        
        
        return $this->render('HamdiAdminBundle:Security:login.html.twig',array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ));
    }
}
