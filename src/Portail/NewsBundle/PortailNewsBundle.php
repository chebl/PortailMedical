<?php

namespace Portail\NewsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PortailNewsBundle extends Bundle
{
     
    
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
