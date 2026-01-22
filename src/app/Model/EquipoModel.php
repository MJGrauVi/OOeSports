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
            $stmt->bindValue('id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado ? Equipo::createFromArray($resultado) : null;
        } catch (\PDOException $e) {
            error_log("Error en conexion" . $e->getMessage());
            echo "Error en Conexión";
            return null;
        }
    }

    public static function saveEquipo(Equipo $equipo): bool
    {
        {

            try {
                $conexion = new PDO("mysql:host=mariadb;dbname=examen", "alumno", "alumno");
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $error) {
                echo $error;
                return false;
            }

            $sql = "INSERT INTO equipos values(:id,:nombre,:region,:win_rate)";
            $sentenciaPreparada = $conexion->prepare($sql);

            $sentenciaPreparada->bindValue('id', $equipo->getId());
            $sentenciaPreparada->bindValue('nombre', $equipo->getNombre());
            $sentenciaPreparada->bindValue('region', $equipo->getRegion());
            $sentenciaPreparada->bindValue('win_rate', $equipo->getWinRate());

            $sentenciaPreparada->execute();

            if ($sentenciaPreparada->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function deleteEquipoById($id): bool{

        try {
            $con = new PDO("mysql:host=mariadb;dbname=examen", "alumno", "alumno");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM equipos WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindValue('id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }catch (\PDOException $e){
            error_log("Error en conexion" . $e->getMessage());
            return false;
        }

    }
/*    function updateEquipo(Equipo $equipo): bool
    {
        try {
            $conexion = new PDO(
                "mysql:host=mariadb;dbname=examen",
                "alumno",
                "alumno",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $sql = "UPDATE equipos 
                SET nombre = :nombre,
                    region = :region,
                    win_rate = :win_rate
                WHERE id = :id";

            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':id' => $equipo->getId(),
                ':nombre' => $equipo->getNombre(),
                ':region' => $equipo->getRegion(),
                ':win_rate' => $equipo->getWinRate()
            ]);

            return true; // 👈 CLAVE

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }*/
    public static function updateEquipo(Equipo $equipo): bool{
        try{
            $conexion = new PDO("mysql:host=mariadb;dbname=examen", "alumno", "alumno");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE equipos SET id = :id, nombre = :nombre, region = :region, win_rate = :win_rate WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue('nombre', $equipo->getNombre());
            $stmt->bindValue('region', $equipo->getRegion());
            $stmt->bindValue('win_rate', $equipo->getWinRate());
            $stmt->bindValue('id', $equipo->getId());

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }catch (\PDOException $e){
            error_log("Error en conexion" . $e->getMessage());
            return false;

        }
    }

}
