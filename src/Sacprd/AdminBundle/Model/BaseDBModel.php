<?php

namespace Sacprd\AdminBundle\Model;
    
interface BaseDBModel
{
    public function isHasSeoUrl();
    public function getSeoUrlKey();
	
}