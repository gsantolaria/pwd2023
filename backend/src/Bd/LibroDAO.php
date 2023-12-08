<?php

namespace Raiz\Bd;

use Raiz\Models\Libro;
use Raiz\Aux\Serializador;
use PDO;
use Raiz\Bd\PDOException;

class LibroDAO implements InterfaceDAO
{
    public static function listar(): array
    {
        $sql = 'SELECT *  FROM  libros';
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        $consulta->execute();
        $listaLibros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $libros = [];
        foreach ($listaLibros as $libro) {
            $libro['categoria'] = CategoriaDAO::encontrarUno($libro['id_categoria']);
            $libro['genero'] = GeneroDAO::encontrarUno($libro['id_genero']);
            $libro['editorial'] = EditorialDAO::encontrarUno($libro['id_editorial']);
            $libro['autores'] = static::buscarAutoresPorLibro($libro['id']);
            //var_dump($libro);
            $libros[] = Libro::deserializar($libro);
        }
        return $libros;
    }

    public static function buscarAutoresPorLibro(string $id): array
    {
        $sql = 'SELECT id_autor FROM autores_libros WHERE id_libro =:id;';
        $autores = ConectarBD::leer(sql: $sql, params: [':id' => $id]);

        if (count($autores) === 0) {
            return null;
        } else {
            $idsAutores = array_map(fn($autor) => $autor["id_autor"], $autores);
            $autores = AutorDAO::listarPorIds($idsAutores);
            return $autores;
        }
    }

    public static function encontrarUno(string $id): ?libro
    {
    $sql = 'SELECT * FROM libros WHERE id =:id;';
        //var_dump($id);
        $libro = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($libro) === 0) {
            return null;
        } else {
            $libro[0]['categoria'] = CategoriaDAO::encontrarUno($libro[0]['id_categoria']);
            $libro[0]['genero'] = GeneroDAO::encontrarUno($libro[0]['id_genero']);
            $libro[0]['editorial'] = EditorialDAO::encontrarUno($libro[0]['id_editorial']);
            $libro[0]['autores'] = LibroDAO::buscarAutoresPorLibro($libro[0]["id"]);
            return Libro::deserializar($libro[0]);
        }
    }

    public static function crear(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        var_dump($params['autores']);
        $sql = 'INSERT INTO libros (titulo, id_genero, id_categoria, cant_paginas, anio, estado, id_editorial) 
        VALUES (:titulo, :id_genero, :id_categoria, :cant_paginas, :anio, :estado, :id_editorial)';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':titulo' => $params['titulo'],
                ':id_genero' => $params['generos']['id'],
                ':id_categoria' => $params['categorias']['id'],
                ':cant_paginas' => $params['cant_paginas'],
                ':anio' => $params['anio'],
                ':estado' => $params['estado'],
                ':id_editorial' => $params['editoriales']['id'],
            ]
        );

        $idLibro = static::buscarUltimoLibro();    
        
        foreach ($params['autores'] as $autor) {
            $sql3 = 'INSERT INTO autores_libros (id_autor, id_libro) 
            VALUES ( :id_autor, :id_libro)';
            ConectarBD::escribir(
                sql: $sql3,
                params: [
                    ':id_libro' => $idLibro,
                    ':id_autor' => $autor['id'],
                ]
            );
        }
    }


    public static function actualizar(Serializador $instancia): void
    {
        //var_dump($instancia);
        $params = $instancia->serializar();
        //var_dump($params);
        
        $sql = 'UPDATE libros SET titulo =:titulo, id_genero = :id_genero, id_categoria = :id_categoria, 
                cant_paginas = :cant_paginas, anio = :anio, estado = :estado, id_editorial = :id_editorial 
                WHERE id=:id';  
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':titulo' => $params['titulo'],
                ':id_genero' => $params['generos']['id'],
                ':id_categoria' => $params['categorias']['id'],
                ':cant_paginas' => $params['cant_paginas'],
                ':anio' => $params['anio'],
                ':estado' => $params['estado'],
                ':id_editorial' => $params['editoriales']['id'],
            ]
        );
    }
    // podemos probar con lastinsertid() si usando esta funcion no me actualiza la tabla autores_libros
    public static function buscarUltimoLibro():int
    {
        $sql = 'SELECT MAX(id) as id FROM libros';
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado['id']
    }

    public static function actualizarEstado(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'UPDATE libros SET estado =:estado WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':estado' => $params['estado'],
            ]
        );
    }

    public static function borrar(string $id)
    {
        $sql = 'DELETE FROM libros WHERE id=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);

        $sql = 'DELETE FROM autores_libros WHERE id_libro=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);
    }
}