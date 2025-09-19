<?php
namespace App\Controllers;

use App\Models\Estudiante;
use App\Core\Sanitize; 

class AuthController {
    private $estudianteModel;

    public function __construct(Estudiante $estudianteModel) {
        $this->estudianteModel = $estudianteModel;
    }

    /**
     * Maneja el proceso de registro de un nuevo estudiante.
     * @param array $data Datos enviados por el formulario (JSON body).
     * @return array Respuesta de éxito o error con detalles de validación.
     */
    public function register($data) {
        $errors = [];

        // 1. Validar y sanear datos
        $nombre = Sanitize::text($data['nombre'] ?? '');
        $apellido = Sanitize::text($data['apellido'] ?? '');
        $email = Sanitize::email($data['email'] ?? '');
        $telefono = Sanitize::text($data['telefono'] ?? '');
        $contrasena = $data['contrasena'] ?? '';
        $confirmarContrasena = $data['confirmar-contrasena'] ?? '';

        // Validaciones básicas de campos
        if (empty($nombre)) $errors['nombre'] = 'El nombre es obligatorio.';
        if (empty($apellido)) $errors['apellido'] = 'El apellido es obligatorio.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'El formato del correo electrónico es inválido.';
        if (empty($contrasena) || strlen($contrasena) < 6) $errors['contrasena'] = 'La contraseña debe tener al menos 6 caracteres.';
        if ($contrasena !== $confirmarContrasena) $errors['confirmar-contrasena'] = 'Las contraseñas no coinciden.';
        
        // --- NUEVA VALIDACIÓN DE TELÉFONO EN PHP (SEGURIDAD) ---
        // Si se proporciona un valor (no vacío), debe tener exactamente 8 dígitos.
        if (!empty($telefono)) {
            // Verifica que contenga exactamente 8 dígitos numéricos.
            if (!preg_match('/^\d{8}$/', $telefono)) {
                $errors['telefono'] = 'El teléfono debe contener exactamente 8 dígitos numéricos.';
            }
        }
        // --- FIN NUEVA VALIDACIÓN ---

        // 2. Verificar si el correo ya existe
        if (empty($errors) && $this->estudianteModel->findByEmail($email)) {
            $errors['email_existente'] = 'Este correo electrónico ya está registrado.';
        }

        if (!empty($errors)) {
            http_response_code(400); // 400 Bad Request
            return ['success' => false, 'message' => 'Error de validación de datos.', 'errors' => $errors];
        }

        // 3. Preparar datos y Crear el nuevo estudiante
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
        
        // Manejo de campos NOT NULL ('fecha_n' y 'telefono') para la DB
        $fechaActual = date('Y-m-d'); 
        // Asignamos '0' si el campo vino vacío, ya que es NOT NULL en la DB (telefonos válidos serán los de 8 dígitos)
        $telefono_val = empty($telefono) ? '0' : $telefono; 

        $estudianteData = [
            'Nombres' => $nombre,
            'Apellidos' => $apellido,
            'correo_electronico' => $email,
            'contraseña' => $hashedPassword,
            'telefono' => $telefono_val,
            'fecha_n' => $fechaActual, 
            'ID_Direccion' => null, 
        ];

        if ($this->estudianteModel->create($estudianteData)) {
            http_response_code(201); // 201 Created
            return ['success' => true, 'message' => 'Registro exitoso.'];
        } else {
            http_response_code(500); // 500 Internal Server Error
            return ['success' => false, 'message' => 'Error al guardar el estudiante en la base de datos.'];
        }
    }
    
    /**
     * Maneja el proceso de inicio de sesión.
     */
    public function login($data) {
        $email = Sanitize::email($data['nombreUsuario'] ?? '');
        $contrasena = $data['contrasena'] ?? '';

        if (empty($email) || empty($contrasena)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'Credenciales incompletas.'];
        }

        $user = $this->estudianteModel->findByEmail($email);

        if (!$user) {
            http_response_code(401); // 401 Unauthorized
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        }

        // Verificar la contraseña hasheada
        if (password_verify($contrasena, $user['contraseña'])) {
            http_response_code(200);
            return ['success' => true, 'message' => 'Inicio de sesión exitoso.', 'user_id' => $user['ID_Std']];
        } else {
            http_response_code(401);
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        }
    }
}