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
                'actions' => $this->actions
            ]);
    }
	
    protected function init()
    {
        $this->actions = [
            'edit' => [
                'title' => 'Редактировать',
                'route' => 'sacprd_page_edit',
                'field_id' => 'id',
                'icon' => 'fa fa-edit',
                'btntype' => 'btn-success',
                'onclick' => ''
            ],
            'delete' => [
                'title' => 'Редактировать',
                'route' => 'sacprd_page_edit',
                'field_id' => 'id',
                'icon' => 'fa fa-trash-o',
                'btntype' => 'btn-danger',
                'onclick' => "return confirm('Действительно удалить?');"
            ],
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
