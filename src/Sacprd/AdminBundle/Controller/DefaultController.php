<?php

namespace Sacprd\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@SacprdAdmin/Default/index.html.twig', array());
    }
}
