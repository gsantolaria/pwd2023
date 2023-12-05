<?php

namespace Raiz\Controllers;

use Raiz\Bd\LibroDAO;
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
        echo(var_dump($parametros));
        $libro = Libro::deserializar($parametros);
        echo(var_dump($libro));
        LibroDAO::actualizar($libro);
        return $libro->serializar();
    }

    public static function borrar(string $id): void
    {
        LibroDAO::borrar($id);
    }
}