<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;



class Test extends Model
{
    public function contadorMes()
    {
        $query = new Query("SELECT COUNT(eval_fecha) as cantidad, month(eval_fecha) as mes FROM Gabs\Models\Evaluacion group by month(eval_fecha   )", $this->getDI());
        return $query->execute();
    }
}