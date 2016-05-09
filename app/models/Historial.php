<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Historial extends Model
{
	public $id_historial;

	public $fecha_historial;

	public $hito;

	public $id_user_hito;

	public function selHistorial($id)
    {
        $query = new Query("SELECT h.fecha_historial as fecha, h.hito as hito FROM Gabs\Models\Historial h, Gabs\Models\Users u WHERE h.id_user_hito = u.id AND u.id = $id ORDER BY h.fecha_historial DESC limit 3", $this->getDI());
        return $query->execute();
    }

}