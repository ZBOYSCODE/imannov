<?php
namespace Gabs\Controllers;
use Gabs\Models\Personas;
use Gabs\Models\Enunciado;
use Gabs\Models\Habilidad;
use Gabs\Models\Users;
use Gabs\Models\Grupo;
use Gabs\Models\UserGrupo;
 
class AjaxController extends ControllerBase
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
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

        $modelUser = new Users();

        $users = array();

        for ($i=6; $i <11 ; $i++) { 
            array_push($users, $modelUser::findFirst($i));
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

        $modelUser = new Users();
        $modelGrupo = new Grupo();
        $modelUserGrupo = new UserGrupo();

        $users = array();

        for ($i=6; $i <11 ; $i++) { 
            array_push($users, $modelUser::findFirst($i));
        }

        $dataView['users'] = $users;

        $dataView['grupo'] = $modelGrupo::findFirst($_POST['id']);

        $userGrupos = $modelUserGrupo->getByGrupo($dataView['grupo']->grpo_id);

        $users = array();

        foreach ($userGrupos as $userGrupo) {
        	array_push($users, $userGrupo->user_id);
        }

        $str = '';

        foreach ($users as $user_id) {
        	$str = $str."$(\"#check-users".$user_id."\").toggleClass('hidden'); 
        				 $(\"#chat-user".$user_id."\").addClass('after-focus');";
        }


    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/modal-configurar-grupos',$dataView);
		$this->mifaces->addToRend('modal-nuevo-grupo', $toRend);
		$this->mifaces->addPosRendEval('$("#modal-nuevo-grupo").modal();'.$str);
		$this->mifaces->run();    	
    }    

    public function guardarGrupoAction()
    {
    	$modelGrupo = new Grupo();
    	
    	$modelGrupo->grpo_nombre = $_POST['nombre'];
    	$modelGrupo->grpo_descripcion = $_POST['descripcion'];
    	$modelGrupo->grpo_tipo_periodicidad = $_POST['tipoPeriodicidad'];
    	$modelGrupo->grpo_cantidad_periodicidad = $_POST['cantidadPeriodicidad'];
    	$modelGrupo->save();
    	$users = explode(',', $_POST['personas']);
    	$modelGrupo->grpo_id;
    	foreach ($users as $user_id) {
    		$modelUserGrupo = new UserGrupo();
    		$modelUserGrupo->user_id = $user_id;
    		$modelUserGrupo->grpo_id = $modelGrupo->grpo_id;
    		$modelUserGrupo->save();
    	}

    	$modelGrupo = new Grupo();
    	$dataView['grupos'] = $modelGrupo->getAll();

    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/configurar-grupos-lista',$dataView);
		$this->mifaces->addToRend('listaGrupos', $toRend);
    	$this->mifaces->addPosRendEval("$('#modal-nuevo-grupo').modal('toggle');
    									$.bootstrapGrowl('Grupo Creado Correctamente',{type:'success'});");
    	$this->mifaces->run();
    }

    public function editarGrupoAction()
    {
    	$modelGrupo = new Grupo();
    	
    	$modelGrupo->grpo_id = $_POST['id'];
    	$modelGrupo->grpo_nombre = $_POST['nombre'];
    	$modelGrupo->grpo_descripcion = $_POST['descripcion'];
    	$modelGrupo->grpo_tipo_periodicidad = $_POST['tipoPeriodicidad'];
    	$modelGrupo->grpo_cantidad_periodicidad = $_POST['cantidadPeriodicidad'];
    	$modelGrupo->update();
    	$users = explode(',', $_POST['personas']);
    	$modelGrupo->grpo_id;
    	foreach ($users as $user_id) {
    		$modelUserGrupo = new UserGrupo();
    		$modelUserGrupo->user_id = $user_id;
    		$modelUserGrupo->grpo_id = $modelGrupo->grpo_id;
    		$modelUserGrupo->update();
    	}

    	$modelGrupo = new Grupo();
    	$dataView['grupos'] = $modelGrupo->getAll();

    	$this->mifaces->newFaces();
		$toRend=$this->view->render('evaluacion/configurar-grupos-lista',$dataView);
		$this->mifaces->addToRend('listaGrupos', $toRend);
    	$this->mifaces->addPosRendEval("$('#modal-nuevo-grupo').modal('toggle');
    									$.bootstrapGrowl('Grupo Editado Correctamente',{type:'success'});");
    	$this->mifaces->run();
    }    
}