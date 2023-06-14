<?php

declare(strict_types=1);
namespace Raiz\Models;

class Genero extends ModelBase
{
    private $descripcion;
    private $activo;

    public function __construct($id, $descripcion)
    {
        parent::__construct($id);
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}