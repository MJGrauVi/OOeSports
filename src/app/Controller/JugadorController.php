<?php
namespace App\Controller;

use App\Model\JugadorModel;
class JugadorController{

    public function destroy($id){

        if(JugadorModel::deleteJugadorById($id)){
            //El jugador se ha borrado correctamente.
            http_response_code(200);
            return json_encode([
                "error"=>false,
                "message"=>"El jugador con $id se ha borrado correctamente",
                "code"=>200
            ]);
        }else{
            //Ha habido algún problema con la base de datos al borrar el Jugador.
            http_response_code(404);
            return json_encode([
                "error"=>true,
                "message"=>"No existe el jugador.",
                "code"=>404
            ]);
        }
    }
}