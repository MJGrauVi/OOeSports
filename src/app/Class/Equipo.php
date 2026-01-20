<?php

namespace App\Class;

class Equipo implements \JsonSerializable {
    private int $id;
    private string $nombre;
    private string $region;
    private float $win_rate;


    public function __construct(int $id, string $nombre, string $region, float $win_rate) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->region = $region;
        $this->win_rate = $win_rate;

    }
    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getRegion(): string { return $this->region; }
    public function getWinRate(): float { return $this->win_rate; }

    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setRegion(string $region): void { $this->region = $region; }
    public function setWinRate(float $win_rate): void { $this->win_rate = $win_rate; }



    public function jsonSerialize(): mixed
    {
        return [
            "id"=>$this->id,
            "nombre"=>$this->nombre,
            "region"=>$this->region,
            "win_rate"=>$this->win_rate
        ];
    }
    /*public static function createFromArray(array $equipoData):Equipo{

        if(!isset($equipoData['id'])) {

            $usuario = new Equipo(
                $equipoData['id'],
                $equipoData['nombre'],
                $equipoData['region'],
                $equipoData['win_rate']);

        }

        return $usuario;
    }*/
    //Equipo siguiendo el modelo de clase:
    public static function createFromArray(array $data): ?Equipo
    {
        // Validación mínima obligatoria
        if (empty($data["nombre"]) || empty($data["region"]) || !isset($data["win_rate"])) {
            return null;
        }

        // Normalizamos win_rate
        $winRate = (float) $data["win_rate"];

        // Si viene como porcentaje (0–100), lo pasamos a 0–1
        if ($winRate > 1) {
            $winRate = $winRate / 100;
        }

        // Control de rango
        if ($winRate < 0 || $winRate > 1) {
            $winRate = 0;
        }

        $equipo = new Equipo();

        // ID opcional (por ejemplo al reconstruir desde BD)
        if (!empty($data["id"])) {
            $equipo->id = (int) $data["id"];
        }
        $equipo->nombre = $data["nombre"];
        $equipo->region = $data["region"];
        $equipo->win_rate = $winRate;

        return $equipo;
    }
}