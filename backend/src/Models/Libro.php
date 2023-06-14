<?php

declare(strict_types=1);
namespace Raiz\Models;

class Libro extends ModelBase
{
    private $titulo;
    private $editorial;
    private $autor;
    private $genero;
    private $cant_paginas;
    private $anio_publicacion;
    private $estado;

    const ACTIVO = "Activo";
    const INACTIVO = "Inactivo";
    const PRESTADO = "Prestado";

    public function __construct($id, $titulo, $editorial, $autor, $genero, $cant_paginas, $anio_publicacion, $estado) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->editorial = $editorial;
        $this->autor = $autor;
        $this->genero = $genero;
        $this->cant_paginas = $cant_paginas;
        $this->anio_publicacion = $anio_publicacion;
        $this->estado = $estado;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getEditorial()
    {
        return $this->editorial;
    }

    public function setEditorial(Editorial $editorial)
    {
        $this->editorial = $editorial;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor(array $autor)
    {
        $this->autor = $autor;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero(Genero $genero)
    {
        $this->genero = $genero;
    }

    public function getCantPaginas()
    {
        return $this->cant_paginas;
    }

    public function setCantPaginas($cant_paginas)
    {
        $this->cant_paginas = $cant_paginas;
    }

    public function getAnioPublicacion()
    {
        return $this->anio_publicacion;
    }

    public function setAnioPublicacion($anio_publicacion)
    {
        $this->anio_publicacion = $anio_publicacion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}