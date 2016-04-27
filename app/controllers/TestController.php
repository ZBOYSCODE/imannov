<?php
namespace Gabs\Controllers;

use \Gabs\Services\Services as Services;
use Gabs\Models\Test;


class TestController extends ControllerBase
{
	public function indexAction()
	{
		$testModel = new Test();
		foreach ($testModel->contadorMes() as $val) {
			print("cantidad: {$val->cantidad} mes: {$val->mes}");
		};
	}

	public function ondexAction()
	{
		echo 'Test2';
	}
		
	
	
  
}