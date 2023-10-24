<?php

namespace Raiz\Models;

use Error;

class Libro extends ModelBase
{
    private $titulo;
    /** @var Editorial */
    private $editoriales;
    /** @var array<Autor> */
    private array $autores;
    /** @var Genero */
    private $generos;
    /** @var Categoria */
    private $categorias;
    private int $cant_paginas;
    private int $anio;
    private string $estado;

    const ACTIVO = 'Activo';
    const INACTIVO = 'Inactivo';
    const PRESTADO = 'Prestado';

    public function __construct(
        $id,
        string $titulo,
        array $autores,
        Editorial $editoriales,
        int $cant_paginas,
        int $anio,
        Genero $generos,
        Categoria $categorias,
        string $estado = self::ACTIVO

    ) {
        parent::__construct($id);
        $this->titulo = $titulo;
        $this->editoriales = $editoriales;
        $this->autores = $autores;
        $this->generos = $generos;
        $this->cant_paginas = $cant_paginas;
        $this->anio = $anio;
        $this->categorias = $categorias;
        $this->estado = $estado;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }
    public function getGenero(): Genero
    {
        return $this->generos;
    }
    public function getEditorial(): Editorial
    {
        return $this->editoriales;
    }
    public function getCategoria(): Categoria
    {
        return $this->categorias;
    }
    public function getCant_Pag(): int
    {
        return $this->cant_paginas;
    }
    public function getAnio_Pub(): int
    {
        return $this->anio;
    }
    public function getAutores(): array
    {
        return $this->autores;
    }
    public function getEstado(): string
    {
        return $this->estado;
    }
    //---- Setters ----//
    public function setTitulo(string $nuevoTitulo)
    {
        $this->titulo = $nuevoTitulo;
    }

    public function setAutores(array $nuevosAutores)
    {
        $this->autores = $nuevosAutores;
    }

    public function setCategoria(Categoria $nuevaCategoria)
    {
        $this->categorias = $nuevaCategoria;
    }

    public function setGenero(Genero $nuevoGenero)
    {
        $this->generos = $nuevoGenero;
    }

    public function setEditorial(Editorial $nuevaEditorial)
    {
        $this->editoriales = $nuevaEditorial;
    }

    public function setCantPaginas(int $nuevaCantidadPaginas)
    {
        $this->cant_paginas = $nuevaCantidadPaginas;
    }

    public function setEstado($nuevoEstado)
    {
        switch ($nuevoEstado) {
            case $nuevoEstado === static::ACTIVO:
                $this->estado = static::ACTIVO;
                break;
            case $nuevoEstado === static::INACTIVO:
                $this->estado = static::INACTIVO;
                break;
            case $nuevoEstado === static::PRESTADO:
                $this->estado = static::PRESTADO;
        }
    }

    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'titulo' => $this->titulo,
            'autores' => $this->autores,
            'editoriales' => $this->editoriales->serializar(),
            'cant_paginas' => $this->cant_paginas,
            'generos' => $this->generos->serializar(),
            'categorias' => $this->categorias->serializar(),
            'estado' => $this->estado,
            'anio' => $this->anio,
        ];
    }

    static function deserializar(array $datos): ModelBase
    {
        return new Self(
            id: $datos['id'] === null ? 0 : $datos['id'],
            titulo: $datos['titulo'],
            autores: $datos['autores'],
            editoriales: $datos['editorial'],
            cant_paginas: $datos['cant_paginas'],
            anio: $datos['anio'],
            generos: $datos['genero'],
            categorias: $datos['categoria'],
            estado: $datos['estado']
        );
    }
}