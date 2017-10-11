<?php

namespace JG\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JGPlatformBundle:Default:index.html.twig');
    }
}
