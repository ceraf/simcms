<?php

namespace Sacprd\Core\Admin\Grid;

abstract class Grid
{
    private $doctrine;
	private $template;
    protected $entityname;
    protected $collection;
    protected $fields;
    protected $actions;
    protected $buttons;
    protected $route;

    public function __construct ()
    {
        $this->init();
        return $this;
    }
    
	public function setDoctrine($doctrine)
	{
		$this->doctrine = $doctrine;
		return $this;
	}
	
	public function setTemplating($template)
	{
		$this->template = $template;
		return $this;
	}
	
    public function getCollection()
    {
        if (!$this->collection)
            $this->fetch();
            
        return $this->collection;
    }
    
    public function getResponse()
    {
        if (!$this->collection)
            $this->fetch();
            
        return $this->template->render('@SacprdAdmin/grid.html.twig',
            [
                'rows' => $this->getCollection(),
                'fields' => $this->fields,
                'actions' => $this->actions,
                'buttons' => $this->buttons
            ]);
    }

    protected function init()
    {
        $this->actions['edit'] = [
                'title' => 'Редактировать',
                'route' => $this->route,
                'action' => 'edit',
                'field_id' => 'id',
                'icon' => 'fa fa-edit',
                'btntype' => 'btn-success',
                'onclick' => ''
        ];
        $this->actions['delete'] = [
                'title' => 'Удалить',
                'route' => $this->route,
                'action' => 'delete',
                'field_id' => 'id',
                'icon' => 'fa fa-trash-o',
                'btntype' => 'btn-danger',
                'onclick' => "return confirm('Действительно удалить?');"
        ];
        
        $this->buttons['add'] = [
            'title' => 'Добавить',
            'route' => $this->route,
            'action' => 'edit',
            'btnstyle' => 'btn btn-primary'
        ];
    }

    protected function fetch()
    {
        $this->collection = $this->doctrine
                            ->getRepository($this->entityname)
                            ->findBy(array());
        return $this;
    }
}
