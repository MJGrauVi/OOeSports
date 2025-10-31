<?php
//declare(strict_types=1);
namespace App\Model;

use App\Class\User;
use \PDO;

class UserModel
{

    public static function loadUserById(string $uuid):User{

        try {
            $conexion = new PDO('mysql:host=mariadb;dbname=proyecto', 'miguel', 'leugim');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $error){
            echo $error->getMessage();
        }

        //$sql = "SELECT * FROM user WHERE uuid=?";
        $sql = "SELECT * FROM user WHERE uuid=:uuid";

        $sentenciaPreparada=$conexion->prepare($sql);
        //$sentenciaPreparada->bindValue(1,$uuid);
        $sentenciaPreparada->bindValue('uuid',$uuid);

        $sentenciaPreparada->execute();
        $resultado=$sentenciaPreparada->fetch(PDO::FETCH_ASSOC);

        return User::createUserFromArray($resultado);

    }
    public static function loadUserByEmail(string $email):User{

        try {
            $conexion = new PDO('mysql:host=mariadb;dbname=proyecto', 'miguel', 'leugim');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $error){
            echo $error->getMessage();
        }

        //$sql = "SELECT * FROM user WHERE uuid=?";
        $sql = "SELECT * FROM user WHERE email=:email";

        $sentenciaPreparada=$conexion->prepare($sql);
        //$sentenciaPreparada->bindValue(1,$uuid);
        $sentenciaPreparada->bindValue('email',$email);

        $sentenciaPreparada->execute();
        $resultado=$sentenciaPreparada->fetch(PDO::FETCH_ASSOC);

        return User::createUserFromArray($resultado);

    }

    public static function saveUser(User $user):bool{

        try {
            $conexion = new PDO('mysql:host=mariadb;dbname=proyecto', 'miguel', 'leugim');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $error){
            echo $error->getMessage();
        }

        //$sql = "SELECT * FROM user WHERE uuid=?";
        $sql = "insert into user values(:uuid,:username,:password,:email,:type,STR_TO_DATE(:birthdate,'%Y-%c-%d'));";

        $sentenciaPreparada=$conexion->prepare($sql);
        $sentenciaPreparada->bindValue('uuid',$user->getUuid());
        $sentenciaPreparada->bindValue('username',$user->getUsername());
        $sentenciaPreparada->bindValue('password',$user->getPassword());
        $sentenciaPreparada->bindValue('email',$user->getEmail());
        $sentenciaPreparada->bindValue('type',$user->getType()->name);
        $sentenciaPreparada->bindValue('birthdate',$user->getBirthdate()->format('Y-m-d'));


        $sentenciaPreparada->execute();

        if ($sentenciaPreparada->rowCount()){
            return true;
        }else{
            return false;
        }

    }

}