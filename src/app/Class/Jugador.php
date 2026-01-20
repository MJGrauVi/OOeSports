<?php

namespace App\Class;

class Jugador implements \JsonSerializable
{
private int $id;
private string $nombre;
private string $email;
private string $nickname;
private int $nivel;
private array $equipos_favoritos=[];

public function __construct(int $id, string $nombre, string $email, string $nickname, int $nivel)
{
    $this->id = $id;
    $this->nombre = $nombre;
    $this->email = $email;
    $this->nickname = $nickname;
    $this->nivel = $nivel;
}

public function getEmail(): string
{
    return $this->email;
}
public function setEmail(string $email): Jugador
{
    $this->email = $email;
    return $this;
}

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): Jugador
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): Jugador
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getNivel(): int
    {
        return $this->nivel;
    }

    public function setNivel(int $nivel): Jugador
    {
        $this->nivel = $nivel;
        return $this;
    }
    function jsonSerialize(): mixed
    {
        return [
            "id"=>$this->id,
            "nombre"=>$this->nombre,
            "email"=>$this->email,
            "nickname"=>$this->nickname,
            "nivel"=>$this->nivel
        ];
    }


}