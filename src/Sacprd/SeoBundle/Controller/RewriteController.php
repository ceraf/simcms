<?php

namespace Sacprd\SeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RewriteController extends Controller
{
    public function indexAction($url)
    {
        $item = $this->getDoctrine()
            ->getRepository('Sacprd\SeoBundle\Entity\Rewrite')
            ->findOneBy(['url' => $url]);

        if (!empty($item)) {
            $route = strtolower(str_replace('\\', '_', $item->getRoute()));
           // return $this->forward($route, unserialize($item->getParams()));
           if (isset($this->getParameter('rewrite_route')[$route]))
               return $this->forward($this->getParameter('rewrite_route')[$route],
                                    unserialize($item->getParams()));

        }
        return $this->render('@SacprdSeo/Default/index.html.twig', array());
    }
}
