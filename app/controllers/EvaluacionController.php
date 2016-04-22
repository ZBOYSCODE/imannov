<?php

namespace Gabs\Controllers;
use Gabs\Models\Grupo;
use Gabs\Models\Habilidad;
use Gabs\Models\Users;
use Gabs\Models\HabilidadUserEvaluacion;
use Gabs\Models\UserHabilidad;
use \Gabs\Services\Services as Services;

class evaluacionController extends ControllerBase
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {   

        $this->perfilAction();
    }

    public function evaluacionAction()
    {   

        $modelHabilidad = new Habilidad();
        $habilidades = $modelHabilidad->getAll();

        $encuesta = array();

        foreach ($habilidades as $keyHab => $hab) {
            array_push($encuesta, array('nombre'=>$hab->hbld_nombre,'id'=>$hab->hbld_id,'pregunta' => array('pregunta1', 'pregunta2')));
        }

        $pcData['encuesta'] = $encuesta;

        $jsScript = "

            $('#cerrarModal').click(
                function(){
                    $('#barra-progreso').css('width','10%'); 
                    $('#barra-progreso').removeClass('progress-bar-success');
                    $('#barra-progreso').addClass('progress-bar-danger');
                    $('#stp-trat-pregunta1 .stp-trat-btn').addClass('active');
                    $('#stp-trat-pregunta1').css('display','block'); 
                    $('#stp-trat-resultado').css('display','none'); 
                }
            );


            $('.stp-trat-btn-menu').click(
                function(){

                    if($(this).data('next') == 'pregunta1')
                    {
                        $('#barra-progreso').css('width','10%');    
                        $('#barra-progreso').removeClass('progress-bar-warning');
                        $('#barra-progreso').addClass('progress-bar-danger');
                    }

                    if($(this).data('next') == 'pregunta2')
                    {
                        $('#barra-progreso').css('width','33%');    
                        $('#barra-progreso').removeClass('progress-bar-warning');
                        $('#barra-progreso').addClass('progress-bar-danger');
                    }               

                    $('.stp-trat').css('display','none');
                    $('#stp-trat-'+$(this).data('next')).css('display','block');
                }
            );   

            $(function() {
                $('#search').on('keyup', function() {
                    var pattern = $(this).val();
                    $('.searchable-container .items').hide();
                    $('.searchable-container .items').filter(function() {
                        return $(this).text().match(new RegExp(pattern, 'i'));
                    }).show();
                });
            });  

            $('.bizmoduleselect').click(function(){
                if($(this).children().hasClass('active'))
                    var count = -1;
                else
                    var count = 1;

                if($('.bizmoduleselect>label.active').length + count > 0)
                    $('#btnResponder').removeAttr('disabled');
                else
                    $('#btnResponder').attr('disabled','disabled');
                

                if($('.bizmoduleselect>label.active').length + count == 3){
                    $(this).children().addClass('active');
                    $('label').not('.active').parent().css('pointer-events','none');
                    $('.bizmoduleselect>label').not('.active').attr('disabled','disabled');

                    $(this).children().removeClass('active');
                    $.bootstrapGrowl('Sólo puede seleccionar 3 habilidades.',{type:'info'});
                } else{
                    $('.bizmoduleselect>label').not('.active').removeAttr('disabled');
                    $('label').not('.active').parent().css('pointer-events','auto');
                }
            });

            $('#btnResponder').click(function(){
                var arr = $('.bizmoduleselect>label.active').find('input').map(function(){return $(this).val();}).get();
                $('#btnResponder').data('val','ids='+arr);
            });

            $(\".chat-user-online\").click(function(){
                $(\".chat-user-online\").removeClass('after-focus');
                var data = $(this).data('value');
                $(this).toggleClass('after-focus');
                $('#evaluado').html($(this).data('name'));
                $('#imagenEvaluado').attr('src','/imannova/img/avatars/avatar'+data+'.jpg');
            });            

            
        ";

        $menu = 'menu/topMenu';
        $content = 'evaluacion/evaluacion';

        echo $this->view->render('theme', array('topMenu'=>$menu, 'menuSel'=>'evaluar','pcView'=>$content, 'pcData'=>$pcData, 'jsScript'=>$jsScript));    
    }

    public function perfilAction() {

        $user_id = $this->auth->getIdentity()['id'];

        //Ejemplos de llamadas a Service (Capa de negocio)
        $pcData['grupo'] = Services::getService('Grupo')->getGruposByUser($user_id)->getFirst();
        $pcData['user'] = Services::getService('Users')->getUserById($user_id);

        $pcData['totalreconocimientos'] = Services::getService('Users')->getCantidadReconocimientosByUser($user_id);

        $pcData['totalhabilidadesreconocidas'] = Services::getService('Users')->getCantidadHabilidadesByUser($user_id);


        $menu = 'menu/topMenu';
        $content = 'evaluacion/perfil';
        $jsScript = 
        "
           $(document).ready(function() {
             
                $('#responsive').find('a').click(function(e) {
                    e.preventDefault();
                    $(this).siblings('a.active').removeClass(\"active\");
                    $(this).addClass(\"active\");
                    $(\"div.user-menu>div.user-menu-content\").removeClass(\"active\");
                    $(\"div.user-menu>div.user-menu-content\").eq($(this).index()).addClass(\"active\");
                });
            });

            $( document ).ready(function() {
                $(\"[rel='tooltip']\").tooltip();    
             
                $('.view').hover(
                    function(){
                        $(this).find('.caption').slideDown(250); //.fadeIn(250)
                    },
                    function(){
                        $(this).find('.caption').slideUp(250); //.fadeOut(205)
                    }
                ); 
            });


            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                  
              var data = google.visualization.arrayToDataTable([
                ['Habilidad', 'Porcentaje',],
                ['Liderazgo', 60],
                ['Responsbilidad', 73],
                ['Honestidad', 78],
                ['Trabajo en equipo', 80],
                ['Tolerancia al cambio', 68]
              ]);

              var options = {
                backgroundColor: { fill:'transparent' },
                height: 400,
                colors: ['#1ec1b8'],
                title: '',
                chartArea: {width: '50%'},
                hAxis: {
                  minValue: 0
                },
                vAxis: {
                }
              };


            var data2 = google.visualization.arrayToDataTable([
              ['Ago', 'Compensación'],
              ['Sep',  20],
              ['Oct',  200],
              ['Nov',  1000],
              ['Dic',  750],
              ['Ene',  759],
              ['Feb',  800],
              ['Mar',  478],
            ]);

            var options2 = {                
                backgroundColor: { fill:'transparent' },
                height: 400,
                colors: ['#1ec1b8'],
                title: '',
                chartArea: {width: '50%'},
              hAxis: {title: 'Mes',  titleTextStyle: {color: '#333'}},
              vAxis: {minValue: 0}
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);

            var chart2 = new google.visualization.AreaChart(document.getElementById('chart_div2'));
            chart2.draw(data2, options2);
          }
        ";

        echo $this->view->render('theme',array('topMenu'=>$menu,'menuSel'=>'perfil','pcView'=>$content,'pcData'=>$pcData, 'jsScript' => $jsScript));
    }

    public function gruposEvaluacionAction() {
/*
        $modelGrupo = new Grupo();

        $pcData['grupos'] = $modelGrupo->getAll();*/

        $pcData['grupos'] = Services::getService('Grupo')->getGrupoByGrupo($id);
        

        $menu = 'menu/topMenu';
        $content = 'evaluacion/configurar-grupos-evaluacion';

        $jsScript = 
        "
                $(\".chat-user-online\").click(function(){
                    var data = $(this).data('value');
                    $(this).toggleClass('after-focus');
                    $(\"#check-users\"+data).toggleClass('hidden');
                });
        ";
        
        echo $this->view->render('theme',array('topMenu'=>$menu,'menuSel'=>'configurar','pcView'=>$content,'pcData'=>$pcData, 'jsScript' => $jsScript));
    }

    public function gruposConfigurarAction() {


        $menu = 'menu/topMenu';
        $content = 'evaluacion/configurar-grupos-evaluacion-detalle';
      
        $jsScript = 
        "
                $(\".chat-user-online\").click(function(){
                    var data = $(this).data('value');
                    $(this).toggleClass('after-focus');
                    $(\"#check-users\"+data).toggleClass('hidden');
                });
        ";
        
        echo $this->view->render('theme',array('topMenu'=>$menu,'menuSel'=>'configurar','pcView'=>$content,'pcData'=>'', 'jsScript' => $jsScript));

     }


}