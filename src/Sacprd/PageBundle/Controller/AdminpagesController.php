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
    public function listAction()
    {
		return $this->getGrid(new CategoryGrid());				
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
		if ($id) {
			$category = $this->getDoctrine()
					->getRepository('Sacprd\PageBundle\Entity\Category')
					->find($id);
        //    if ($category->getPreview())
          //      $category->setPreview(new File($this->getParameter('brochures_directory').'/'.$category->getPreview()));        
		} else {
			$category = new Category();
        }
        
        $form = $this->createForm(CategoryForm::class, $category);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            
            
            if ($form->isValid()) {
           
            
				if ($category->getFilesFileds()) {
					foreach ($category->getFilesFileds() as $field => $item) {

                        
                        $file = $request->files->get($field);
                                if ($file ) {
                                    $fileUploader = new FileUploader($this->getParameter('admin_path').$item['path']);
                                    $fileName = $fileUploader->upload($file);
                                    $method = 'set'.ucfirst($field);
                                    $category->$method($fileName);
                                }                         
                    }
                        /*
                        $file = $category->$func['get']();
				if ($category->getFilesFileds()) {
					foreach ($category->getFilesFileds() as $field => $item) {
                        $file = $request->files->get($field);
						if ($file ) {
                            $fileUploader = new FileUploader($item['path']);
							$fileName = $fileUploader->upload($file);
							$category->$item['set']($fileName);
						}  
                        
                        $file = $category->$func['get']();
                        $fileName = $fileUploader->upload($file);
                        $category->$func['set']($fileName);
                    
						$file = $category->$func['get']();
						$fileName = md5(uniqid()).'.'.$file->guessExtension();
						$file->move(
							$this->getParameter('brochures_directory'),
							$fileName
						);
						$category->$func['set']($fileName);
                        */
					//}
				}
				
				
				

				
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($form->getData());
                $em->flush();
                
                if ($category->isHasSeoUrl()) {
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

				$this->get('session')->getFlashBag()->add('notice', 'Категория сохранена.');
                return $this->redirect($this->generateUrl('sacprd_page_list'));
            }
        }
        
        return $this->render('@SacprdPage/Categories/adm_edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
        
        /*
$author = new Acme\BlogBundle\Entity\Author();
$form = $this->createForm(new AuthorType(), $author);
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
        if ($form->isValid()) {

            $this->redirect($this->generateUrl('...'));
        }
}
return $this->render('BlogBundle:Author:form.html.twig', array(
'form' => $form->createView(),
));
		$category = $this->getDoctrine()
					->getRepository('Sacprd\PageBundle\Entity\Category')
					->find($id);
        if (!$category) {
            throw $this->createNotFoundException('No category found for id '.$id);
            }
        return $this->render('SacprdPageBundle:Categories:adm_edit.html.twig', array('item' => $category));
*/
    }
}
