<?php

namespace Sacprd\Core\Admin\Grid;

abstract class Grid
{
    private $doctrine;
	private $template;
    protected $entityname;
    protected $collection;

    public function __construct ()
    {
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
            
        return $this->template->render('@SacprdAdmin/grid.html.twig', array('categories' => $this->collection));
    }
	
    protected function fetch()
    {
        $this->collection = $this->doctrine
                                ->getRepository($this->entityname)
                                ->findBy(array());
        return $this;
    }
}
