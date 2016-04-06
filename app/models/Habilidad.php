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
        $this->hasMany('hbld_id', 'Enunciado', 'hbld_id');
    }

}