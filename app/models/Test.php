<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;



class Test extends Model
{
    public function contadorMes()
    {
        $query = new Query("SELECT COUNT(eval_fecha) as cantidad, month(eval_fecha) as mes FROM Gabs\Models\Evaluacion group by month(eval_fecha)", $this->getDI());
        return $query->execute();
    }

    public function selHabilidad($id)
    {
        $query = new Query("SELECT a.porcentaje, b.hbld_nombre from Gabs\Models\UserHabilidad a, Gabs\Models\Habilidad b, Gabs\Models\Users c WHERE a.user_id = c.id and a.hbld_id = b.hbld_id and c.id = $id order by a.porcentaje desc limit 6", $this->getDI());
        return $query->execute();
    }

    public function selPuntos($id)
    {
        $query = new Query("SELECT month(a.fecha_puntos) as Mes, SUM(a.puntos_his) as Puntos FROM Gabs\Models\PuntosHistoricos a, Gabs\Models\Users b WHERE a.user_puntos_id = b.id and b.id = $id GROUP BY month(fecha_puntos) ORDER BY month(fecha_puntos)", $this->getDI());
        return $query->execute();
    }

    public function selHistorial($id)
    {
        $query = new Query("SELECT h.fecha_historial as fecha, h.hito as hito FROM Gabs\Models\Historial h, Gabs\Models\Users u WHERE h.id_user_hito = u.id AND u.id = $id ORDER BY h.fecha_historial", $this->getDI());
        return $query->execute();
    }

}