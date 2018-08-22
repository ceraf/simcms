<?php

namespace Sacprd\PageBundle\Controller;

use Sacprd\PageBundle\Entity\Category;
use Sacprd\PageBundle\Form\CategoryForm;
use Sacprd\PageBundle\Model\CategoryGrid;

use Sacprd\Core\Admin\Controller\AdminController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AdminpagesController extends AdminController
{
    const CATEGORY_ENTITY = 'Sacprd\PageBundle\Entity\Category';
    
    public function listAction(Request $request)
    {
		return $this->getGrid(new CategoryGrid($request));				
    }

	public function deleteAction($id, Request $request)
    {
        return $this->getFormAction($request)
                ->setEntity(self::CATEGORY_ENTITY)
                ->setHomeRoute('sacprd_page_list')
                ->execute('delete', ['id' => $id]);      
    }
    
	public function editAction($id, Request $request)
	{
        return $this->getFormAction($request)
                ->setEntity(self::CATEGORY_ENTITY)
                ->setForm(CategoryForm::class)
                ->setTitle(($id) ? 'Редактировать категорию' : 'Создать категорию')
                ->setHomeRoute('sacprd_page_list')
                ->execute('edit', ['id' => $id]);
    }
}
