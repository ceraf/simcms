<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sacprd_core_login', new Route('/login', array(
    '_controller' => 'SacprdUserBundle:Auth:login',
)));

$collection->add('login_check', new Route('/login_check', array()));

$collection->add('sacprd_group_list', new Route('/admin/groups/{p}', array(
    '_controller' => 'SacprdUserBundle:Admingroups:list',
    'p' => 0
)));

$collection->add('sacprd_group_action', new Route('/admin/group/{action}/{id}', array(
    '_controller' => 'SacprdUserBundle:Admingroups:rowact',
	'id' => 0
)));

$collection->add('sacprd_user_list', new Route('/admin/users/{p}', array(
    '_controller' => 'SacprdUserBundle:Adminusers:list',
    'p' => 0
)));

$collection->add('sacprd_user_action', new Route('/admin/user/{action}/{id}', array(
    '_controller' => 'SacprdUserBundle:Adminusers:rowact',
	'id' => 0
)));

return $collection;
