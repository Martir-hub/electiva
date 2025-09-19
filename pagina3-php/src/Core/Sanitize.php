<?php
namespace App\Core;

class Sanitize {
    
    // Método que faltaba, llamado por AuthController
    public static function text($data) {
        if (!is_string($data)) {
            return '';
        }
        $data = trim($data);
        $data = stripslashes($data);
        // Usa ENT_QUOTES para manejar comillas simples y dobles
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); 
        return $data;
    }

    public static function email($data) {
        $data = trim($data);
        // Filtro de PHP para sanear el email
        return filter_var($data, FILTER_SANITIZE_EMAIL);
    }
}