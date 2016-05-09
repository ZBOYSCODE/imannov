<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Habilidad extends Model
{
    public $hbld_id;

    public $hbld_nombre;

    public function getSource()
    {
        return 'habilidad';
    }

    public function getAll()
    {
        $query = new Query("SELECT * FROM  Gabs\Models\Habilidad", $this->getDI());
        return $query->execute();        
    }

    public function initialize()
    {
        $this->hasMany(
            "hbld_id",
            __NAMESPACE__ ."\HabilidadUserEvaluacion",
            "hbld_id",
            array(
            'alias' => 'habilidadUserEvaluacion')
        );

        $this->hasMany(
            "hbld_id",
            __NAMESPACE__ ."\UserHabilidad",
            "hbld_id",
            array(
            'alias' => 'userHabilidad')
        );        
    }    

    public function selHabilidad($id)
    {
        $query = new Query("SELECT a.porcentaje, b.hbld_nombre from Gabs\Models\UserHabilidad a, Gabs\Models\Habilidad b, Gabs\Models\Users c WHERE a.user_id = c.id and a.hbld_id = b.hbld_id and c.id = $id order by a.porcentaje desc limit 6", $this->getDI());
        return $query->execute();
    }
}