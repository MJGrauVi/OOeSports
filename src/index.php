<?php

include_once "vendor/autoload.php";
include_once "env.php";
include_once "auxiliar/auxfunctions.php";

use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;
use App\Controller\UserController;
use App\Controller\DirectorController;

session_start();

$router = new RouteCollector();

$router->get('/',function (){
    include_once DIRECTORIO_VISTAS_FRONTEND."index.php";
});


$router->get('/login',function (){
    include_once DIRECTORIO_VISTAS_FRONTEND."login.php";
});

//Definición de rutas
//Rutas para la clase usuario
//Vistas de la aplicacion
$router->get('/user/create',[UserController::class,'create']);
$router->post('/user/login',[UserController::class,'verify']);
$router->get('/user/{id}/edit',[UserController::class,'edit']);


$router->get('/user',[UserController::class,'index']);
$router->get('/user/{id}',[UserController::class,'show']);
$router->post('/user',[UserController::class,'store']);
$router->put('/user/{id}',[UserController::class,'update']);
$router->delete('/user/{id}',[UserController::class,'destroy']);


$router->get('/api/user',[UserController::class,'index']);
$router->get('/api/user/{id}',[UserController::class,'show']);
$router->post('/api/user',[UserController::class,'store']);
$router->put('/api/user/{id}',[UserController::class,'update']);
$router->delete('/api/user/{id}',[UserController::class,'destroy']);


$router->get('/director',[DirectorController::class,'index']);
$router->get('/director/{id}',[DirectorController::class,'show']);
$router->post('/director',[DirectorController::class,'store']);
$router->put('/director/{id}',[DirectorController::class,'update']);
$router->delete('/director/{id}',[DirectorController::class,'destroy']);

$router->get('/create-director',[DirectorController::class,'create']);





































//Ejemplos de definición de rutas
/*$router->any('/', function(){

    return 'Página principal';
});

$router->get('/administracion',function(){
    include_once DIRECTORIO_VISTAS_ADMINISTRACION . "welcome.php";
});

$router->get('/admin-peliculas',function(){
    include_once DIRECTORIO_VISTAS_ADMINISTRACION . "usuarios.php";
});

$router->delete('/pelicula/{id:\d+}',function($id){
    echo "Se borraria la pelicula $id";
});


$router->get('/ejemplofuncion',function(){

    var_dump($_GET);
    if (isset($_GET['dni'])){
        $dniParametro = $_GET['dni'];
        echo $dniParametro;

        echo letraDNI($dniParametro);
    }else{
        echo "Parametro recibido de forma incorrecta";
    }
});

$router->get('/calcular-letra-dni',function(){

    $resultado = "";
    $dni=$_GET['dni'];
    $letra="";
    if (isset($_GET['dni'])){
        $resultado = "La letra correspondiente al DNI:" . $_GET['dni'] . " es: ";
        $resultado .= letraDNI($_GET['dni']);
        $letra=letraDNI($_GET['dni']);

    }else{
        $resultado = "No se ha podido calcular la letra del DNI. 
        Nombre de parámetro incorrecto";
    }
    include_once DIRECTORIO_VISTAS_ADMINISTRACION."letradni.php";

});

*/

//Resolución de rutas
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}
catch(HttpRouteNotFoundException $e){
    return include_once DIRECTORIO_VISTAS."404.html";
}
// Print out the value returned from the dispatched function
echo $response;
