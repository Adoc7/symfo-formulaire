<?php

namespace JG\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class FormulaireController extends Controller
{
    public function page1Action()
    {
        $cont1 = $this->get('templating')->render('JGPlatformBundle:Formulaire:page1.html.twig');
    return new Response($cont1);
    }

    public function page2Action()
    {
        $cont2 = $this->get('templating')->render('JGPlatformBundle:Formulaire:page2.html.twig');
        return new Response($cont2);
    }

}