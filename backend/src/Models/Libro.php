<?php

namespace Raiz\Models;

use Error;

class Libro extends ModelBase
{
    private $titulo;
    /** @var Editorial */
    private $editorial;
    /** @var array<Autor> */
    private array $autores;
    /** @var Genero */
    private $genero;
    /** @var Categoria */
    private $categoria;
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
        Editorial $editorial,
        int $cant_paginas,
        int $anio,
        Genero $genero,
        Categoria $categoria,
        string $estado = self::ACTIVO

    ) {
        parent::__construct($id);
        $this->titulo = $titulo;
        $this->editorial = $editorial;
        $this->autores = $autores;
        $this->genero = $genero;
        $this->cant_paginas = $cant_paginas;
        $this->anio = $anio;
        $this->categoria = $categoria;
        $this->estado = $estado;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }
    public function getGenero(): Genero
    {
        return $this->genero;
    }
    public function getEditorial(): Editorial
    {
        return $this->editorial;
    }
    public function getCategoria(): Categoria
    {
        return $this->categoria;
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
        $this->categoria = $nuevaCategoria;
    }

    public function setGenero(Genero $nuevoGenero)
    {
        $this->genero = $nuevoGenero;
    }

    public function setEditorial(Editorial $nuevaEditorial)
    {
        $this->editorial = $nuevaEditorial;
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
            'editorial' => $this->editorial->serializar(),
            'cant_paginas' => $this->cant_paginas,
            'genero' => $this->genero->serializar(),
            'categoria' => $this->categoria->serializar(),
            'estado' => $this->estado,
            'anio' => $this->anio,
        ];
    }

    static function deserializar(array $datos): ModelBase
    {
        $datosEditorial = is_array($datos['editorial']) ? $datos['editorial'] : [];
        $datosGenero = is_array($datos['genero']) ? $datos['genero'] : [];
        $datosCategoria = is_array($datos['categoria']) ? $datos['categoria'] : [];

        $id = array_key_exists('id', $datos) ? $datos['id'] : 0;
        $anio = array_key_exists('anio', $datos) ? $datos['anio'] : 0;
        $estado = array_key_exists('estado', $datos) ? $datos['estado'] : '';

        return new Self(
            id: $id,
            titulo: $datos['titulo'],
            autores: $datos['autores'] ?? [],
            editorial: Editorial::deserializar($datosEditorial),
            cant_paginas: $datos['cant_paginas'],
            anio: $anio,
            genero: Genero::deserializar($datosGenero),
            categoria: Categoria::deserializar($datosCategoria),
            estado: $estado
        );
    }
}