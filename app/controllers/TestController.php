<?php
namespace Gabs\Controllers;

use \Gabs\Services\Services as Services;
use Gabs\Models\Test;


class TestController extends ControllerBase
{
	public function indexAction()
	{
		var_dump(Test::contadorMes());
	}

	public function ondexAction()
	{
		echo 'Test2';
	}
		
	
	
  
}