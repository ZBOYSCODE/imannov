<?php

namespace Gabs\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;


class EvaluacionGrupo extends Model
{
    public $eval_grpo_id;

    public $grpo_id;

    public $eval_id;

    public function getSource()
    {
        return 'evaluacion_grupo';
    }

    
}