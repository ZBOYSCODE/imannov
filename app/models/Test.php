<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Test extends Model
{
    public function contadorMes()
    {
        $query = new Query("SELECT COUNT(eval_fecha), month(eval_fecha) FROM evaluacion group by month(eval_fecha   )");
        return $query->execute();
    }
}