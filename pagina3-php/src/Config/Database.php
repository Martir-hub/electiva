<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $db_name = "uni"; // << ASEGÚRATE DE QUE ESTO ES CORRECTO >>
    private $username = "root";
    private $password = ""; // << VERIFICA TU CONTRASEÑA >>
    public $conn;

    // ¡CAMBIO CLAVE AQUÍ!
    // Hacemos el constructor público para que se pueda llamar con "new Database()"
    public function __construct() { 
        // Llama a la lógica de conexión inmediatamente
        $this->getConnection(); 
    }

    public function getConnection() {
        // Si la conexión ya existe, la devuelve
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            // Detiene la ejecución si la conexión falla
            die("Error de conexión a base de datos: " . $exception->getMessage());
        }
        return $this->conn;
    }
}