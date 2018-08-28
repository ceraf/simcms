<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sacprd_category_page_list', new Route('/admin/page_categories/{p}', array(
    '_controller' => 'SacprdPageBundle:Admincategory:list',
    'p' => 0
)));

$collection->add('sacprd_category_page_action', new Route('/admin/page_category/{action}/{id}', array(
    '_controller' => 'SacprdPageBundle:Admincategory:rowact',
	'id' => 0
)));

$collection->add('sacprd_page_list', new Route('/admin/pages/{p}', array(
    '_controller' => 'SacprdPageBundle:Adminpage:list',
    'p' => 0
)));

$collection->add('sacprd_page_action', new Route('/admin/page/{action}/{id}', array(
    '_controller' => 'SacprdPageBundle:Adminpage:rowact',
	'id' => 0
)));
/*
$collection->add('sacprd_page_edit', new Route('/admin/page/edit/{id}', array(
    '_controller' => 'SacprdPageBundle:Adminpages:edit',
	'id' => 0
)));

$collection->add('sacprd_page_delete', new Route('/admin/page/delete/{id}', array(
    '_controller' => 'SacprdPageBundle:Adminpages:delete',
)));
*/
return $collection;
