<?php
namespace App\Controller;

use App\Model\EquipoModel;
use App\Class\Equipo;

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

        if ($equipo == null) {
            http_response_code(404);
            return json_encode([
                "error" => true,
                "message" => "El equipo con id $id no existe",
                "code" => 404
            ]);
        }
        http_response_code(200);
        echo json_encode($equipo);


    }

    public function update($id)
    {
        //Leo del fichero input los datos que me han llegado en la petición PUT
        $editData = json_decode(file_get_contents("php://input"), true);
        if ($editData === null) {
            http_response_code(400);
            return json_encode(["error" => true, "message" => "JSON inválido"]);
        }

        //Añado el id a los datos que me han llegado en la petición PUT
       // $editData['id'] = $id;

        $equipoAnt = EquipoModel::getEquipoById($id);

        if ($equipoAnt === null) {
            http_response_code(404);
            return json_encode([
                "error" => true,
                "message" => "Equipo no encontrado",
                "code" => 404
            ]);
        }

        $equiNuevo = Equipo::editFromArray($equipoAnt, $editData);

        if (EquipoModel::updateEquipo($equiNuevo)) {
            http_response_code(200);
            return json_encode([
                "error" => false,
                "message" => "Equipo actualizado correctamente",
                "code" => 200
            ]);
        }
        http_response_code(500);
        return json_encode([
            "error" => true,
            "message" => "Error al actualizar el equipo",
            "code" => 500
        ]);
    }



    /*public function store()
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
    }*/

    public function store(){
        $equipo = Equipo::createFromArray($_POST);
        EquipoModel::saveEquipo($equipo);
        return json_encode($equipo);
    }
    public function destroy($id){
        if(EquipoModel::deleteEquipoById($id)){
            http_response_code(200);
            return json_encode(["error"=>false,
                "mensaje"=> "Equipo eliminado",
                "code"=>200]);
        }else{
            http_response_code(401);
            return json_encode(["error"=>true,
                "mensaje"=> "El equipo con $id no se ha podido borrar",
                "code"=>401]);
        }
    }

}
