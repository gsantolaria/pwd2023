<?php

declare(strict_types=1);
namespace Raiz\Models;

class Editorial extends ModelBase
{
    private $nombre;
    private $activo;

    public function __construct($id, $nombre)
    {
        parent::__construct($id);
        $this->nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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