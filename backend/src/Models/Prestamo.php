<?php

declare(strict_types=1);
namespace Raiz\Models;
use DateTime;

class Prestamo extends ModelBase
{
    private $socio;
    private $libro;
    private $fecha_desde;
    private $fecha_hasta;
    private $fecha_dev;

    public function __construct($id, $socio, $libro, $fecha_desde, $fecha_hasta, $fecha_dev) {
        $this->id = $id;
        $this->socio = $socio;
        $this->libro = $libro;
        $this->fecha_desde = $fecha_desde;
        $this->fecha_hasta = $fecha_hasta;
        $this->fecha_dev = $fecha_dev;
    }

    public function getSocio()
    {
        return $this->socio;
    }

    public function setSocio(Socio $socio)
    {
        $this->socio = $socio;
    }

    public function getLibro()
    {
        return $this->libro;
    }

    public function setLibro(Libro $libro)
    {
        $this->libro = $libro;
    }

    public function getFechaDesde()
    {
        return $this->fecha_desde;
    }

    public function setFechaDesde($fecha_desde)
    {
        $this->fecha_desde = $fecha_desde;
    }

    public function getFechaHasta()
    {
        return $this->fecha_hasta;
    }

    public function setFechaHasta($fecha_hasta)
    {
        $this->fecha_hasta = $fecha_hasta;
    }

    public function getFechaDev()
    {
        return $this->fecha_dev;
    }

    public function setFechaDev($fecha_dev)
    {
        $this->fecha_dev = $fecha_dev;
    }

    public function diasRetraso()
    {
        $fecha_actual = new DateTime();
        $fecha_dev = $this->getFechaHasta();

        if ($fecha_dev === null || $fecha_actual <= $fecha_dev) {
            return 0;
        }
        $diferencia = $fecha_actual->diff($fecha_dev);
        return $diferencia->days;
    }
}