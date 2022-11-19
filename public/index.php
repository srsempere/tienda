<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
    <title>Portal</title>
</head>

<body>

    <?php
    require_once '../src/auxiliar.php';

    $pdo = conectar();
    $sent = $pdo->query("SELECT * FROM articulos ORDER BY codigo");
    ?>

    <h1 class="mt-5 mx-3 mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">G∂D <span class="text-blue-600 dark:text-blue-500">⌨</span> G∊T</h1>
    <div class="mx-8 mb-4">
        <h1 class="text-5xl font-extrabold dark:text-white"><small class="ml-2 font-semibold text-gray-500 dark:text-gray-400">Bienvenido a tu portal de compra</small></h1>
    </div>

    <!-- zona oscura-->

    <div class="flex items-top justify-center min-h-screen bg-gray-900">
        <div class="col-span-12">
            <div class="overflow-auto lg:overflow-visible ">
                <!-- TARJETAS DE ARTÍCULO -->
                <div class="flex">
                    <main class="flex-1 grid grid-cols-3 gap-4 justify-center justify-items-center">
                        <?php foreach ($sent as $fila): ?>
                            <div class="mt-5 mx-5 p-4 max-w-sm bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                                    <a href="#">
                                        <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" />
                                    </a>
                                    <div class="p-5">
                                        <a href="#">
                                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $fila['denominacion'] ?></h5>
                                        </a>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $fila['descripcion'] ?></p>
                                        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Más información
                                            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                            </div>
                        <?php endforeach ?>
                    </main>
                </div>

            </div>
        </div>
    </div>
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
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
