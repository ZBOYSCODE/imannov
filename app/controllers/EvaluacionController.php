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

        $menu = 'menu/topMenu';
        $content = 'evaluacion/home';

        echo $this->view->render('theme',array('topMenu'=>$menu,'menuSel'=>'home','pcView'=>$content,'pcData'=>''));
    }

    public function evaluacionAction()
    {   
         $jsScript = "
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
        );      ";
        echo $this->view->render('theme', array('lmView'=>'menu/leftMenu', 'menuSel'=>'evaluarSol','pcView'=>'solicitudes/evaluarSolicitud', 'pcData'=>'', 'jsScript'=>$jsScript));    
        echo $this->view->render('theme', array('lmView'=>'menu/leftMenu', 'menuSel'=>'consultarSol','pcView'=>'solicitudes/consultaSolicitud', 'pcData'=>''));    
    	//echo $this->view->render('themeLudicoM2', array('lmView'=>'menu/leftMenu', 'menuSel'=>'consultarSol','pcView'=>'solicitudes/consultaSolicitud', 'pcData'=>''));    
    }

}