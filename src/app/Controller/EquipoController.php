<?php
namespace App\Controller;

use App\Model\EquipoModel;

class EquipoController
{
    public function show($id)
    {
        // Validación básica del ID
        if (!is_numeric($id) || $id <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "ID inválido"]);
            return;
        }
        $equipo = EquipoModel::getEquipoById($id);
        header('Content-type: application/json; charset=UTF-8');

        if($equipo == null){
            http_response_code(404);
            echo json_encode(["error"=> "Equipo no encontrado"]);
            return;
        }
        http_response_code(200);
        echo json_encode($equipo);


    }
    public function store()
    {
        //explicacion ia.
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre']) || empty($data['region'])) {
            http_response_code(400);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        $nuevoEquipo = EquipoModel::insertEquipo($data);

        http_response_code(201); // Created
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($nuevoEquipo);
    }

}
