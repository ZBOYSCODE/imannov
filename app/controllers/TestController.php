<?php
namespace Gabs\Controllers;

use \Gabs\Services\Services as Services;
use Gabs\Models\Test;
use Gabs\Models\Grupo;

class TestController extends ControllerBase
{
	public function indexAction()
	{

		$testModel = new Test();
		foreach ($testModel->contadorMes() as $val) {  
		$fecha=$val->mes;
        $meses = array('','Enero ','Febrero ','Marzo ', 'Abril ', 'Mayo ', 'Junio ', 'Julio ', 'Agosto ', 'Septiembre ', 'Octubre ', 'Noviembre ', 'Diciembre ');
			/*
			print($meses[$fecha]); 
			print(" - cantidad: {$val->cantidad}");
			print "</br>";*/
		};

		$user_id = $this->auth->getIdentity()['id'];

		$modelTest = new Test();
		$pcData['habil'] = $modelTest->selHabilidad($user_id);
		foreach ($pcData['habil'] as $var){
			/*print ("{$var->porcentaje} ");
			print ($var->hbld_nombre);
			print "</br>";*/
		}

		$modelPuntos = new Test();
		$pcData['punto'] = $modelPuntos->selPuntos($user_id);
		foreach ($pcData['punto'] as $pto) {
		$meis=$pto->Mes;
			/*print($meses[$meis]);
			print($pto->Puntos);
			print "</br>";*/
		}

		$modelHistorial = new Test();
		$pcData['historial'] = $modelHistorial->selHistorial($user_id);
		/*foreach ($pcData['historial'] as $hito) {
			print_r("{$hito->fecha} - ");
			print_r($hito->hito);
			print "</br>";
		}
		exit();*/


	}

}

/*for ($i=0; $i < count($pcData['grupos']); $i++) { 
            print_r("Grupos: ");
            print_r(count($pcData['grupos'][$i]['NombreGrupo']));
            print "</br>";
        }
        exit();*/