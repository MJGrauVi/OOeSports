<?php

include_once "vendor/autoload.php";

session_start();

use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;
use App\Controller\TorneoController;
use App\Controller\JugadorController;
use App\Controller\EquipoController;


$router = new RouteCollector();


$router->get('/',function (){
    include_once "app/View/principal.php";
});

$router->get('/torneo', [TorneoController::class, 'show_login']);
$router->post('/registroTorneo', [TorneoController::class, 'store']);
$router->delete('/jugador/{id}',[JugadorController::class, 'destroy']);
//5.En el modelo de la clase Equipo se debe implementar método estatico getEquipoById($id)
//que buscará un la bbdd un equipo por su id.

$router->get('/equipo/{id}', [EquipoController::class, 'show']);
$router->post('/equipo', [EquipoController::class, 'store']);
$router->delete('/equipo/{id}',[EquipoController::class, 'destroy']);

$router->put('/equipo/{id}',[EquipoController::class, 'update']);


$router->post('/torneo/inscribir', [TorneoController::class, 'inscribir']);
$router->get('/torneo/{id}', [TorneoController::class, 'show']);

//Resolución de rutas
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}
catch(HttpRouteNotFoundException $e){
    return "Ruta no encontrada";
}
// Print out the value returned from the dispatched function
echo $response;
