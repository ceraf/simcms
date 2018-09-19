<?php

namespace Sacprd\UserBundle\Controller;

use Sacprd\UserBundle\Form\UserForm as Form;
use Sacprd\UserBundle\Model\UserGrid as Grid;
use Sacprd\UserBundle\Entity\User as Entity;

use Sacprd\AdminBundle\Model\Admin\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;

class AdminusersController extends AdminController
{
    public function listAction(Request $request)
    {
		return $this->getGrid(Grid::class, $request);				
    }

	public function deleteAction($id, Request $request)
    {
        $homeroute = 'sacprd_user_list';
        
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setHomeRoute($homeroute)
                ->execute('delete', ['id' => $id]);      
    }
    
	public function editAction($id, Request $request)
	{
        $edittitle = 'Редактировать пользователя';
        $newtitle = 'Создать пользователя';
        $homeroute = 'sacprd_user_list';
        
        return $this->getFormAction($request)
                ->setEntity(Entity::class)
                ->setForm(Form::class)
                ->setTitle(($id) ? $edittitle : $newtitle)
                ->setHomeRoute($homeroute)
                ->execute('edit', ['id' => $id]);
    }
}
