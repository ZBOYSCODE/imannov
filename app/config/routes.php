<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->add('/login', array(
    'controller' => 'session',
    'action' => 'login'
));

$router->add('/', array(
    'controller' => 'evaluacion',
    'action' => 'index'
));

$router->add('/logout', array(
    'controller' => 'session',
    'action' => 'logout'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));

$router->add('/perfil', array(
	'controller' => 'evaluacion',
	'action' => 'perfil'
	));

$router->add('/evaluacion', array(
    'controller' => 'evaluacion',
    'action' => 'evaluacion'
    ));

$router->add('/grupos', array(
    'controller' => 'evaluacion',
    'action' => 'gruposEvaluacion'
    ));

$router->add('/grupos/configurar', array(
    'controller' => 'evaluacion',
    'action' => 'gruposConfigurar'
    ));

return $router;
