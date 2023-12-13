<?php
namespace Raiz\Controllers;

use Raiz\Bd\PrestamoDAO;
use Raiz\Bd\LibroDAO;
use Raiz\Bd\SocioDAO;
use Raiz\Models\Prestamo;

    class PrestamoController implements InterfaceController {
        public static function listar(): array {
            $prestamos = [];
            $listadoPrestamo = PrestamoDAO::listar();
            foreach($listadoPrestamo as $prestamo){
                $prestamos[] = $prestamo->serializar();
            }
            return $prestamos;
        }
        
        public static function encontrarUno(string $id): ?array {
            $prestamo = PrestamoDAO::encontrarUno($id);
            if($prestamo===null){
                return $prestamo;
            }else{
                return $prestamo->serializar();
            }
        }
        
        public static function crear(array $parametros): array {
            var_dump($parametros); // parece llegar el arreglo bien pero cuando deserializo me dice que socio debe ser objeto.
            //preguntarle a edu para que pasamos los dos obj completos si necesito solo el id de libro y de socio.
            $socioId = $parametros['socio'];
            $libroId = $parametros['libro'];

            $socioDeser = SocioDAO::encontrarUno($socioId);
            $libroDeser = LibroDAO::encontrarUno($libroId);

            $parametros['socio'] = $socioDeser;
            $parametros['libro'] = $libroDeser;

            var_dump($parametros);
            
            $prestamo = Prestamo::deserializar($parametros);
            var_dump($prestamo);
            
            PrestamoDAO::crear($prestamo);
            return $prestamo->serializar();
        }
        
        public static function actualizar(array $parametros): array {
            $prestamo = Prestamo::deserializar($parametros);
            PrestamoDAO::actualizar($prestamo);
            return $prestamo->serializar();
        }
        
        public static function borrar(string $id):void {
            PrestamoDAO::borrar($id);
        }

        public static function verificarLibroDevuelto(string $id): bool {
            $prestamo = PrestamoDAO::encontrarUno($id);
            if ($prestamo === null) {
                return false;
            }
            
            return $prestamo->getFechaDev() !== null;
        }
        
        public static function calcularDiasRetraso(string $id): int {
            $prestamo = PrestamoDAO::encontrarUno($id);
            if ($prestamo === null) {
                return 0;
            }
        
            return $prestamo->diasRetraso();
        }
    }