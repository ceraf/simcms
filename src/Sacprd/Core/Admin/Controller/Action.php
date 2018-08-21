<?php

namespace Sacprd\Core\Admin\Controller;

use Sacprd\PageBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;
use Sacprd\SeoBundle\Entity\Rewrite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Action
{
    protected $entity;
    protected $container;
    protected $formclass;
    protected $actionname;
    protected $request;
    protected $doctrine;
    protected $template;
    protected $homeroute;
    
    public function __construct(Request $request, $container)
    {
        $this->request = $request;
        $this->container = $container;
        return $this;
    }
    
    public function setDoctrine($doctrine)
    {
        $this->doctrine = $doctrine;
        return $this;
    }
    
    public function setEntiry($entity)
    {
        $this->entity = $entity;
        return $this;
    }
    
    public function setForm($formclass)
    {
        $this->formclass = $formclass;
        return $this;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    public function execute($action, $params)
    {
        $action .= 'Action';
        return $this->$action($params);
    }
    
	public function setTemplating($template)
	{
		$this->template = $template;
		return $this;
	}
    
    public function setHomeRoute($homeroute)
    {
		$this->homeroute = $homeroute;
		return $this;        
    }
    
    protected function editAction($params)
    { 
        $id = $params['id'];
		if ($id) {
			$row = $this->doctrine
					->getRepository($this->entity)
					->find($id);      
		} else {
			$row = new $this->entity();
        }

        $form = $this->container->get('form.factory')->create($this->formclass, $row, []);
 
        if ($this->request->getMethod() == 'POST') {
            $form->handleRequest($this->request);
            
            if ($form->isValid()) {
                if (method_exists($row, 'saveFiles'))
                    $row->saveFiles($this->request->files, $this->container->getParameter('admin_path'));
		
                $em = $this->doctrine->getEntityManager();
                $em->getConnection()->beginTransaction();
                try {
                    $em->persist($form->getData());
                    $em->flush();
                    
                    if ($row->isHasSeoUrl()) {
                        if ($id) {
                            $seourl = $this->doctrine
                                    ->getRepository('Sacprd\SeoBundle\Entity\Rewrite')
                                    ->findOneBy(array('route' => $form->getData()->getSeoUrlKey()));
                            if (empty($seourl))
                                $seourl = new Rewrite();
                        } else 
                            $seourl = new Rewrite();

                        $seourl->setUrl($form->getData()->getUrl());
                        $seourl->setSiteId($form->getData()->getSiteId());
                        $seourl->setRoute($form->getData()->getSeoUrlKey());
                        $em->persist($seourl);
                        $em->flush();                    
                    }
                    
                    $em->getConnection()->commit();
                    $this->container->get('session')->getFlashBag()->add('notice', 'Категория сохранена.');
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }

                return new RedirectResponse($this->container->get('router')->generate($this->homeroute, [], 
                            UrlGeneratorInterface::ABSOLUTE_PATH), 302);
            }
        } 
           
        return new Response($this->template->render('@SacprdPage/Categories/adm_edit.html.twig', array(
            'form' => $form->createView(),
            'title' => $this->title,
            'home_route' => $this->homeroute
        )));
    }
}
