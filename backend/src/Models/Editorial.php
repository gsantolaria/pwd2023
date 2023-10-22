<?php

declare(strict_types=1);
namespace Raiz\Models;

class Editorial extends ModelBase
{
    private $nombre;
    private $activo;

    public function __construct(int $id, string $nombre)
    {
        parent::__construct($id);
        $this->nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
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
        $id = isset($datos['id']) ? (int) $datos['id'] : 0;
        $nombre = isset($datos['nombre']) ? $datos['nombre'] : '';

        return new Editorial(
            // id: $datos['id'] === null ? 0 : intVal($datos['id']),
            // nombre: $datos["nombre"]
            id: $id,
            nombre: $nombre
        );
    }
    /** @Return mixed[] */
    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'nombre'=> $this->getNombre()
        ];
    }
}