<?php

function conectar(){
    return new PDO('pgsql:host=localhost;dbname=tienda', 'tienda', 'tienda');
}

function obtener_parametro($campo,$array) {
    return isset($array[$campo]) ? $array[$campo] : null;
}

function obtener_get($campo){
    return obtener_parametro($campo, $_GET);
}

function obtener_post($campo) {
    return obtener_parametro($campo, $_POST);
}

function volver_articulos() {
    header("Location: /admin/");
}
