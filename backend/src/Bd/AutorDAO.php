<?php

namespace Raiz\Bd;

use Raiz\Aux\Serializador;
use Raiz\Bd\InterfaceDAO;
use Raiz\Models\Autor;
use \PDO;

class AutorDAO implements InterfaceDAO {
    
    public static function listar(): array {
        $sql = 'SELECT * FROM autores';
        $listaAutores = ConectarBD::leer(sql: $sql);
        $autores = [];
        foreach ($listaAutores as $autor) {
            $autores[] = Autor::deserializar($autor);
        }
        return $autores;
    }

    public static function encontrarUno(string $id): ?Autor {
        $sql = 'SELECT * FROM autores WHERE id =:id;';
        $autor = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($autor) === 0) {
            return null;
        } else {
            $autor = Autor::deserializar($autor[0]);
            return $autor;
        }
    }

    public static function crear(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO autores (id, nombre) VALUES (:id, :nombre)';
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
        $sql = 'UPDATE autores SET nombre =:nombre WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':nombre' => $params['nombre']
            ]
        );
    }

    public static function borrar(string $id) {
        $sql = 'DELETE FROM autores WHERE id=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);
    }

    public static function listarPorIds(array $idsAutores): array
    {
        if (empty($idsAutores)) {
            return [];
        }
        // Crear una cadena de parámetros con comas para la consulta IN
        $inClause = implode(',', array_fill(0, count($idsAutores), '?'));
        $sql = "SELECT * FROM autores WHERE id IN ($inClause)";
        var_dump($sql);
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        
        // Asignar valores a los marcadores de posición en la consulta
        foreach ($idsAutores as $index => $id) {
            $consulta->bindValue($index + 1, $id, PDO::PARAM_INT);
        }

        $consulta->execute();
        $autores = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($autores as $autor) {
            $result[] = Autor::deserializar($autor);
        }
        return $result;
    }

}