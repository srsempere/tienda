<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Listado de artículos</title>
</head>

<body>
    <?php
    require('../../src/admin-auxiliar.php');

    $desde_codigo = obtener_get('desde_codigo');
    $hasta_codigo = obtener_get('hasta_codigo');
    $descripcion = obtener_get('descripcion');
    $desde_precio = obtener_get('desde_precio');
    $hasta_precio = obtener_get('hasta_precio');

    ?>

    <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Listado <span class="text-blue-600 dark:text-blue-500">De</span> Artículos</h1>
    <form action="" method="get">
        <h1 class="text-5xl font-extrabold dark:text-white"><small class="ml-2 font-semibold text-gray-500 dark:text-gray-400">CRITERIOS DE BÚSQUEDA</small></h1>

        <div class="overflow-x-auto relative">
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
        </div>
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
    <!-- component -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <div class="flex items-center justify-center min-h-screen bg-gray-900">
        <div class="col-span-12">
            <div class="overflow-auto lg:overflow-visible ">
                <table class="table text-gray-400 border-separate space-y-6 text-sm">
                    <thead class="bg-gray-800 text-gray-500">
                    <?php foreach ($sent as $fila) : ?>
                        <tr>
                            <th class="p-3 text-left">Código</th>
                            <th class="p-3">Descripción</th>
                            <th class="p-3 text-left">Price</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-gray-800">
                            <td class="p-3">
                                <?= $fila['codigo'] ?>
                            </td>
                            <td class="p-3">
                                <div class="flex align-items-center">
                                    <img class="rounded-full h-12 w-12  object-cover" src="https://cdn-icons-png.flaticon.com/512/3394/3394009.png" alt="unsplash image">
                                    <div class="ml-3">
                                        <div class="">Descripcion</div>
                                        <div class="text-gray-500">mail@rgmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 font-bold">
                                200.00$
                            </td>
                            <td class="p-3">
                                <span class="bg-green-400 text-gray-50 rounded-md px-2">available</span>
                            </td>
                            <td class="p-3 ">
                                <a href="#" class="text-gray-400 hover:text-gray-100 mr-2">
                                    <i class="material-icons-outlined text-base">visibility</i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-100  mx-2">
                                    <i class="material-icons-outlined text-base">edit</i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-100  ml-2">
                                    <i class="material-icons-round text-base">delete_outline</i>
                                </a>
                            </td>
                        </tr>
                        <tr class="bg-gray-800">
                            <td class="p-3">
                                Technology
                            </td>
                            <td class="p-3">
                                <div class="flex align-items-center">
                                    <img class="rounded-full h-12 w-12   object-cover" src="https://images.unsplash.com/photo-1423784346385-c1d4dac9893a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80" alt="unsplash image">
                                    <div class="ml-3">
                                        <div class="">Realme</div>
                                        <div class="text-gray-500">mail@rgmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 font-bold">
                                200.00$
                            </td>
                            <td class="p-3">
                                <span class="bg-red-400 text-gray-50 rounded-md px-2">no stock</span>
                            </td>
                            <td class="p-3">
                                <a href="#" class="text-gray-400 hover:text-gray-100  mr-2">
                                    <i class="material-icons-outlined text-base">visibility</i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-100 mx-2">
                                    <i class="material-icons-outlined text-base">edit</i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-100 ml-2">
                                    <i class="material-icons-round text-base">delete_outline</i>
                                </a>
                            </td>
                        </tr>
                        <tr class="bg-gray-800">
                            <td class="p-3">
                                Technology
                            </td>
                            <td class="p-3">
                                <div class="flex align-items-center">
                                    <img class="rounded-full h-12 w-12   object-cover" src="https://images.unsplash.com/photo-1600856209923-34372e319a5d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2135&q=80" alt="unsplash image">
                                    <div class="ml-3">
                                        <div class="">Samsung</div>
                                        <div class="text-gray-500">mail@rgmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 font-bold">
                                200.00$
                            </td>
                            <td class="p-3">
                                <span class="bg-yellow-400 text-gray-50  rounded-md px-2">start sale</span>
                            </td>
                            <td class="p-3">
                                <a href="#" class="text-gray-400 hover:text-gray-100 mr-2">
                                    <i class="material-icons-outlined text-base">visibility</i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-100 mx-2">
                                    <i class="material-icons-outlined text-base">edit</i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-100 ml-2">
                                    <i class="material-icons-round text-base">delete_outline</i>
                                </a>
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
                        <td>
                            <?php $fila_id = $fila['id'] ?>
                            <a href="/admin/editar.php?id=<?= $fila ?>"><button class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Editar</button></a>
                            <a href="confirmar_borrado.php?id=<?= $fila['id'] ?>">Borrar</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
