<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sacprd_admin_home', new Route('/home', array(
    '_controller' => 'SacprdAdminBundle:Default:index',
)));

return $collection;
