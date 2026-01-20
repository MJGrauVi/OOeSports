<?php

namespace APP\Model;

use PDO;

class JugadorModel
{
    //La clase Jugador tendrá un método DeleteJugador($id) en el modelo que se ejecutará
    // cuando realicemos com Postman una peticion del tipo DELETE a la ruta /jugador/{id}


    public static function deleteJugadorById(int $id): bool
    {
        //Establecemos conexion y capturamos posibles errores.
        try {
            $con = new PDO("mysql:host=mariadb;dbname=examen", 'alumno', 'alumno');
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            return false;
        }
        //Creamos sentencia sql para la eliminacion en BD.
        $sql = "DELETE FROM jugadores WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue('id', $id);

        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
