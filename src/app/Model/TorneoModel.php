<?php

namespace App\Model;

use App\Class\Torneo;
use PDO;
use DateTime;
use PDOException;

class TorneoModel
/* $sql = "INSERT INTO torneos (nombre, fecha, premio_total) VALUES (:nombre, :fecha, :premio_total)";*/
{
    /*public static function saveTorneo(Torneo $torneo): bool
    {
        try {
            $conexion = new PDO("mysql:host=localhost;dbname=examen", "alumno", "alumno");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "INSERT INTO torneos (nombre, fecha, premio_total, equipos) VALUES (:nombre, STR_TO_DATE(:fecha, '%d/%c/%Y'), :premio_total, :equipos)";

            $stmt = $conexion->prepare($sql);

            $stmt->bindValue(":nombre", $torneo->getNombre());
            $stmt->bindValue(":fecha", $torneo->getFecha()->format('Y/m/d'));
            $stmt->bindValue(":premio_total", $torneo->getPremioTotal());
            $stmt->bindValue(":equipos", $torneo->convertirEquiposToJson());

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error in connection: " . $e->getMessage());
            return false;//Evita usar $conexion si definir.
        }
    }*/
    public static function saveTorneo(Torneo $torneo): bool
    {
        try {
            $conexion = new PDO("mysql:host=mariadb;dbname=examen", "alumno", "alumno");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO torneos (nombre, fecha, premio_total)
                VALUES (:nombre, :fecha, :premio_total)";

            $stmt = $conexion->prepare($sql);


            $stmt->bindValue('nombre', $torneo->getNombre());
            $stmt->bindValue('fecha', $torneo->getFecha()->format('Y-m-d'));
            $stmt->bindValue('premio_total', $torneo->getPremioTotal());

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
            /*      return $stmt->execute([
                ':nombre' => $torneo->getNombre(),
                ':fecha' => $torneo->getFecha()->format('Y-m-d'),
                ':premio_total' => $torneo->getPremioTotal()
            ]); */
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
            //die("ERROR SQL: " . $e->getMessage());
        }
    }
    public static function getTorneoById(int $id):?Torneo{
        //Conseguir el torneo de la bd.
        $conexion = new PDO("mysql:host=mariadb;dbname=examen",
        "alumno",
        "alumno");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "select * from torneos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? Torneo::createFromArray($resultado) : null;

    }
    public static function getTorneoByName(string $nombre):?Torneo{
        //Conseguir el torneo de la bd.
        $conexion = new PDO("mysql:host=mariadb;dbname=examen",
            "alumno",
            "alumno");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "select * from torneos WHERE nombre = :nombre";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue("nombre", $nombre, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? Torneo::createFromArray($resultado) : null;

    }
    public static function getTorneoByIdConEquipos(string $id): ?Torneo
    {

        try {
            $conexion = new PDO("mysql:host=mariadb;dbname=examen", "alumno", "alumno");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Cadena de conexion;

            $sql = "SELECT * FROM torneos WHERE id=:id";

            $stmt = $conexion->prepare($sql);

            $stmt->bindValue('id', $id);

            $stmt->execute();

            $torneoData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$torneoData) return null;

            // SELECT de los equipos de ese torneo (un solo SELECT)
            $sql2 = "SELECT * FROM equipos WHERE torneo_id = :id";

            $stmt2 = $conexion->prepare($sql2);
            $stmt2->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt2->execute();
            $equiposData = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            $equipos = [];
            foreach ($equiposData as $eq) {
                $equipo = Equipo::createFromArray($eq);
                if ($equipo) $equipos[] = $equipo;
            }

            return new Torneo(
                (int)$torneoData['id'],
                $torneoData['nombre'],
                $equipos
            );
        } catch (\PDOException $e) {
            error_log("Error en conexion: " . $e->getMessage());
            return null;
        }
    }

    public static function deleteTorneoById(int $id): bool //funciona correctamente
    {
        try {
            $conexion = new PDO("mysql:host=mariadb;dbname=examen", 'alumno', "alumno");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM torneos WHERE id=:id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // 👇 CLAVE DEL PROBLEMA
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error en conexion: " . $e->getMessage());
            return false;
        }
    }
}
