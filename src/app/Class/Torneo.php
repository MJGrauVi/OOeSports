<?php

namespace App\Class;
use DateTime;
use JsonSerializable;

class Torneo implements \JsonSerializable{
    private int $id;
    private string $nombre;
    private DateTime $fecha;
    private float $premio_total;
    private array $equipos =[];

    public function __construct(string $nombre, DateTime $fecha, float $premio_total)
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->premio_total = $premio_total;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): Torneo
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $fecha): Torneo
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getEquipos(): array
    {
        return $this->equipos;
    }

    public function setId(int $id): Torneo
    {
        $this->id = $id;
        return $this;
    }

    public function setEquipos(array $equipos): void
    {
        $this->equipos = $equipos;

    }



    public function getPremioTotal(): float
    {
        return $this->premio_total;
    }

    public function setPremioTotal(float $premio_total): Torneo
    {
        $this->premio_total = $premio_total;
        return $this;
    }
    public function convertirEquiposToJson(): string{
        return json_encode($this->equipos);
    }
    //Lógica de negocio.
    //La clase Torneo tiene un método inscribirEquipo($equipo) que permite añadir objetos de tipo Equipo
    // al array de empresas internas del torneo.
    public function inscribirEquipo(Equipo $equipo): void
    {
        $this->equipos[] = $equipo;
    }

    //calcularDificultadMedia que tendra que calcular la media "win_rate" a partir
    // de los datos de los equipos asociados a ese torneo.
    public function calcularDificultadMedia(): float
    {
        if (count($this->equipos) === 0) {
            return 0;
        }

        $suma = 0;
        foreach ($this->equipos as $equipo) {
            $suma += $equipo->getWinRate();
        }

        return $suma / count($this->equipos);
    }

function jsonSerialize(): mixed
{
    return [
        "nombre"=>$this->nombre,
        "fecha"=>$this->fecha->format('Y/m/d'),
        "premio_total"=>$this->premio_total,
        "equipos"=>array_map(fn($equipo)=>$equipo->jsonSerialize(), $this->equipos)
    ];
}
    public static function createFromArray(array $data): ?Torneo
    {
        if (empty($data['nombre']) || empty($data['fecha'])) {
            return null;
        }
        // Formato BD
        $fecha = DateTime::createFromFormat('Y-m-d', $data['fecha']);

        // Formato formulario
        if ($fecha === false) {
            $fecha = DateTime::createFromFormat('d/m/Y', $data['fecha']);
        }
        if ($fecha === false) {
            return null;
        }
        $premio = isset($data['premio_total']) ? (float)$data['premio_total'] : 0;

        return new Torneo ($data['nombre'],
            $fecha,
            $premio
        );
    }

}
