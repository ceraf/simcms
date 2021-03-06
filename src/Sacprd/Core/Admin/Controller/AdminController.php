<?php

namespace Sacprd\Core\Admin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sacprd\Core\Admin\Grid\Grid;
use Sacprd\Core\Admin\Controller\Action as FormAction;

class AdminController extends Controller
{
    public function rowactAction($id, $action, Request $request)
    {
        $method = $action . 'Action';
        return $this->$method($id, $request);
    }
    
	protected function getGrid(Grid $Grid)
	{
		$Grid->setDoctrine($this->getDoctrine())
				->setTemplating($this->get('templating'));
		return new Response($Grid->getResponse());
	}
    
    protected function getFormAction(Request $request)
    {
        return (new FormAction($request, $this->container))
                ->setDoctrine($this->getDoctrine())
                ->setTemplating($this->get('templating'));
    }
    
}
