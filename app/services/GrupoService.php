<?php
namespace Gabs\Services;
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
}
