<?php

namespace Raiz\Bd;

use Raiz\Models\Autor;
use Raiz\Models\Libro;
use Raiz\Aux\Serializador;
use PDO;

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
            $libro['autores'][] = static::buscarAutoresPorLibro($libro['id']);

            $libros[] = Libro::deserializar($libro);
        }
        //
        return $libros;
    }

    public static function buscarAutoresPorLibro(string $id): array
    {
        $sql = 'SELECT id_autor FROM autores_libros WHERE id_libro =:id;';
        
        $autores = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($autores) === 0) {
            return [];
        } else {
            $idsAutores = array_map(fn($autor) => $autor["id_autor"], $autores);
            var_dump($idsAutores);
            $autores = AutorDAO::listarPorIds($idsAutores);
            return $autores;
        }
        /* $sql = 'SELECT id_autor FROM autores_libros WHERE id_libro =:id;';
        $autores = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        
        if (count($autores) === 0) {
            return [];
        } else{
            return $autor[] =  AutorDAO::encontrarUno($autores[0]["id_autor"]);
        } */
    }

    public static function encontrarUno(string $id): ?libro
    {
        $sql = 'SELECT * FROM libros WHERE id =:id;';
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

    // Verificar si 'id' está presente en $params
    if (array_key_exists('id', $params)) {
        $sql = 'INSERT INTO libros (titulo, id_genero, id_categoria, cant_paginas, anio, estado, id_editorial) 
            VALUES (:titulo, :id_genero, :id_categoria, :cant_paginas, :anio, :estado, :id_editorial);';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':titulo' => $params['titulo'],
                ':id_genero' => $params['generos']->getId(),
                ':id_categoria' => $params['categorias']->getId(),
                ':cant_paginas' => $params['cant_paginas'],
                ':anio' => $params['anio'],
                ':estado' => $params['estado'],
                ':id_editorial' => $params['editoriales']->getId(),
            ]
        );

        // Obtener el ID del último libro insertado
        $idLibro = ConectarBD::ultimoId();

        // Verificar si 'id' está presente en $params['autor']
        if (array_key_exists('autor', $params) && is_array($params['autor'])) {
            foreach ($params['autor'] as $autor) {
                $sql = 'INSERT INTO autores_libros (id_autor, id_libro) 
                    VALUES ( :id_autor, :id_libro)';
                ConectarBD::escribir(
                    sql: $sql,
                    params: [
                        ':id_autor' => $autor['id'],
                        ':id_libro' => $idLibro,
                    ]
                );
            }
        } else {
            // Manejar el caso en el que 'autor' no está presente o no es un array
            error_log("Error: 'autor' no está presente o no es un array en LibroDAO.");
        }
    } else {
        // Manejar el caso en el que 'id' no está presente en $params
        error_log("Error: 'id' no está presente en los parámetros en LibroDAO.");
    }
}


    public static function actualizar(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'UPDATE libros SET titulo =:titulo, id_genero = :id_genero, id_categoria = :id_categoria, 
        cant_paginas = :cant_paginas, anio = :anio, estado = :estado, id_editorial = :id_editorial 
        WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':titulo' => $params['titulo'],
                ':id_genero' => $params['genero']->getId(),
                ':id_categoria' => $params['categoria']->getId(),
                ':cant_paginas' => $params['cant_paginas'],
                ':anio' => $params['anio'],
                ':estado' => $params['estado'],
                ':id_editorial' => $params['editorial']->getId(),
            ]
        );
    }

    public static function buscarUltimoLibro():int{
        $sql = 'SELECT MAX(id) as id FROM libros ';
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        ConectarBD::escribir(
            sql: $sql,
            params: []
        );
        $consulta = $cnx->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC)[0]["id"];

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