<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sacprd_core_login', new Route('/login', array(
    '_controller' => 'SacprdUserBundle:Auth:login',
)));

$collection->add('login_check', new Route('/login_check', array()));

return $collection;
