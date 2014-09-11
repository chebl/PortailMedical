<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->add('', __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
    $loader->add('Gregwar', __DIR__.'/../vendor/gregwar/captcha-bundle');
    $loader->add('FOS', __DIR__.'/../vendor/freindsofsymfony/user-bundle');
    $loader->add('Gedmo', __DIR__.'/../vendor/gedmo/doctrine-extensions/lib');
    $loader->add('DoctrineExtensions', __DIR__.'/../vendor/beberlei/DoctrineExtensions/lib');
    $loader->add('Stof', __DIR__.'/../vendor/stof/doctrine-extensions-bundle');
    $loader->add('Hamdi', __DIR__.'/../src');
    $loader->add('Portail', __DIR__.'/../src');
}

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
