<?php

namespace Sacprd\PageBundle\Controller;

use Sacprd\PageBundle\Entity\Page as Entity;
use Sacprd\PageBundle\Form\PageForm as Form;
use Sacprd\PageBundle\Model\PageGrid as Grid;

use Sacprd\AdminBundle\Model\Admin\Controller\AdminController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminpageController extends AdminController
{
    const CATEGORY_ENTITY = 'Sacprd\PageBundle\Entity\Page';
    const HOME_ROUTE = 'sacprd_page_list';
    
    public function listAction(Request $request)
    {
		return $this->getGrid(Grid::class, $request);				
    }

	public function deleteAction($id, Request $request)
    {
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setHomeRoute(self::HOME_ROUTE)
                ->execute('delete', ['id' => $id]);      
    }
    
	public function editAction($id, Request $request)
	{
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setForm(Form::class)
                ->setTitle(($id) ? 'Редактировать страницу' : 'Создать страницу')
                ->setHomeRoute(self::HOME_ROUTE)
                ->execute('edit', ['id' => $id]);
    }
}
