<?php

namespace App\Model;

use App\Class\Equipo;
use PDO;

class EquipoModel
{

    //Punto 5 examen.
    public static function getEquipoById($id): ?Equipo
    {
        try {
            $con = new Pdo("mysql:host=mariadb;dbname=examen", 'alumno', 'alumno');
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM equipos WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ? Equipo::createFromArray($resultado) : null;
        } catch (\PDOException $e) {
            error_log("Error en conexion" . $e->getMessage());
            echo "Error en Conexión";
            return null;
        }
    }

}
