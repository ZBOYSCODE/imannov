<?php
namespace Gabs\Controllers;
use Gabs\Models\Personas;
 
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

        $encuesta = array(
            array('nombre'=>'Aprendizaje', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Autocrítica', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Calidad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Calidez', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Comunicación', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Consecuencia', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Perseverancia y Disciplina', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Eficiencia', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Honestidad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Justicia', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Libertad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Originalidad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Pro-actividad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Puntualidad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Responsabilidad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Seguridad', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Tolerancia al cambio', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Trabajo en Equipo', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Superación', 'pregunta' => array('pregunta1', 'pregunta2')),
            array('nombre'=>'Liderazgo' , 'pregunta' => array('pregunta1', 'pregunta2'))
            );

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

                $('.stp-trat-btn').click(
                    function(){

                        $('#stp-trat-'+$(this).data('stp')+' .stp-trat-btn').removeClass('active');
                        $(this).addClass('active');

                        $('.stp-trat').css('display','none');
                        
                        $('#stp-trat-'+$(this).data('next')).css('display','block');                
                        
                        if($(this).data('type')=='pregunta1'){
                            $('#barra-progreso').css('width','33%');
                        }

                        if($(this).data('type')=='pregunta2'){
                            $('#barra-progreso').css('width','66%');
                            $('#barra-progreso').removeClass('progress-bar-danger');
                            $('#barra-progreso').addClass('progress-bar-warning');
                        }

                        if($(this).data('type')=='pregunta3'){
                            $('#barra-progreso').css('width','100%');
                            $('#barra-progreso').removeClass('progress-bar-warning');
                            $('#barra-progreso').addClass('progress-bar-success');
                        }
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
         ";

        $menu = 'menu/topMenu';
        $content = 'evaluacion/evaluacion';

        echo $this->view->render('theme', array('topMenu'=>$menu, 'menuSel'=>'evaluar','pcView'=>$content, 'pcData'=>$encuesta, 'jsScript'=>$jsScript));    
    }

    public function perfilAction() {
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


        echo $this->view->render('theme',array('topMenu'=>$menu,'menuSel'=>'perfil','pcView'=>$content,'pcData'=>'', 'jsScript' => $jsScript));
    }

    public function gruposEvaluacionAction() {
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
        
        echo $this->view->render('theme',array('topMenu'=>$menu,'menuSel'=>'configurar','pcView'=>$content,'pcData'=>'', 'jsScript' => $jsScript));
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