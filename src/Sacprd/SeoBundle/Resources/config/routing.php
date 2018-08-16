<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sacprd_seo', new Route('/{url}', array(
    '_controller' => 'SacprdSeoBundle:Rewrite:index',
), array(
    'url' => '.+',
)));

return $collection;
