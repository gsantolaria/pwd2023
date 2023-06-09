<?php

namespace Raiz\Bd;

use Raiz\Aux\Serializador;
use Raiz\Bd\InterfaceDAO;
use Raiz\Models\Categoria;

class CategoriaDAO implements InterfaceDAO {

    public static function listar(): array {
        $sql = 'SELECT * FROM categorias';
        $listaCategorias = ConectarBD::leer(sql: $sql);
        $categorias = [];
        foreach ($listaCategorias as $categoria) {
            $categorias[] = Categoria::deserializar($categoria);
        }
        return $categorias;
    }

    public static function encontrarUno(string $id): ?Categoria {
        $sql = 'SELECT * FROM categorias WHERE id =:id;';
        $categoria = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($categoria) === 0) {
            return null;
        } else {
            $categoria = Categoria::deserializar($categoria[0]);
            return $categoria;
        }
    }

    public static function crear(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO categorias (id, nombre) VALUES (:id, :nombre)';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':nombre' => $params['nombre']
            ]
        );
    }

    public static function actualizar(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'UPDATE categorias SET nombre =:nombre WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':nombre' => $params['nombre']
            ]
        );
    }

    public static function borrar(string $id) {
        $sql = 'DELETE FROM categorias WHERE id=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);
    }
}