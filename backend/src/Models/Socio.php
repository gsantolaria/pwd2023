<?php

declare(strict_types=1);
namespace Raiz\Models;


class Socio extends ModelBase{
    private $nombre_apellido;
    private $fecha_alta;
    private $activo;
    private $telefono;
    private $direccion;

    public function __construct(int $id, string $nombre_apellido, string $fecha_alta, int $telefono, string $direccion, int $activo = 1)
    {

        Parent::__construct($id);
        $this->nombre_apellido = $nombre_apellido;
        $this->fecha_alta = $fecha_alta;
        $this->activo = $activo;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }

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
    public function serializar(): array
    {   
        return [
            'id'=>$this->getId(),
            "nombre_apellido" => $this->getNombreApellido(), 
            "activo" => $this->getActivo(), 
            "fecha_alta" => $this->getFechaAlta(), 
            "telefono" => $this->getTelefono(), 
            "direccion" => $this->getDireccion()
        ];
    }
    static function deserializar(array $datos): ModelBase
    {

        return new self(
            id: $datos['id'] === null ? 0 : intVal($datos['id']),
            nombre_apellido: $datos['nombre_apellido'],
            fecha_alta: $datos['fecha_alta'],
            telefono: intval($datos['telefono']),
            direccion: $datos['direccion'],
            activo: intval($datos['activo'])
        );
    }
}