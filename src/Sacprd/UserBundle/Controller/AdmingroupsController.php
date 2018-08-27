<?php

namespace Sacprd\UserBundle\Controller;

use Sacprd\UserBundle\Form\GroupForm as Form;
use Sacprd\UserBundle\Model\GroupGrid as Grid;
use Sacprd\UserBundle\Entity\Group as Entity;

use Sacprd\Core\Admin\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;

class AdmingroupsController extends AdminController
{
    public function listAction(Request $request)
    {
		return $this->getGrid(Grid::class, $request);				
    }

	public function deleteAction($id, Request $request)
    {
        $homeroute = 'sacprd_group_list';
        
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setHomeRoute($homeroute)
                ->execute('delete', ['id' => $id]);      
    }
    
	public function editAction($id, Request $request)
	{
        $edittitle = 'Редактировать группу';
        $newtitle = 'Создать группу';
        $homeroute = 'sacprd_group_list';
        
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setForm(Form::class)
                ->setTitle(($id) ? $edittitle : $newtitle)
                ->setHomeRoute($homeroute)
                ->execute('edit', ['id' => $id]);
    }
}
