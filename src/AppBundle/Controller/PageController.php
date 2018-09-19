<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function viewAction($id)
    {
        $item = $this->getDoctrine()
                ->getRepository('Sacprd\PageBundle\Entity\Page')
                ->find($id);
        return $this->render('@App/default/page/page.html.twig', array('item' => $item));
    }
}
