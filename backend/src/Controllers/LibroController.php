<?php

namespace Raiz\Controllers;

use Raiz\Bd\LibroDAO;
use Raiz\Bd\GeneroDAO;
use Raiz\Bd\EditorialDAO;
use Raiz\Bd\CategoriaDAO;
use Raiz\Bd\AutorDAO;
use Raiz\Models\Libro;


class LibroController implements InterfaceController
{
    public static function listar(): array
    {
        $libros = [];
        $listadoLibros = LibroDAO::listar();
        foreach ($listadoLibros as $libro) {
            $libros[] = $libro->serializar();
        }
        return $libros;
    }

    public static function encontrarUno(string $id): ?array
    {
        $libro = LibroDAO::encontrarUno($id);
        if ($libro === null) {
            return null;
        } else {
            return $libro->serializar();
        }
    }

    public static function crear(array $parametros): array
    {
        $libro = Libro::deserializar($parametros);
        LibroDAO::crear($libro);
        return $libro->serializar();
    }

    public static function actualizar(array $parametros): array
    {
        var_dump($parametros);
        //$libro = Libro::deserializar($parametros);
        $parametros['generos'] = GeneroDAO::encontrarUno($parametros['generos']['id']);
        $parametros['categorias'] = CategoriaDAO::encontrarUno($parametros['categorias']['id']);
        $parametros['editoriales'] = EditorialDAO::encontrarUno($parametros['editoriales']['id']);
        
        $autores = [];

        // vemos si existe un autor segun su id y luego iteramos si es un arreglo
        if (isset($parametros['autor']) && is_array($parametros['autor'])) {
            foreach ($parametros['autor'] as $autorData) {
                if (isset($autorData['id'])) {
                    $autor = AutorDAO::encontrarUno($autorData['id']);
                    if ($autor !== null) {
                        $autores[] = $autor;
                    }
                }
            }
        }
        /* if (is_array($parametros['autor']['id'])) {
            foreach ($parametros['autor']['id'] as $idAutor) {
                $autor = AutorDAO::encontrarUno($idAutor);
                if ($autor !== null) {
                    $autores[] = $autor;
                }
            }
        } */
        $parametros['autorList'] = $autores;
        $libro = new Libro(
            id: $parametros['id'],
            titulo: $parametros['titulo'],
            autores: $parametros['autorList'],
            editoriales: $parametros['editoriales'],
            cant_paginas: $parametros['cant_paginas'],
            anio: $parametros['anio'],
            generos: $parametros['generos'],
            categorias: $parametros['categorias'],
        );

        LibroDAO::actualizar($libro);
        return $libro->serializar();
    }

    public static function borrar(string $id): void
    {
        LibroDAO::borrar($id);
    }
}