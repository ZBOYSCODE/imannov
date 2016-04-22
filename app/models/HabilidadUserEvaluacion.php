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

    public function initialize()
    {
        $this->belongsTo('hbld_id', __NAMESPACE__ .'\Habilidad', 'hbld_id',array(
            'alias' => 'habilidad'));
        $this->belongsTo('user_evaluador_id', __NAMESPACE__ .'\Users', 'id',array(
            'alias' => 'userEvaluador'));
        $this->belongsTo('user_evaluado_id', __NAMESPACE__ .'\Users', 'id',array(
            'alias' => 'userEvaluado'));    
        $this->belongsTo('eval_id', __NAMESPACE__ .'\Evaluacion', 'eval_id',array(
            'alias' => 'evaluacion'));                   
    }     

}