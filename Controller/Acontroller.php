<?php
abstract class Acontroller
{
	function loadModel($modelName="")
	{
		include_once SITE_PATH .'/libraries/DBconnect.php';
		include SITE_PATH .'/Model/'.$modelName . '.php';
		return new $modelName();
	}
	
	function loadView($viewName="",$data=array())
	{
		include_once SITE_PATH .'/libraries/Language.php';
		include SITE_PATH .'/View/'.$viewName . '.php';
	}
	
}
