<?php

namespace Raiz\Bd;

use Raiz\Aux\Serializador;
use Raiz\Bd\InterfaceDAO;
use Raiz\Models\Libro;

class LibroDAO implements InterfaceDAO {
    public static function listar(): array {
        $sql = 'SELECT * FROM libros';
        $listaLibros = ConectarBD::leer(sql: $sql);
        $libros = [];
        foreach ($listaLibros as $libro) {
            $libros[] = Libro::deserializar($libro);
        }
        return $libros;
    }

    public static function encontrarUno(string $id): ?Libro {
        $sql = 'SELECT * FROM libros WHERE id =:id;';
        $libro = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($libro) === 0) {
            return null;
        } else {
            $libro = Libro::deserializar($libro[0]);
            return $libro;
        }
    }

    public static function crear(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO libros (id, titulo, autor_id, editorial_id, categoria_id, genero_id) VALUES (:id, :titulo, :autor_id, :editorial_id, :categoria_id, :genero_id)';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':titulo' => $params['titulo'],
                ':autor_id' => $params['autor_id'],
                ':editorial_id' => $params['editorial_id'],
                ':categoria_id' => $params['categoria_id'],
                ':genero_id' => $params['genero_id']
            ]
        );
    }

    public static function actualizar(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'UPDATE libros SET titulo =:titulo, autor_id =:autor_id, editorial_id =:editorial_id, categoria_id =:categoria_id, genero_id =:genero_id WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':titulo' => $params['titulo'],
                ':autor_id' => $params['autor_id'],
                ':editorial_id' => $params['editorial_id'],
                ':categoria_id' => $params['categoria_id'],
                ':genero_id' => $params['genero_id']
            ]
        );
    }

    public static function borrar(string $id) {
        $sql = 'DELETE FROM libros WHERE id=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);
    }
}