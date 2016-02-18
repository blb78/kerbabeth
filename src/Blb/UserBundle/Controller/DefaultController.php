<?php

namespace Blb\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BlbUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
