<?php

declare(strict_types=1);
namespace Raiz\Models;


class Socio extends ModelBase{
    private $nombre_apellido;
    private $fecha_alta;
    private $activo;
    private $telefono;
    private $direccion;

    public function getNombreApellido()
    {
        return $this->nombre_apellido;
    }

    public function setNombreApellido($nombre_apellido)
    {
        $this->nombre_apellido = $nombre_apellido;
    }

    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }

    public function setFechaAlta($fecha_alta)
    {
        $this->fecha_alta = $fecha_alta;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
 
}