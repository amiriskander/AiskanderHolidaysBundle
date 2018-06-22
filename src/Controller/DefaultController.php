<?php

namespace Aiskander\HolidaysBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AiskanderHolidaysBundle:Default:index.html.twig');
    }
}
