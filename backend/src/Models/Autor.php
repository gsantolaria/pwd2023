<?php

declare(strict_types=1);
namespace Raiz\Models;

class Autor extends ModelBase
{
    private $nombre_apellido;
    private $activo;

    public function __construct(int $id, string $nombre_apellido)
    {
        parent::__construct($id);
        $this->nombre_apellido = $nombre_apellido;
    }

    public function getNombreApellido()
    {
        return $this->nombre_apellido;
    }

    public function setNombreApellido(string $nombre_apellido)
    {
        $this->nombre_apellido = $nombre_apellido;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo(int $activo)
    {
        $this->activo = $activo;
    }

    public static function deserializar(array $datos): self
    {
        return new autor(
            id: $datos['id'] === null ? 0 : intVal($datos['id']),
            nombre_apellido: $datos['nombre_apellido']
        );
    }
    /** @Return mixed[] */
    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'nombre_apellido'=> $this->getNombreApellido()
        ];
    }
}