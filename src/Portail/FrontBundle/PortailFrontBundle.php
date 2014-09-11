<?php

namespace Portail\FrontBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PortailFrontBundle extends Bundle
{
      public function getParent()
    {
        return 'FOSUserBundle';
    }
    
private static $containerInstance = null; 

public function setContainer(\Symfony\Component\DependencyInjection 
\ContainerInterface $container = null) 
{ 
   parent::setContainer($container); 
   self::$containerInstance = $container; 
} 
public static function getContainer() 
{ 
  return self::$containerInstance; 
} 
}
