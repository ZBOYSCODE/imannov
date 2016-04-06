<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Enunciado extends Model
{
    public $encd_id;

    public $encd_texto;

    public function getSource()
    {
        return 'enunciado';
    }

    public function getAll()
    {
        $query = new Query("SELECT * FROM  Gabs\Models\Enunciado", $this->getDI());
        return $query->execute();        
    }

    public function getByHabilidad($id)
    {
        $query = new Query("SELECT * FROM Gabs\Models\Enunciado WHERE hbld_id = ".$id, $this->getDI());
        return $query->execute(); 
    }

    public function initialize()
    {
        $this->belongsTo('hbld_id', 'Habilidad', 'hbld_id');
    }    

}