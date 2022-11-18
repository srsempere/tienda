<?php
session_start();

require '../../src/admin-auxiliar.php';
require '../../src/auxiliar.php';

$id = obtener_post('id');

if (!isset($id)) {
    return volver_articulos();
}

$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE articulos IN SHARE MODE');
$sent = $pdo->prepare("SELECT COUNT(*)
                        FROM articulos
                        WHERE id = :id");
$sent->execute([':id' => $id]);
if ($sent->fetchColumn() !== 0) {
    $sent = $pdo->prepare("DELETE FROM articulos WHERE id = :id");
    $sent->execute([":id" => $id]);
    $_SESSION['mensaje'] = 'El articulo se ha borrado correctamente';
}
$pdo->commit();
volver_articulos();
