<?php

namespace Sacprd\PageBundle\Controller;


use Sacprd\PageBundle\Entity\Category;
use Sacprd\SeoBundle\Entity\Rewrite;
use Sacprd\PageBundle\Form\CategoryForm;

use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Sacprd\PageBundle\Model\CategoryGrid;
use Sacprd\Core\Admin\Controller\AdminController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AdminpagesController extends AdminController
{
    public function listAction(Request $request)
    {
		return $this->getGrid(new CategoryGrid($request));				
    }
	
    public function rowactAction($id, $action, Request $request)
    {
        $method = $action . 'Action';
        return $this->$method($id, $request);
    }
    
	public function deleteAction($id)
    {
        if ($id) {
            $category = $this->getDoctrine()
					->getRepository('Sacprd\PageBundle\Entity\Category')
					->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            
            if ($category) {
				$seourl = $this->getDoctrine()
					->getRepository('Sacprd\SeoBundle\Entity\Rewrite')
                    ->findOneBy(array('route' => $category->getSeoUrlKey()));
						
                try {
                    $em->remove($category);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice', 'Категория удалена.');
					if ($seourl) {
						$em->remove($seourl);
						$em->flush();
					}
                } catch (Exception $e) {
                    $this->get('session')->getFlashBag()->add('notice', 'При удалении категории произошла ошибка.');
                }
            } else {
                $this->get('session')->getFlashBag()->add('error', 'При удалении категории произошла ошибка.');
            }
        }   
        
        return $this->redirect($this->generateUrl('sacprd_page_list'));    
    }
    
	public function editAction($id, Request $request)
	{
        return $this->getFormAction($request)
                ->setEntiry('Sacprd\PageBundle\Entity\Category')
                ->setForm(CategoryForm::class)
                ->setTitle(($id) ? 'Редактировать категорию' : 'Создать категорию')
                ->setHomeRoute('sacprd_page_list')
                ->execute('edit', ['id' => $id]);
        exit;
		$entity = 'Sacprd\PageBundle\Entity\Category';
		$formclass = CategoryForm::class;
		
		if ($id) {
			$row = $this->getDoctrine()
					->getRepository($entity)
					->find($id);      
		} else {
			$row = new $entity();
        }
        
        $title = ($id) ? 'Редактировать категорию' : 'Создать категорию';
        $homeroute = 'sacprd_page_list';
        
        $form = $this->createForm($formclass, $row);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            
            
            if ($form->isValid()) {
                if (method_exists($row, 'saveFiles'))
                    $row->saveFiles($request->files, $this->getParameter('admin_path'));
		
                $em = $this->getDoctrine()->getEntityManager();
                $em->getConnection()->beginTransaction();
                try {
                    $em->persist($form->getData());
                    $em->flush();
                    
                    if ($row->isHasSeoUrl()) {
                        if ($id) {
                            $seourl = $this->getDoctrine()
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
                    $this->get('session')->getFlashBag()->add('notice', 'Категория сохранена.');
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }
                return $this->redirect($this->generateUrl($homeroute));
            }
        }
        
        return $this->render('@SacprdPage/Categories/adm_edit.html.twig', array(
            'form' => $form->createView(),
            'title' => $title,
            'home_route' => $homeroute
        ));
    }
}
