<?php
namespace Raiz\Aux\Utiles;

Class Utileria {

    public static function PasarAJson(String $AJson):Array{
        return Json_Decode($AJson, true);
    }
}   