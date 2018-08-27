<?php

namespace Sacprd\Core\Admin\Controller;

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
    
	protected function getGrid($grid, Request $request)
	{
		$OGrid = (new $grid ($request, $this->container));
		return $OGrid->getResponse();
	}
    
    protected function getFormAction(Request $request)
    {
        return (new FormAction($request, $this->container));
    }
    
}
