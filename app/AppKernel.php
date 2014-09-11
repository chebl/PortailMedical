<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Hamdi\ContactBundle\HamdiContactBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new Hamdi\BlogBundle\HamdiBlogBundle(),
            new Hamdi\AdminBundle\HamdiAdminBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            
            new Hamdi\MediaBundle\HamdiMediaBundle(),
            new Hamdi\PartenaireBundle\HamdiPartenaireBundle(),
           new Portail\FrontBundle\PortailFrontBundle(),
            new Portail\BoiteBundle\PortailBoiteBundle(),
            new Portail\NewsletterBundle\PortailNewsletterBundle(),
            new Portail\NewsBundle\PortailNewsBundle(),
            new Portail\AnnuaireBundle\PortailAnnuaireBundle(),
            new Portail\EtablissementBundle\PortailEtablissementBundle(),
            new Portail\FicheMedicamentBundle\PortailFicheMedicamentBundle(),
              new Portail\ForumBundle\PortailForumBundle(),
            new Portail\RendezvousBundle\PortailRendezvousBundle(),
            new Portail\BlogUserBundle\PortailBlogUserBundle(),
            new Portail\CalendarBundle\PortailCalendarBundle(),
            new Portail\EvenementBundle\PortailEvenementBundle(),
            
            new Portail\ProfilBundle\PortailProfilBundle(),
            
            
          new BladeTester\CalendarBundle\BladeTesterCalendarBundle(),
             new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            
            new ADesigns\CalendarBundle\ADesignsCalendarBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
