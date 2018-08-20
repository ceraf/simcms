<?php

namespace Sacprd\Core\Admin\Grid;

use Symfony\Component\HttpFoundation\Request;
use \stdClass;

abstract class Grid
{
    const SESSION_COUNT_ITEMS = 'numitems';
    
    private $doctrine;
	private $template;
    private $session;
    protected $entityname;
    protected $collection;
    protected $paginator;
    protected $fields;
    protected $actions;
    protected $buttons;
    protected $action_route;
    protected $grid_route;
    protected $title = 'Grid';
    protected $request;
    protected $itemsonpage = 3;

    public function __construct (Request $request)
    {
        $this->request = $request;
        $this->session = $request->getSession();
        $this->itemsonpage = ($this->session->get((new \ReflectionClass($this))->getShortName().'_'.self::SESSION_COUNT_ITEMS)) ?? $this->itemsonpage;
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

    public function getResponse()
    {
        if (!$this->collection)
            $this->fetch();
            
        return $this->template->render('@SacprdAdmin/grid.html.twig',
            [
                'rows' => $this->getCollection(),
                'paginator' => $this->paginator,
                'grid_route' => $this->grid_route,
                'fields' => $this->fields,
                'actions' => $this->actions,
                'buttons' => $this->buttons,
                'title' => $this->title
            ]);
    }

    protected function getCollection()
    {
        if (empty($this->collection))
            $this->fetch();
            
        return $this->collection;
    }
    
    protected function init()
    {
        $this->actions['edit'] = [
                'title' => 'Редактировать',
                'route' => $this->action_route,
                'action' => 'edit',
                'field_id' => 'id',
                'icon' => 'fa fa-edit',
                'btntype' => 'btn-success',
                'onclick' => ''
        ];
        $this->actions['delete'] = [
                'title' => 'Удалить',
                'route' => $this->action_route,
                'action' => 'delete',
                'field_id' => 'id',
                'icon' => 'fa fa-trash-o',
                'btntype' => 'btn-danger',
                'onclick' => "return confirm('Действительно удалить?');"
        ];
        
        $this->buttons['add'] = [
            'title' => 'Добавить',
            'route' => $this->action_route,
            'action' => 'edit',
            'btnstyle' => 'btn btn-primary',
        ];
    }

    protected function getPaginator($total, $p)
    {
        if (!$total)
            return null;
    
        $count = ($this->request->get('page_count')) ?? null;
        if ($count && in_array($count, [10,25,50,100])) {
            
            $this->session->set((new \ReflectionClass($this))->getShortName().'_'.self::SESSION_COUNT_ITEMS, $count);
            $this->itemsonpage = $count;
        }

        $paginator = new stdClass;
        $paginator->total = $total;
        $paginator->currpage = $p;
        $paginator->numpages = ceil($paginator->total/$this->itemsonpage);
        $paginator->itemsonpage = $this->itemsonpage;

        return $paginator;        
    }
    
    protected function fetch()
    {
        $p = $this->request->get('p') ?? '0';
        try {
            $total = $this->doctrine
                ->getEntityManager()
                ->createQueryBuilder()
                ->select('count(p.id)')
                ->from($this->entityname,'p')
                ->getQuery()
                ->getSingleScalarResult();        
        
            $this->paginator = $this->getPaginator($total, $p);
            
            $offset = $p*$this->itemsonpage;
            $this->collection = $this->doctrine
                            ->getRepository($this->entityname)
                            ->getByPage($this->entityname, $offset, $this->itemsonpage);
        } catch (Exception $e) {
            throw new Exception('Ошибка базы данных.');
        }
        return $this;
    }
}
