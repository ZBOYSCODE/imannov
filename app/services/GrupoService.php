<?php
namespace Gabs\Services;
use Gabs\Models\Grupo;
use Gabs\Models\Users;
use Gabs\Models\UserGrupo;


// Ejemplo Clase Service
// Usar nombre de modelo y concatenar a 'Service'
class GrupoService
{
	public function getGruposByUser($id)
	{
		return Users::findFirst($id)->grupos;
	}

	public function getGrupoByGrupo($id)
	{
		return Users::find($id);
	}

	public function getGrupos($id)
	{
		return Grupo::find($id);
	}
}
