<?php
namespace Gabs\Services;
use Gabs\Models\Grupo;
use Gabs\Models\HabilidadUserEvaluacion;
use Gabs\Models\Habilidad;
use Gabs\Models\UserHabilidad;
use Gabs\Models\Users;
use Gabs\Models\UserGrupo;
use Gabs\Models\Evaluacion;
use Gabs\Models\Test;
use Gabs\Models\Historial;

// Ejemplo Clase Service
// Usar nombre de modelo y concatenar a 'Service'
class UsersService
{
	public function getCantidadGrupos($id)
	{
		return count(Users::findFirst($id)->userGrupo);
	}

	public function getUserById($id)
	{
		return Users::findFirst($id);
	}

	public function getUsersByGrupo($id)
	{
		return Grupo::findFirst($id)->users;
	}

	public function getCantidadReconocimientosByUser($id)
	{
		return count(HabilidadUserEvaluacion::find("user_evaluado_id = {$id}"));
	}	

	public function getCantidadHabilidadesByUser($id)
	{
		return count(UserHabilidad::find("user_id = {$id}"));
	}

	public function getMes()
	{
		$modelEvaluacion = new Evaluacion();
		return $modelEvaluacion->contadorMes();
	}

	public function getHabilidad()
	{
		$modelHabilidad = new Habilidad();
		return $modelHabilidad->selHabilidad();
	}

	public function getPuntos()
	{
		$modelPuntos = new Test();
		return $modelPuntos->selPuntos();
	}

	public function getHistorial($id)
	{
		$modelHistorial = new Historial();
		return $modelHistorial->selHistorial($id);
	}

	

}