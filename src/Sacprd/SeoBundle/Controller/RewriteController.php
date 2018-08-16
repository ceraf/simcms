<?php

namespace Sacprd\SeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RewriteController extends Controller
{
    public function indexAction($url)
    {
        return $this->render('@SacprdSeo/Default/index.html.twig', array());
    }
}
