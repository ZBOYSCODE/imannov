<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Evaluacion extends Model
{
    public $eval_id;

    public $eval_fecha;

    public function getSource()
    {
        return 'evaluacion';
    }

    public function initialize()
    {
        $this->hasMany(
            "eval_id",
            __NAMESPACE__ ."\HabilidadUserEvaluacion",
            "eval_id",
            array(
            'alias' => 'habilidadUserEvaluacion')
        );
    }    

     public function getAll()
    {
        $query = new Query("SELECT * FROM  Gabs\Models\Evaluacion", $this->getDI());
        return $query->execute();
            
    }

    public function contadorMes()
    {
        $query = new Query("SELECT COUNT(eval_fecha) as cantidad, month(eval_fecha) as mes FROM Gabs\Models\Evaluacion group by month(eval_fecha)", $this->getDI());
        return $query->execute();
    }

    
}