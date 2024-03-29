<?php

declare(strict_types=1);
namespace Raiz\Models;

class Categoria extends ModelBase
{
    private $descripcion;
    private $activo;

    public function __construct(int $id, string $descripcion)
    {
        parent::__construct($id);
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;
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
        return new categoria(
            id: $datos['id'],
            descripcion: $datos["descripcion"]
        );
    }
    /** @Return mixed[] */
    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'descripcion'=> $this->getDescripcion()
        ];
    }
}