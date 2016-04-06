<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class UserGrupo extends Model
{
    public $user_grpo_id;

    public $user_id;

    public $grpo_id;

    public function getSource()
    {
        return 'user_grupo';
    }



    public function getByGrupo($id)
    {
        $query = new Query("SELECT * FROM  Gabs\Models\UserGrupo WHERE grpo_id = ".$id, $this->getDI());
        return $query->execute();   
    }    

    public function initialize()
    {
        $this->belongsTo('grpo_id', 'Calin\Core\Models\Grupo', 'grpo_id', 
            array('alias' => 'grupo')
        );
        $this->belongsTo('user_id', 'Calin\Core\Models\Users', 'id', 
            array('alias' => 'user')
        );
    }    

}