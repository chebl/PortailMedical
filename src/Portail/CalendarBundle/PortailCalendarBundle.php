<?php
namespace Portail\CalendarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PortailCalendarBundle extends Bundle
{

   public function getParent()
    {
        return 'BladeTesterCalendarBundle';
    }
}