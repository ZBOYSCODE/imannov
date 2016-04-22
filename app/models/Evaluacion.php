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
}