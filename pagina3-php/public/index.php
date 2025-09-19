<?php
// public/index.php

// ... (El código de `ini_set` y `error_reporting` es correcto y se queda igual)

// Carga las clases (Autoloading)
require __DIR__ . '/../vendor/autoload.php';

// Obtener la vista solicitada (ej. login, registro)
$view = $_GET['view'] ?? 'landing';

// Mapeo de vistas permitidas
$allowed_views = [
    'landing' => 'landing_page.html',
    'login' => 'login.html',
    'registro' => 'registro.html',
    // ... más vistas
];

$views_dir = __DIR__ . '/../src/Views/';
$html_file = $allowed_views[$view] ?? null;

if ($html_file && file_exists($views_dir . $html_file)) {
    include $views_dir . $html_file;
} else {
    // Manejar el caso de una vista no encontrada
    http_response_code(404);
    echo "<h1>404 - Página no encontrada</h1>";
}