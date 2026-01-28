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
$router->get('/torneo/{id}', [TorneoController::class,'show']);
$router->delete('/torneo/{id}',[TorneoController::class,'destroy']);
//Probar crear torneo si el formulario.
$router->get('/crear-torneo-demo', [TorneoController::class, 'crearDemo']);
$router->delete('/jugador/{id}',[JugadorController::class, 'destroy']);
//5.En el modelo de la clase Equipo se debe implementar método estatico getEquipoById($id)
//que buscará un la bbdd un equipo por su id.

$router->get('/equipo/{id}', [EquipoController::class, 'show']);
$router->post('/equipo', [EquipoController::class, 'store']);
$router->delete('/equipo/{id}',[EquipoController::class, 'destroy']);

$router->put('/equipo/{id}',[EquipoController::class, 'update']);

/*$router->post('/torneo/inscribir', [TorneoController::class, 'inscribir']);
$router->post('/torneo/', [TorneoController::class, 'participar']);

$router->get('/torneo/{id}', [TorneoController::class, 'show']);
*/
//$router->get('/torneo/{id}/test', [TorneoController::class, 'testDificultad']);

//Pruebas tita.
use App\Class\Torneo;
use App\Class\Equipo;
$torneoNuevo = new Torneo( 'NuevoTorneo', new DateTime('2026-01-01'), 1000);

/*$torneo->inscribirEquipo(new Equipo(1, 'T1', 'Korea', 75.5));
$torneo->inscribirEquipo(new Equipo(2, 'G2', 'Europe', 68.2));
$torneo->inscribirEquipo(new Equipo(3, 'Fnatic', 'Europe', 60.0));*/
$equipo1 = new Equipo(1, 'Fnatic', 'Korea', 75.5);
$equipo2 = new Equipo(2, 'Natic', 'Korea', 75.50);
$torneoNuevo->inscribirEquipo($equipo1);
$torneoNuevo->inscribirEquipo($equipo2);

echo "Dificultad media: ";
echo $torneoNuevo->calcularDificultadMedia();


//Resultado correcto Pruebas tita 67.9

/*use App\Class\Torneo;

// Datos simulados
$data = [
    'nombre' => 'Torneo Nacional',
    'fecha' => '2024-10-15',
    'premio_total' => '2550'
];

// Crear objeto Torneo
$torneo = Torneo::createFromArray($data);
// Probar resultado
var_dump($torneo);
die;

*/


/*use App\Model;
$torneo = TorneoModel::getTorneoById(1);
var_dump($torneo);
die;

echo "Nombre torneo: ".$torneo->getNombre();
if($torneo){
    echo "Dificultad media:" . $torneo->calcularDificultadMedia();
}else{
    echo "No existe el torneo";
}*/


// PRUEBAS para ir testeando

//$equipo = EquipoModel::getEquipoById(1);
//var_dump($equipo);
//
//JugadorModel::deleteJugadorById(1);

/*$torneo = new Torneo('Torneo', new DateTime('2000-10-10'), 1000);
$torneo->inscribirEquipo(5, 'lele', 'lolo', 456);
$torneo->inscribirEquipo(9, 'lele', 'lolo', 100);

var_dump($torneo);
echo 'Dificultad media:';
$valor = $torneo->calcularDificultadMedia();
echo $valor;*/



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
