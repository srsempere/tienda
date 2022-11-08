<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de artículos</title>
</head>

<body>
    <?php
    require('auxiliar.php');

    $desde_codigo = obtener_get('desde_codigo');
    $hasta_codigo = obtener_get('hasta_codigo');
    $descripcion = obtener_get('descripcion');
    $desde_precio = obtener_get('desde_precio');
    $hasta_precio = obtener_get('hasta_precio');

    ?>

    <h1>LISTADO DE ARTÍCULOS</h1>
    <form action="" method="get">
        <fieldset>
            <legend>Criterios de búsqueda</legend>
            <p>
                <label for="desde_codigo">Desde código: </label><input type="text" name="desde_codigo">
            </p>
            <p>
                <label for="hasta_codigo">Hasta código: </label><input type="text" name="hasta_codigo">
            </p>
            <p>
                <label for="descripcion">Descripcion: </label><input type="text" name="descripcion">
            </p>
            <p>
                <label for="desde_precio">Desde precio: </label><input type="text" name="desde_precio">
            </p>
            <p>
                <label for="hasta_precio">Hasta precio: </label><input type="text" name="hasta_precio">
            </p>
            <button type="submit">Buscar</button>
        </fieldset>
    </form>

    <?php
    $pdo = conectar();
    $pdo->beginTransaction();
    $pdo->exec('LOCK TABLE articulos IN SHARE MODE');
    $where = [];
    $execute = [];
    if (isset($desde_codigo) && $desde_codigo != '') {
        $where[] = 'codigo >= :desde_codigo';
        $execute[':desde_codigo'] = $desde_codigo;
    }
    if (isset($hasta_codigo) && $hasta_codigo != '') {
        $where[] = 'codigo <= :hasta_codigo';
        $execute[':hasta_codigo'] = $hasta_codigo;
    }
    if (isset($descripcion) && $descripcion != '') {
        $where[] = 'lower(descripcion) LIKE lower(:descripcion)';
        $execute[':descripcion'] = "%$descripcion%";
    }
    if (isset($desde_precio) && $desde_precio != '') {
        $where[] = 'precio >= :desde_precio';
        $execute[':desde_precio'] = $desde_precio;
    }
    if (isset($hasta_precio) && $hasta_precio != '') {
        $where[] = 'precio <= :hasta_precio';
        $execute[':hasta_precio'] = $hasta_precio;
    }

    $where = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
    $sent = $pdo->prepare("SELECT COUNT(*) FROM articulos $where");
    $sent->execute($execute);
    $total = $sent->fetchColumn();

    $sent = $pdo->prepare("SELECT * FROM articulos $where ORDER BY codigo");
    $sent->execute($execute);
    $pdo->commit();
    $nf = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
    ?>
    </br>
    <div>
        <table id="tabla_articulos" style="margin: auto" border="1">
            <thead>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th colspan="2">Acciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['descripcion'] ?></td>
                        <td align="right"><?= $nf->format($fila['precio']) ?></td>
                        <td>Borrar</td>
                        <td>Modificar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
