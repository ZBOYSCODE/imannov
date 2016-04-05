<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Test extends Model
{
    public $id;

    public function getSource()
    {
        return 'Test';
    }

    public function testing()
    {
       

        //forma 1 phql
        $query = new Query("SELECT * FROM  Gabs\Models\Test", $this->getDI());
        return $query->execute()[0]->id;


        //forma 2 phql
        //$query = "SELECT * FROM  Gabs\Models\Test";
        //$query = $this->modelsManager->createQuery($query);
        //return $query->execute()[0]->id;


        //forma 3 directa mysql, hay que extender baseModel.php
        /*$result=$this->db->query("SELECT * FROM Test"); // Working now
        echo $result->numRows();
        print_r($result->fetchAll());*/
    }

}