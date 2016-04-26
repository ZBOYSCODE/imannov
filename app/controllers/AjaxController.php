<?php
namespace Gabs\Controllers;
use Gabs\Services\Services;
use Gabs\Models\Grupo;
use Gabs\Models\UserGrupo;
use Gabs\Models\Enunciado;
use Gabs\Models\Evaluacion;
use Gabs\Models\Habilidad;

class AjaxController extends ControllerBase
{
    
    public function indexAction()
    {

		if ($this->request->isPost() == true) {
            if ($this->request->isAjax() == true) {
                $var = $_POST['id'];
	                   
				$toRend=$this->view->render('ajax/chart_test',array());
				$this->mifaces->addToRend('contenidomodal', $toRend);
						
				
				$this->mifaces->addPosRendEval('
							$graph=$("#graph");
							$("#graph").css("height","300px").css("width","100%");
							var chartMonths = [[1, "Ene"], [2, "Feb"], [3, "Mar"], [4, "Abr"], [5, "May"], [6, "Jun"], [7, "Jul"], [8, "Ago"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dic"]];
							var options = {
			                    colors: ["#3498db", "#333333"],
			                    legend: {show: true, position: "nw", margin: [15, 10]},
			                    grid: {borderWidth: 0, hoverable: true, clickable: true},
			                    yaxis: {tickFormatter: function numberWithCommas(x) {
		                                      return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ".");
		                                }, tickColor: "#eeeeee"},
			                    xaxis: {ticks: chartMonths, tickColor: "#ffffff"},
								lines: {show: true, fill: true, fillColor: {colors: [{opacity: 0.25}, {opacity: 0.25}]}},
			                    points: {show: true, radius: 6}
			                };
							$.plot("#graph", [{"label":"Ventas Promedio (2014)","data":[[1,223051],[2,395018],[3,327369],[4,479781],[5,329013],[6,237118],[7,294326],[8,364281],[9,220785],[10,853165],[11,557843],[12,347478]]}], options);
							$("#modal-large").modal("show");');
							
				$this->mifaces->run();

             }
       }
    }	

    public function cargarEncuestaAction()
    {
    	$modelEnunciado = new Enunciado();
    	$modelHabilidad = new Habilidad();

    	$enunciados = array();
    	$habilidades = array();

    	$idsHabilidades = explode(',', $_POST['ids']);
    	foreach ($idsHabilidades as $id) {
    		array_push($habilidades, $modelHabilidad::findFirst($id));
    	}

    	foreach ($idsHabilidades as $id) {
    		foreach ($modelEnunciado->getByHabilidad($id) as $enunciado) {
    			array_push($enunciados, $enunciado);
    		}
    	}



    	$dataView['enunciados'] = $enunciados;
    	$dataView['habilidades'] = $habilidades;
    	$dataView['jsScript'] = "$('#contador').val(parseInt($('#contador').val())+1);
    	 $('#barra-progreso').css('width',100*parseInt($('#contador').val())/".count($enunciados)."+'%');";

    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/encuesta',$dataView);
		$this->mifaces->addToRend('modal-encuesta', $toRend);
		$this->mifaces->addPosRendEval('$("#modal-encuesta").modal();');
		$this->mifaces->run();
    }

    public function cargarCrearGrupoAction()
    {

        $users = array();

        for ($i=6; $i <11 ; $i++) { 
            array_push($users, Services::getService('Users')->getUserById($i));
        }

        $dataView['users'] = $users;

    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/modal-configurar-grupos',$dataView);
		$this->mifaces->addToRend('modal-nuevo-grupo', $toRend);
		$this->mifaces->addPosRendEval('$("#modal-nuevo-grupo").modal();');
		$this->mifaces->run();    	
    }

    public function cargarEditarGrupoAction()
    {
        $users = array();

        for ($i=6; $i <11 ; $i++) { 
            array_push($users, Services::getService('Users')->getUserById($i));
        }

        $dataView['users'] = $users;

        $dataView['grupo'] = Services::getService('Grupo')->getGrupoById($_POST['id']);

        $users = Services::getService('Users')->getUsersByGrupo($dataView['grupo']->grpo_id);

        $str = '';

        foreach ($users as $user) {
        	$str = $str."$(\"#check-users".$user->id."\").toggleClass('hidden'); 
        				 $(\"#chat-user".$user->id."\").addClass('after-focus');";
        }


    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/modal-configurar-grupos',$dataView);
		$this->mifaces->addToRend('modal-nuevo-grupo', $toRend);
		$this->mifaces->addPosRendEval('$("#modal-nuevo-grupo").modal();'.$str);
		$this->mifaces->run();    	
    }    

    public function guardarGrupoAction()
    {
    	$grupo = new Grupo();
    	
    	$grupo->grpo_nombre = $_POST['nombre'];
    	$grupo->grpo_descripcion = $_POST['descripcion'];
    	$grupo->grpo_tipo_periodicidad = $_POST['tipoPeriodicidad'];
    	$grupo->grpo_cantidad_periodicidad = $_POST['cantidadPeriodicidad'];
    	$grupo->save();
    	$users = explode(',', $_POST['personas']);
    	foreach ($users as $user_id) {
    		$userGrupo = new UserGrupo();
    		$userGrupo->user_id = $user_id;
    		$userGrupo->grpo_id = $grupo->grpo_id;
    		$userGrupo->save();
    	}

    	$dataView['grupos'] = Services::getService('Grupo')->getGrupos();

    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/configurar-grupos-lista',$dataView);
		$this->mifaces->addToRend('listaGrupos', $toRend);
    	$this->mifaces->addPosRendEval("$('#modal-nuevo-grupo').modal('toggle');
    									$.bootstrapGrowl('Grupo Creado Correctamente',{type:'success'});");
    	$this->mifaces->run();
    }

    public function editarGrupoAction()
    {
    	$grupo = new Grupo();
    	
    	$grupo->grpo_id = $_POST['id'];
    	$grupo->grpo_nombre = $_POST['nombre'];
    	$grupo->grpo_descripcion = $_POST['descripcion'];
    	$grupo->grpo_tipo_periodicidad = $_POST['tipoPeriodicidad'];
    	$grupo->grpo_cantidad_periodicidad = $_POST['cantidadPeriodicidad'];
    	$grupo->update();
        /*
    	$users = explode(',', $_POST['personas']);
    	$grupo->grpo_id;
    	foreach ($users as $user_id) {
    		$modelUserGrupo = new UserGrupo();
    		$modelUserGrupo->user_id = $user_id;
    		$modelUserGrupo->grpo_id = $grupo->grpo_id;
    		$modelUserGrupo->update();
    	}*/

    	$grupo = new Grupo();
    	$dataView['grupos'] = Services::getService('Grupo')->getGrupos();

    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/configurar-grupos-lista',$dataView);
		$this->mifaces->addToRend('listaGrupos', $toRend);
    	$this->mifaces->addPosRendEval("$('#modal-nuevo-grupo').modal('toggle');
    									$.bootstrapGrowl('Grupo Editado Correctamente',{type:'success'});");
    	$this->mifaces->run();
    }    
}