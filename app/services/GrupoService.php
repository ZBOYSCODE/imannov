<?php
namespace Gabs\Services;
use Gabs\Models\Grupo;
use Gabs\Models\Users;
use Gabs\Models\UserGrupo;
use Gabs\Models\Evaluacion;


// Ejemplo Clase Service
// Usar nombre de modelo y concatenar a 'Service'
class GrupoService
{
	public function getGruposByUser($id)
	{
		return Users::findFirst($id)->grupos;
	}

	public function getGrupoById($id)
	{
		return Grupo::findFirst($id);
	}

	public function getGrupos()
	{
		return Grupo::find();
	}

}
