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

    public function initialize()
    {
        $this->belongsTo('hbld_id', __NAMESPACE__ .'\Habilidad', 'hbld_id',array(
            'alias' => 'habilidad'));
        $this->belongsTo('user_id', __NAMESPACE__ .'\Users', 'id',array(
            'alias' => 'user'));
    }     

}