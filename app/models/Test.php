<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class Test extends BaseModel
{
    public $id;

    public $nombre;

    public function getSource()
    {
        return 'test';
    }

    public function testing()
    {
        //$query = new Query("SELECT * FROM Test");

        //return $query->execute();

        $result=$this->db->query("SELECT * FROM Test"); // Working now
        echo $result->numRows();
        print_r($result->fetchAll());
    }

}