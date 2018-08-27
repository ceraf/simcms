<?php

namespace Sacprd\UserBundle\Model;

use Sacprd\Core\Admin\Grid\Grid;

class UserGrid extends Grid
{
    protected function init()
    {
        $this->action_route = 'sacprd_user_action';
        $this->grid_route = 'sacprd_user_list';
        $this->title = 'Пользователи';
        
        parent::init();

        $this->entityname = 'Sacprd\UserBundle\Entity\User';
        
        $this->fields = [
            'username' => [
                'name' => 'username',
                'label' => 'Имя',
                'style' => ''
            ],
            'email' => [
                'name' => 'email',
                'label' => 'E-mail',
                'style' => ''
            ],
            'is_active' => [
                'name' => 'is_active',
                'label' => 'Статус',
                'style' => ''
            ],
            'groupname' => [
                'name' => 'groupname',
                'label' => 'Группа',
                'style' => ''
            ]
        ];
    }
}
