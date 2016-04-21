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

    public function initialize()
    {
        $this->belongsTo('grpo_id', __NAMESPACE__ .'\Grupo', 'grpo_id',array(
            'alias' => 'grupo'));
        $this->belongsTo('user_id', __NAMESPACE__ .'\Users', 'id',array(
            'alias' => 'user'));
    }    

}