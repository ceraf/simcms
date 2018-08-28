<?php

namespace Sacprd\PageBundle\Model;

use Sacprd\Core\Admin\Grid\Grid;

class CategoryGrid extends Grid
{
    protected function init()
    {
        $this->action_route = 'sacprd_category_page_action';
        $this->grid_route = 'sacprd_category_page_list';
        $this->title = 'Категории страниц';
        
        parent::init();

        $this->entityname = 'Sacprd\PageBundle\Entity\Category';
        
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
            ]
        ];
    }
}
