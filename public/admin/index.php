<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
    <title>Listado de artículos</title>
    <script>
        function cambiar(el, id) {
            el.preventDefault();
            const oculto = document.getElementById('oculto');
            oculto.setAttribute('value', id);
        }
    </script>
</head>

<body>
    <?php
    require '../../src/admin-auxiliar.php';
    require '../../src/auxiliar.php';

    $desde_codigo = obtener_get('desde_codigo');
    $hasta_codigo = obtener_get('hasta_codigo');
    $descripcion = obtener_get('descripcion');
    $desde_precio = obtener_get('desde_precio');
    $hasta_precio = obtener_get('hasta_precio');

    ?>

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


    <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Listado <span class="text-blue-600 dark:text-blue-500">De</span> Artículos</h1>


    <div class="overflow-x-auto relative">
        <form action="" method="get">
            <h1 class="text-5xl font-extrabold dark:text-white"><small class="ml-2 font-semibold text-gray-500 dark:text-gray-400">CRITERIOS DE BÚSQUEDA</small></h1>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Desde código:
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Hasta código:
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Descripcion:
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Desde precio:
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Hasta precio:
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">
                            <input type="text" name="desde_codigo">
                        </td>
                        <td class="py-4 px-6">
                            <input type="text" name="hasta_codigo">
                        </td>
                        <td class="py-4 px-6">
                            <input type="text" name="descripcion">
                        </td>
                        <td class="py-4 px-6">
                            <input type="text" name="desde_precio">
                        </td>
                        <td class="py-4 px-6">
                            <input type="text" name="hasta_precio">
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Buscar</button>
                        </td>
                    <tr>
                </tbody>
            </table>
        </form>
    </div>


    </br>


    <div class="flex items-top justify-center min-h-screen bg-gray-900">
        <div class="col-span-12">
            <div class="overflow-auto lg:overflow-visible ">
                <table class="table text-gray-400 border-separate space-y-6 text-sm" style="margin-top: 60px;">
                    <thead class="bg-gray-800 text-gray-500">

                        <tr>
                            <th class="p-3 text-center">Código</th>
                            <th class="p-3 text-center">Descripción</th>
                            <th class="p-3 text-center">Price</th>
                            <th class="p-3 text-center">Stock</th>
                            <th class="p-3 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sent as $fila) : ?>
                            <tr class="bg-gray-800">
                                <td class="p-3">
                                    <?= $fila['codigo'] ?>
                                </td>
                                <td class="p-3">
                                    <div class="flex align-items-center">
                                        <img class="rounded-full h-12 w-12  object-cover" src="https://cdn-icons-png.flaticon.com/512/3394/3394009.png" alt="unsplash image">
                                        <div class="ml-3">
                                            <div class=""><?= $fila['descripcion'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3 font-bold">
                                    <?= $nf->format($fila['precio']) ?>
                                </td>
                                <td class="p-3">
                                    <span class="bg-green-400 text-gray-50 rounded-md px-2">available</span>
                                </td>
                                <td class="p-3 ">
                                    <?php $fila_id = $fila['id'] ?>
                                    <a href="/admin/editar.php?id=<?= $fila_id ?>" class="text-gray-400 hover:text-gray-100  mx-2">
                                        <i class="material-icons-outlined text-base">edit</i>
                                    </a>
                                    <form action="/admin/borrar.php" method="post" class="inline">
                                        <input type="hidden" name="id" value="<?= $fila_id ?>">
                                        <button type="submit" onclick="cambiar(event, <?= $fila_id ?>)"  data-modal-toggle="popup-modal"><i class="material-icons-round text-base">delete_outline</i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .table {
            border-spacing: 0 15px;
        }

        i {
            font-size: 1rem !important;
        }

        .table tr {
            border-radius: 20px;
        }

        tr td:nth-child(n+5),
        tr th:nth-child(n+5) {
            border-radius: 0 .625rem .625rem 0;
        }

        tr td:nth-child(1),
        tr th:nth-child(1) {
            border-radius: .625rem 0 0 .625rem;
        }
    </style>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Seguro que desea borrar este artículo?</h3>
                    <form action="/admin/borrar.php" method="POST">
                        <input id="oculto" type="hidden" name="id">
                        <button data-modal-toggle="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sí, seguro
                        </button>
                        <button data-modal-toggle="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
