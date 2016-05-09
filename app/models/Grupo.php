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

    public function getAll()
    {
        $query = new Query("SELECT * FROM  Gabs\Models\Grupo", $this->getDI());
        return $query->execute();
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


        $this->hasManyToMany(
            "grpo_id",
             __NAMESPACE__ ."\UserGrupo",
            "grpo_id",
            "user_id",
            __NAMESPACE__ ."\Users",
            "id",
            array('alias' => 'users')
        );                                 
    }    

    public function getGruposPerfil($id)
    {
        $query = new Query("SELECT g.grpo_nombre as NombreGrupo FROM Gabs\Models\UserGrupo ug, Gabs\Models\Grupo g WHERE ug.grpo_id = g.grpo_id and ug.user_id = $id ORDER BY g.grpo_id asc", $this->getDI());
        return $query->execute();
    }

    public function getUsuarios($id)
    {
        $query = new Query("SELECT ug.grpo_id AS Grupo, COUNT(ug.user_id) AS Usuarios FROM Gabs\Models\UserGrupo ug, Gabs\Models\Grupo g, Gabs\Models\Users u WHERE ug.grpo_id = g.grpo_id AND ug.user_id = u.id GROUP BY ug.grpo_id", $this->getDI());
        return $query->execute();
    }

    public function getRecon($id)
    {
        $query = new Query("SELECT COUNT(eg.eval_grpo_id) as Reconocimientos FROM Gabs\Models\Evaluacion e, Gabs\Models\EvaluacionGrupo eg, Gabs\Models\Grupo g, Gabs\Models\UserGrupo ug WHERE eg.grpo_id = g.grpo_id AND e.eval_id = eg.eval_id AND g.grpo_id = ug.grpo_id AND ug.user_id = $id GROUP BY eg.grpo_id", $this->getDI());
        return $query->execute();
    }

} 