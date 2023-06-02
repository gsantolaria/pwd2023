<?php

declare(strict_types=1);
namespace Raiz\Models;

class Autor extends ModelBase
{
    private $nombre_apellido;
    private $activo;

    public function __construct($id, $nombre_apellido)
    {
        parent::__construct($id);
        $this->nombre_apellido = $nombre_apellido;
    }

    public function getNombreApellido()
    {
        return $this->nombre_apellido;
    }

    public function setNombreApellido($nombre_apellido)
    {
        $this->nombre_apellido = $nombre_apellido;
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