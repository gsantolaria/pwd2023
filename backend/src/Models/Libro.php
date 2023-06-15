<?php

declare(strict_types=1);
namespace Raiz\Models;

class Libro extends ModelBase
{
    private $titulo;
    private $editorial;
    private array $autor;
    private $genero;
    private $cant_paginas;
    private $categoria;
    private $anio_publicacion;
    private $estado;

    const ACTIVO = "Activo";
    const INACTIVO = "Inactivo";
    const PRESTADO = "Prestado";

    public function __construct(int $id, string $titulo, Editorial $editorial, Categoria $categoria, array $autor, Genero $genero, int $cant_paginas, int $anio_publicacion, string $estado = self::ACTIVO) {
        parent::__construct($id);
        $this->titulo = $titulo;
        $this->editorial = $editorial;
        $this->categoria = $categoria;
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
        $listaAutores =[];
        foreach($this->autor as $autores){
            $listaAutores = $autores->serializar();
        }
        return $listaAutores;;
    }

    public function setAutor(array $autorList)
    {
        foreach ($autorList as $autor) {
            $this->autor[] = $autor;
        }
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
            'autor' => $this->getAutor(),
            'editorial' => $this->editorial->serializar(),
            'cant_paginas' => $this->cant_paginas,
            'genero' => $this->genero->serializar(),
            'categoria' => $this->categoria->serializar(),
            'estado' => $this->estado,
            'anio'=>$this->anio_publicacion
        ];
    }
    static function deserializar(array $datos): ModelBase
    {
        return new Self(
            id: $datos['id'] === null ? 0 : $datos['id'],
            titulo: $datos['titulo'],
            autor: $datos['autor'],
            editorial: $datos['editorial'],
            cant_paginas: $datos['cant_paginas'],
            anio_publicacion: $datos['anio'],
            genero: $datos['genero'],
            categoria: $datos['categoria'],
            estado: $datos['estado']
        );
    }
}