<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sacprd_page_list', new Route('/admin/pages', array(
    '_controller' => 'SacprdPageBundle:Adminpages:list',
)));

$collection->add('sacprd_page_edit', new Route('/admin/page/edit/{id}', array(
    '_controller' => 'SacprdPageBundle:Adminpages:edit',
	'id' => 0
)));

$collection->add('sacprd_page_delete', new Route('/admin/page/delete/{id}', array(
    '_controller' => 'SacprdPageBundle:Adminpages:delete',
)));

return $collection;
