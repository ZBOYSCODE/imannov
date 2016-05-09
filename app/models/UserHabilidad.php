<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class UserHabilidad extends Model
{
    public $user_hbld_id;

    public $porcentaje;

    public $user_id;

    public $hbld_id;


    public function getSource()
    {
        return 'user_habilidad';
    }

    public function getUserHabilidad($id){

    $query = new Query("SELECT count(*) FROM  Gabs\Models\UserHabilidad where user_id = ".$id, $this->getDI() );
        return $query->execute();

    }


}