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
    const REWRITE_ENTITY = 'Sacprd\SeoBundle\Entity\Rewrite';
    
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
    
    public function setEntity($entity)
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
    
    public function execute($action, $params = [])
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
    
    protected function redirect($route, $params = [])
    {
        return new RedirectResponse($this->container->get('router')->generate($route, $params, 
                            UrlGeneratorInterface::ABSOLUTE_PATH), 302);
    }
    
    protected function render($tempname, $params = [])
    {
        return new Response($this->template->render($tempname, $params));
    }
    
    protected function deleteAction($params)
    {
        $id = $params['id'];
        if ($id) {
            $row = $this->doctrine
					->getRepository($this->entity)
					->find($id);
            $em = $this->doctrine->getEntityManager();
            if ($row) {

						
                try {       
                    if (method_exists($row, 'deleteFiles'))
                        $row->deleteFiles($this->container->getParameter('admin_path'));
                    
                    $em->getConnection()->beginTransaction();
                    if ($row->isHasSeoUrl())
                        $this->deleteRewrite($row->getSeoUrlKey());
                    
                    $em->remove($row);
                    $em->flush();
                    $this->flashMessage('notice', 'Категория удалена.');
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $this->flashMessage('notice', 'При удалении категории произошла ошибка.');
                    $em->getConnection()->rollback();
                }
            } else {
                $this->flashMessage('error', 'При удалении категории произошла ошибка.');
            }
        }
        
        return $this->redirect($this->homeroute);
    }
    
    protected function flashMessage($type, $mes)
    {
        $this->container->get('session')->getFlashBag()->add($type, $mes);
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
                        $this->saveRewrite([
                            'id' => $id,
                            'route' => $form->getData()->getSeoUrlKey(),
                            'url' => $form->getData()->getUrl()
                        ]);                     
                    }
                    
                    $em->getConnection()->commit();
                    $this->flashMessage('notice', 'Категория сохранена.');
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }

                return $this->redirect($this->homeroute);
            }
        } 
           
        return $this->render('@SacprdAdmin/form_edit.html.twig', array(
            'form' => $form->createView(),
            'title' => $this->title,
            'home_route' => $this->homeroute
        ));
    }
    
    protected function deleteRewrite($route)
    {
        $em = $this->doctrine->getEntityManager();
        $seourl = $this->doctrine
                    ->getRepository(self::REWRITE_ENTITY)
                    ->findOneBy(array('route' => $route));
		if ($seourl) {
			$em->remove($seourl);
			$em->flush();
		}           
    }
    
    protected function saveRewrite($data)
    {
        $em = $this->doctrine->getEntityManager();
        if ($data['id']) {
            $seourl = $this->doctrine
                ->getRepository(self::REWRITE_ENTITY)
                ->findOneBy(array('route' => $data['route']));
            if (empty($seourl))
                $seourl = new Rewrite();
        } else 
            $seourl = new Rewrite();

        $seourl->setUrl($data['url']);
        $seourl->setSiteId(0);
        $seourl->setRoute($data['route']);
        $em->persist($seourl);
        $em->flush();  
    }
}
