<?php

namespace Sacprd\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@SacprdAdmin/'.$this->getParameter('admin_layout').'/home.html.twig', array())->setSharedMaxAge(100);;
    }
}
