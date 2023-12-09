<?php
namespace Raiz\Controllers;
use Raiz\Bd\AutorDAO;
use Raiz\Models\Autor;

class AutorController implements InterfaceController {
    public static function listar(): array {
        $autores = [];
        $listadoAutor = AutorDAO::listar();
        foreach($listadoAutor as $autor){
            $autores[] = $autor->serializar();
        }
        return $autores;
    }
    
    public static function encontrarUno(string $id): ?array {
        $autor = AutorDAO::encontrarUno($id);
        if($autor===null){
            return $autor;
        }else{
            return $autor->serializar();
        }
    }
    
    public static function crear(array $parametros): array {
        /* $autor = new Autor();
        AutorDAO::crear($autor);
        return $autor->serializar(); */
        $Autor = Autor::deserializar($parametros);
        AutorDAO::crear($Autor);
        return $Autor->serializar();
    }
    
    public static function actualizar(array $parametros): array {
        $autor = Autor::deserializar($parametros);
        AutorDAO::actualizar($autor);
        return $autor->serializar();
    }
    
    public static function borrar(string $id):void {
        AutorDAO::borrar($id);
    }
}