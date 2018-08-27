<?php

namespace Sacprd\UserBundle\Model;

use Sacprd\Core\Admin\Grid\Grid;

class GroupGrid extends Grid
{
    protected function init()
    {
        $this->action_route = 'sacprd_group_action';
        $this->grid_route = 'sacprd_group_list';
        $this->title = 'Группы пользователей';
        
        parent::init();

        $this->entityname = 'Sacprd\UserBundle\Entity\Group';
        
        $this->fields = [
            'title' => [
                'name' => 'title',
                'label' => 'Название',
                'style' => ''
            ],
            
            'role' => [
                'name' => 'role',
                'label' => 'Роль',
                'style' => ''
            ],            
        ];
    }
}
