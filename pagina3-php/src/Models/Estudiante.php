<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class Estudiante {
    private $db;
    private $table_name = "Estudiante";

    // El constructor recibe el objeto Database y obtiene la conexión PDO real.
    public function __construct(Database $db) {
        $this->db = $db->getConnection();
    }

    /**
     * Inserta un nuevo registro de estudiante en la base de datos.
     * @param array $data Array asociativo con los datos del estudiante.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function create($data) {
        try {
            // Asegúrate de que los nombres de las columnas coincidan exactamente con tu tabla.
            $query = "INSERT INTO " . $this->table_name . " 
                      (Nombres, Apellidos, correo_electronico, contraseña, telefono, fecha_n, ID_Direccion) 
                      VALUES 
                      (:nombres, :apellidos, :email, :contrasena, :telefono, :fecha_n, :id_direccion)";
            
            $stmt = $this->db->prepare($query);

            // Bind de los parámetros
            $stmt->bindParam(':nombres', $data['Nombres']);
            $stmt->bindParam(':apellidos', $data['Apellidos']);
            $stmt->bindParam(':email', $data['correo_electronico']);
            $stmt->bindParam(':contrasena', $data['contraseña']); // Contraseña ya viene hasheada desde el Controller
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':fecha_n', $data['fecha_n']);
            
            // ID_Direccion es NULLABLE, por lo que usamos bindValue para manejar NULL de forma segura
            $stmt->bindValue(':id_direccion', $data['ID_Direccion'], PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Registrar el error de la base de datos es vital para la depuración
            error_log("Error al crear estudiante en DB: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca un estudiante por su correo electrónico.
     * @param string $email Correo electrónico del estudiante.
     * @return array|bool Datos del estudiante o false si no se encuentra.
     */
    public function findByEmail($email) {
        // Obtenemos la contraseña para la verificación de hash
        $query = "SELECT ID_Std, Nombres, correo_electronico, contraseña FROM " . $this->table_name . " WHERE correo_electronico = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}