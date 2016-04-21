<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;
use Gabs\Models\Grupo;
use Gabs\Models\UserGrupo;


class Grupo extends Model
{
    public $grpo_id;

    public $grpo_nombre;

    public $grpo_descripcion;

    public $grpo_tipo_periodicidad;

    public $grpo_cantidad_periodicidad;

    public function getSource()
    {
        return 'grupo';
    }

    public function columnMap()
    {
        return array(
            'grpo_id' => 'grpo_id',
            'grpo_nombre' => 'grpo_nombre',
            'grpo_descripcion' => 'grpo_descripcion',
            'grpo_tipo_periodicidad' => 'grpo_tipo_periodicidad',
            'grpo_cantidad_periodicidad' => 'grpo_cantidad_periodicidad'
        );
    }

    public function initialize()
    {
        $this->hasMany(
            "grpo_id",
            __NAMESPACE__ ."\UserGrupo",
            "grpo_id",
            array(
            'alias' => 'userGrupo')
        );
    }    

}
