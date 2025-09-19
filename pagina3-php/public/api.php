<?php
// public/api.php

// Mostrar errores de PHP para facilitar la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carga las clases usando Composer
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Models\Estudiante;
use App\Config\Database;

// 1. Inicialización de Componentes
// ------------------------------------
// Nota: La instanciación de Database es correcta aquí, asumiendo que el constructor es público.
$database = new Database();
$estudianteModel = new Estudiante($database);
$authController = new AuthController($estudianteModel);

// 2. Configuración de Encabezados (CORS y JSON)
// ------------------------------------
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 3. Ruteo de la API
// ------------------------------------

// Obtener la URI solicitada
$uri = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

// Buscamos la posición de 'api.php' para obtener la ruta limpia (ej. 'auth/register')
$pathSegments = explode('/', $uri);
$endpointKey = array_search('api.php', $pathSegments);
$route = '';
$action = '';

if ($endpointKey !== false) {
    // La ruta limpia de la API es lo que viene después de api.php
    $route = $pathSegments[$endpointKey + 1] ?? ''; // ej: 'auth'
    $action = $pathSegments[$endpointKey + 2] ?? ''; // ej: 'register'
}

$response = ["success" => false, "message" => "Ruta de API no procesada."];

// Lógica para rutas de autenticación
if ($route === 'auth' && $method === 'POST') {
    
    // Leer el JSON enviado por el JavaScript (fetch)
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data)) {
        http_response_code(400);
        $response = ["success" => false, "message" => "Datos JSON no recibidos o formato incorrecto."];
    } elseif ($action === 'register') {
        $response = $authController->register($data);
    } elseif ($action === 'login') {
        $response = $authController->login($data);
    } else {
        http_response_code(404);
        $response = ["success" => false, "message" => "Acción de autenticación no válida."];
    }
} elseif ($method !== 'POST') {
    http_response_code(405);
    $response = ["success" => false, "message" => "Método no permitido. Solo se acepta POST."];
} else {
    // Si la ruta no coincide con 'api.php/auth/...', devolver 404
    http_response_code(404);
    $response = ["success" => false, "message" => "Ruta de API no encontrada."];
}

// 4. Retornar la respuesta final
// ------------------------------------
echo json_encode($response);
exit;