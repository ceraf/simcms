<?php

namespace Sacprd\AdminBundle\Model\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Sacprd\PageBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;
use Sacprd\SeoBundle\Entity\Rewrite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Action
{
    use ControllerTrait;
    
    const REWRITE_ENTITY = 'Sacprd\SeoBundle\Entity\Rewrite';
    
    protected $entity;
    protected $container;
    protected $formclass;
    protected $actionname;
    protected $request;
    protected $homeroute;
    
    public function __construct(Request $request, $container)
    {
        $this->request = $request;
        $this->container = $container;
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
    
    public function setHomeRoute($homeroute)
    {
		$this->homeroute = $homeroute;
		return $this;        
    }
    
    protected function deleteAction($params)
    {
        $id = $params['id'];
        if ($id) {
            $row = $this->getDoctrine()
					->getRepository($this->entity)
					->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            if ($row) {
                try {       
                    if (method_exists($row, 'deleteFiles'))
                        $row->deleteFiles($this->container->get('file_uploader'));
                    
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
        
        return $this->redirect($this->generateUrl($this->homeroute));
    }
    
    protected function flashMessage($type, $mes)
    {
        $this->container->get('session')->getFlashBag()->add($type, $mes);
    }
    
    protected function editAction($params)
    { 
        $id = $params['id'];
		if ($id) {
			$row = $this->getDoctrine()
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
                    $row->saveFiles($this->request->files, $this->container->get('file_uploader'));
		
                $em = $this->getDoctrine()->getEntityManager();
                $em->getConnection()->beginTransaction();
                try {
                    $em->persist($form->getData());
                    $em->flush();
                    
                    if ($row->isHasSeoUrl()) {
                        $this->saveRewrite([
                            'id' => $id,
                            'routedata' => $form->getData()->getSeoUrlKey(),
                            'url' => $form->getData()->getUrl()
                        ]);                     
                    }
                    
                    $em->getConnection()->commit();
                    $this->flashMessage('notice', 'Категория сохранена.');
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }

                return $this->redirect($this->generateUrl($this->homeroute));
            }
        } 
           
        return $this->render('@SacprdAdmin/'.$this->getLayoutName().'/form/form_edit.html.twig', array(
            'form' => $form->createView(),
            'title' => $this->title,
            'home_route' => $this->homeroute
        ));
    }
    
	protected function getLayoutName()
	{
		return $this->container->getParameter('admin_layout');
	}
	
    protected function deleteRewrite($data)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $seourl = $this->getDoctrine()
                    ->getRepository(self::REWRITE_ENTITY)
                    ->findOneBy(array('route' => $data['route'], 'params' => serialize($data['params'])));
		if ($seourl) {
			$em->remove($seourl);
			$em->flush();
		}           
    }
    
    protected function saveRewrite($data)
    {
        $data['routedata']['params'] = serialize($data['routedata']['params']);
        $em = $this->getDoctrine()->getEntityManager();
        if ($data['id']) {
            $seourl = $this->getDoctrine()
                ->getRepository(self::REWRITE_ENTITY)
                ->findOneBy(array('route' => $data['routedata']['route'], 
                        'params' => $data['routedata']['params']));
            if (empty($seourl))
                $seourl = new Rewrite();
        } else 
            $seourl = new Rewrite();

        $seourl->setUrl($data['url']);
        $seourl->setSiteId(0);
        $seourl->setRoute($data['routedata']['route']);
        $seourl->setParams($data['routedata']['params']);
        $em->persist($seourl);
        $em->flush();  
    }
}
