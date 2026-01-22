<?php

namespace App\Class;

use App\Model\EquipoModel;

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

    //Equipo siguiendo el modelo de clase:
    public static function createFromArray(array $data): ?Equipo
    {
        // Validación mínima obligatoria
     /*   if (empty($data["nombre"]) || empty($data["region"]) || !isset($data["win_rate"])) {
            return null;
        }*/

        // Normalizamos win_rate
        /*$winRate = (float) $data["win_rate"];*/

        // Si viene como porcentaje (0–100), lo pasamos a 0–1
 /*       if ($winRate > 1) {
            $winRate = $winRate / 100;
        }*/

        // Control de rango
     /*   if ($winRate < 0 || $winRate > 1) {
            $winRate = 0;
        }*/

        return new Equipo(
            (int) ($data["id"] ?? 0),
            $data["nombre"],
            $data["region"],
            $data["win_rate"]
        );
    }
    public static function editFromArray(Equipo $equiAntiguo,array $EquipoData):?Equipo{
        $equiAntiguo=EquipoModel::getEquipoById($EquipoData['id']);

        //$equiAntiguo->setId($EquipoData['id']??$equiAntiguo->getId());
        $equiAntiguo->setNombre($EquipoData['nombre']??$equiAntiguo->getNombre());
        $equiAntiguo->setRegion($EquipoData['region']??$equiAntiguo->getRegion());
        $equiAntiguo->setWinRate($EquipoData['win_rate']??$equiAntiguo->getWinRate());

        return $equiAntiguo;



    }
}