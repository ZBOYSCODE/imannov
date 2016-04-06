<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Grupo extends Model
{
    public $grpo_id;

    public $grpo_nombre;

    public function getSource()
    {
        return 'grupo';
    }

    public function testing()
    {
       

        //forma 1 phql
        $query = new Query("SELECT * FROM  Gabs\Models\Grupo", $this->getDI());
        return $query->execute();


        //forma 2 phql
        //$query = "SELECT * FROM  Gabs\Models\Test";
        //$query = $this->modelsManager->createQuery($query);
        //return $query->execute()[0]->id;


        //forma 3 directa mysql, hay que extender baseModel.php
        /*$result=$this->db->query("SELECT * FROM Test"); // Working now
        echo $result->numRows();
        print_r($result->fetchAll());*/
    }

    public function getAll()
    {
        $query = new Query("SELECT * FROM  Gabs\Models\Grupo", $this->getDI());
        return $query->execute();        
    }

}