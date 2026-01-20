<?php

namespace App\Controller;
use App\Class\Torneo;
use App\Model\TorneoModel;

class TorneoController
{

/*    function store()
    {
        try{
        $torneo = Torneo::createFromArray($_POST);
        TorneoModel::saveTorneo($torneo);
        $torneo = TorneoModel::getTorneoById($torneo);
        //$torneo = TorneoModel::getTorneoById($torneo);
        http_response_code(200);
        return json_encode([
            "error"=>false,
            "message"=>"Tornedo creado.",
            "code"=>200,
            "data"=>$torneo
        ]);

        }catch(\Exception $error){
             http_response_code(500);
            return json_encode([
                "error"=> true,
                "message"=> "Error al guardar el torneo" . $error->getMessage(),
                "code"=>500,
                "data"=>$error
            ]);
        }

    }*/
    public function store()
    {
        $torneo = Torneo::createFromArray($_POST);

        if ($torneo === null) {
            http_response_code(400);
            return;
        }

        TorneoModel::saveTorneo($torneo);

        http_response_code(201);
    }
    public function show_login(){
        include_once "app/View/formularioTorneo.php";
    }

}