<?php

namespace Raiz\Bd;

use Raiz\Aux\Serializador;
use Raiz\Bd\InterfaceDAO;
use Raiz\Models\Prestamo;
use PDO;

class PrestamoDAO implements InterfaceDAO {
    
    public static function listar(): array {
        $sql = 'SELECT *  FROM  prestamos';
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        $consulta->execute();
        $listaprestamos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
        $prestamos = [];
        foreach ($listaprestamos as $prestamo) {
            $prestamo['id'] = (int)$prestamo['id'];
            $prestamo['socio'] = SocioDAO::encontrarUno($prestamo['id_socio']);
            $prestamo['libro'] = LibroDAO::encontrarUno($prestamo['id_libro']);
            $prestamos[] = Prestamo::deserializar($prestamo);
            
        }
        return $prestamos;
    }

    public static function BuscarPrestamos($id)
    {
        $sql = 'SELECT id_socio FROM autores_prestamos WHERE id_prestamo =:id;';
        $autores = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        
        if (count($autores) === 0) {
            return null;
        } else {
            return $autor[] =  AutorDAO::encontrarUno($autores[0]["id_socio"]);
            
        }
    }
    
    public static function encontrarUno(string $id): ?Prestamo {
        $sql = 'SELECT * FROM prestamos WHERE id =:id;';
        $prestamo = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($prestamo) === 0) {
            return null;
        } else { 
            $prestamo[0]['genero'] = GeneroDAO::encontrarUno($prestamo[0]['id_genero']);
            $prestamo[0]['editorial'] = EditorialDAO::encontrarUno($prestamo[0]['id_editorial']);
            $autoresprestamos[] = static::BuscarPrestamos($prestamo[0]["id"]);

            foreach ($autoresprestamos as $autor) {
                $prestamo[0]["autor"][] = $autor;
            }
            
            $prestamo = prestamo::deserializar($prestamo[0]);
            var_dump($prestamo);
            return $prestamo;
        }
    }
    
    public static function crear(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO prestamos (id_socio, id_libro, fecha_desde, fecha_hasta, fecha_dev) VALUES (:socio, :libro, :fecha_desde, :fecha_hasta, :fecha_dev)';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':socio' => $params['socio']['id'],
                ':libro' => $params['libro']['id'],
                ':fecha_desde' => $params['fecha_desde'],
                ':fecha_hasta' => $params['fecha_hasta'],
                ':fecha_dev' => $params['fecha_dev']
            ]
        );
    }
    
    public static function actualizar(Serializador $instancia): void {
        $params = $instancia->serializar();
        $sql = 'UPDATE prestamos SET id = :id, socio = :socio, libro = :libro, fecha_desde = :fecha_desde, fecha_hasta = :fecha_hasta, fecha_dev = :fecha_dev WHERE id = :id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':socio' => $params['socio'],
                ':libro' => $params['libro'],
                ':fecha_desde' => $params['fecha_desde'],
                ':fecha_hasta' => $params['fecha_hasta'],
                ':fecha_dev' => $params['fecha_dev']
            ]
        );
    }
    
    public static function borrar(string $id) {
        $sql = 'DELETE FROM prestamos WHERE id=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);
    }
}