<?php

namespace Sacprd\PageBundle\Model;

use Sacprd\Core\Admin\Grid\Grid;

class PageGrid extends Grid
{
    protected function init()
    {
        $this->action_route = 'sacprd_page_action';
        $this->grid_route = 'sacprd_page_list';
        $this->title = 'Cтраницы';
        
        parent::init();

        $this->entityname = 'Sacprd\PageBundle\Entity\Page';
        
        $this->fields = [
            'title' => [
                'name' => 'title',
                'label' => 'Название',
                'style' => ''
            ],
            
            'url' => [
                'name' => 'url',
                'label' => 'Ссылка',
                'style' => ''
            ],
            
            'url' => [
                'name' => 'url',
                'label' => 'Ссылка',
                'style' => ''
            ],
            'categoryname' => [
                'name' => 'categoryname',
                'label' => 'Категория',
                'style' => ''
            ],
        ];
    }
}
