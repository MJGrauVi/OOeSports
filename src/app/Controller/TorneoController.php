<?php

namespace App\Controller;

use App\Class\Torneo;
use App\Class\Equipo;
use App\Model\TorneoModel;

class TorneoController
{

    public function store()
    {
        error_log("ENTRA EN store()");
        $torneo = Torneo::createFromArray($_POST);
        error_log(var_export($torneo, true));

        if ($torneo === null) {
            http_response_code(400);
            echo "Datos inválidos";
            return;
        }

        if (TorneoModel::saveTorneo($torneo)) {
            error_log(print_r($_POST, true));
            echo "Torneo guardado correctamente";
            http_response_code(201);
        } else {
            http_response_code(500);
            echo "Error al guardar el torneo";
        }
    }
    public function show_login()
    {
        include_once "app/View/formularioTorneo.php";
    }

    public function inscribir()
    { // Recoger datos enviados por POST (JSON o form-data)
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'])) {
            http_response_code(400);
            return json_encode(["error" => "Falta el nombre del equipo"]);
        }
        // Crear torneo y equipo
        $fecha = new \DateTime($data['fecha']);
        $torneo = new Torneo(
            $data['nombre_torneo'],
            $fecha,
            $data['premio_total']
        );
        $equipo = new Equipo(
            0,
            $data['nombre'],
            $data['region'],
            $data['win_rate'] ?? 0
        );
        // Inscribir equipo
        $torneo->inscribirEquipo($equipo);
        // Respuesta
        http_response_code(200);
        echo json_encode([
            "mensaje" => "Equipo inscrito correctamente",
            "equipos" => $torneo->getEquipos()
        ]);
    }
    public function show($id) {
        $torneo = TorneoModel::getTorneoById($id);

        header('Content-Type: application/json; charset=UTF-8');

        if ($torneo === null) {
            http_response_code(404);
            echo json_encode(["error" => "Torneo no encontrado"]);
            return;
        }

        http_response_code(200);
        echo json_encode($torneo);
    }
}
