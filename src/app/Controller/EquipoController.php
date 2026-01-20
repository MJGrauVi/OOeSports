<?php
namespace App\Controller;

use App\Model\EquipoModel;

class EquipoController
{
    public function show($id)
    {
        $equipo = EquipoModel::getEquipoById($id);
        http_response_code(200);
        echo json_encode($equipo);
        var_dump($equipo);
        // return json_encode($equipo);
    }
}
