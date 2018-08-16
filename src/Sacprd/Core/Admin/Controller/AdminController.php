<?php

namespace Sacprd\Core\Admin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sacprd\Core\Admin\Grid\Grid;

class AdminController extends Controller
{
	protected function getGrid(Grid $Grid)
	{
		$Grid->setDoctrine($this->getDoctrine())
				->setTemplating($this->get('templating'));
		return new Response($Grid->getResponse());
	}
}
