<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategorypageController extends Controller
{
    public function viewAction($id)
    {
        $item = $this->getDoctrine()
                ->getRepository('Sacprd\PageBundle\Entity\Category')
                ->find($id);
        return $this->render('@App/default/page/category.html.twig', array('item' => $item));
    }
}
