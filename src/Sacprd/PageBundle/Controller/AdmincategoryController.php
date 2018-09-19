<?php

namespace Sacprd\PageBundle\Controller;

use Sacprd\PageBundle\Entity\Category as Entity;
use Sacprd\PageBundle\Form\CategoryForm as Form;
use Sacprd\PageBundle\Model\CategoryGrid as Grid;

use Sacprd\AdminBundle\Model\Admin\Controller\AdminController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdmincategoryController extends AdminController
{
    const CATEGORY_ENTITY = 'Sacprd\PageBundle\Entity\Category';
    
    public function listAction(Request $request)
    {
		return $this->getGrid(Grid::class, $request);				
    }

	public function deleteAction($id, Request $request)
    {
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setHomeRoute('sacprd_category_page_list')
                ->execute('delete', ['id' => $id]);      
    }
    
	public function editAction($id, Request $request)
	{
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setForm(Form::class)
                ->setTitle(($id) ? 'Редактировать категорию' : 'Создать категорию')
                ->setHomeRoute('sacprd_category_page_list')
                ->execute('edit', ['id' => $id]);
    }
}
