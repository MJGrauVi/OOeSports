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
            $conexion = new PDO(
                "mysql:host=localhost;dbname=examen",
                "alumno",
                "alumno",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $sql = "INSERT INTO torneos (nombre, fecha, premio_total)
                VALUES (:nombre, :fecha, :premio_total)";

            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':nombre' => $torneo->getNombre(),
                ':fecha' => $torneo->getFecha()->format('Y-m-d'),
                ':premio_total' => $torneo->getPremioTotal()
            ]);
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getTorneoById(string $id):?Torneo{

        try{
            $conexion = new PDO("mysql:host=mariadb;dbname=examen","alumno","alumno");
            $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch (\PDOException $error){
            echo $error->getMessage();
        }
        //Cadena de conexion;

        $sql="SELECT * FROM torneos WHERE id=:id";

        $stmt = $conexion->prepare($sql);

        $stmt->bindValue('id',$id);

        $stmt->execute();

        $resultado= $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado){
            return Torneo::createFromArray($resultado);
        }else{
            return null;
        }
    }
}
