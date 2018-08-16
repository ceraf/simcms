<?php

namespace Sacprd\Core;
    
interface BaseDBModel
{
    public function isHasSeoUrl();
	public function getFilesFileds();
    public function getSeoUrlKey();
	
}