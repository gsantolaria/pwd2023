<?php
declare(strict_types=1);
namespace Raiz\Models;

use DateTime;

class Prestamo extends ModelBase
{
    private $id;
     /** @var Socio */
    private Socio $socio;
     /** @var Libro */
    private Libro $libro;
    private $fecha_desde;
    private $fecha_hasta;
    private $fecha_dev;

    public function __construct(int $id, Socio $socio,  Libro $libro,string $fecha_desde,string $fecha_hasta, $fecha_dev=null) {
        parent::__construct($id);
        $this->socio = $socio;
        $this->libro = $libro;
        $this->fecha_desde =  date_create($fecha_desde);
        $this->fecha_hasta = date_create($fecha_hasta);
        $this->fecha_dev = $fecha_dev === null ? null : date_create($fecha_dev);
    }

    public function getSocio():Socio
    {
        return $this->socio;
    }

    public function setSocio(Socio $socio)
    {
        $this->socio = $socio;
    }
    
    public function getLibro():Libro
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

    public static function deserializar(array $datos): self
    {
        //var_dump($datos); 

        return new Prestamo(
            id: $datos['id'],
            socio: $datos['socio'],
            libro: $datos['libro'],
            fecha_desde: $datos["fecha_desde"],
            fecha_hasta: $datos["fecha_hasta"]
        );
    }
    /** @Return mixed[] */
    public function serializar(): array
    {
        $serializar = array(
            "id" => $this->getId(),
            "socio" => $this->getSocio()->serializar(),
            "libro" => $this->GetLibro()->serializar(),
            "fecha_desde" =>  date_format($this->GetFechaDesde(), "Y-m-d"),
            "fecha_hasta" => date_format($this->GetFechaHasta(), "Y-m-d"),
            "fecha_dev" => $this->GetFechaDev() === null ? null : date_format($this->GetFechaDev(), "Y-m-d")
        );
        return $serializar;
    }
}