<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SdzUserBundle
 *
 * @author HAMDI
 */
namespace Hamdi\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
class HamdiUserBundle extends Bundle{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

?>
