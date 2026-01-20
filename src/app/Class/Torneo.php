<?php

namespace App\Class;
use DateTime;
use JsonSerializable;

class Torneo implements \JsonSerializable{
    private int $id;
    private string $nombre;
    private DateTime $fecha;
    private float $premio_total;
    private array $equipos;

    public function __construct(string $nombre, DateTime $fecha, float $premio_total)
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->premio_total = $premio_total;
        $this->equipos = [];
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

    public function setEquipos(array $equipos): Torneo
    {
        $this->equipos = $equipos;
        return $this;
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
        "fecha"=>$this->getFecha()->format('d/m/Y'),
        "premio_total"=>$this->premio_total
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
        $premio = isset($data['premio_tital']) ? (float)$data['premio_total'] : 0;

        return new Torneo ($data['nombre'],
            $fecha,
            $premio
        );
    }
    /*public static function createFromArray(array $data): ?Torneo
    {
        if (empty($data['nombre']) || empty($data['fecha'])) {
            return null;
        }

        $fecha = \DateTime::createFromFormat('d/m/Y', $data['fecha'])
            ?: \DateTime::createFromFormat('Y-m-d', $data['fecha']);

        if ($fecha === false) {
            return null;
        }

        $premio = isset($data['premios']) ? (float)$data['premios'] : 0;

        return new Torneo(
            $data['nombre'],
            $fecha,
            $premio
        );
    }*/
}
