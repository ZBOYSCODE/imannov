<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class HabilidadUserEvaluacion extends Model
{
    public $hbld_user_eval_id;

    public $user_evaluador_id;

    public $user_evaluado_id;

    public $eval_id;

    public $hbld_id;

    public $puntos;

    public function getSource()
    {
        return 'habilidad_user_evaluacion';
    }

    public function getHabilidadUserEvaluacion($id){

    $query = new Query("SELECT count(*) FROM  Gabs\Models\HabilidadUserEvaluacion where user_evaluado_id = ".$id." group by eval_id", $this->getDI());
        return $query->execute();

    }

}