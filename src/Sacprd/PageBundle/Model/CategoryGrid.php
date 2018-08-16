<?php

namespace Sacprd\PageBundle\Model;

use Sacprd\Core\Admin\Grid\Grid;

class CategoryGrid extends Grid
{
    protected function init()
    {
        $this->route = 'sacprd_page_action';
        
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
            ],
        ];
    }
}
