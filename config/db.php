<!-- ============================================
     ARCHIVO: config/db.php
     Configuración de la base de datos
     ============================================ -->
<?php
// Prevenir acceso directo
defined('APP_ACCESS') or define('APP_ACCESS', true);

// Configuración de la base de datos
define('DB_HOST', 'gamma.optiklink.com');
define('DB_PORT', '3306');
define('DB_USER', 'u278604_4nh2LF7kB3');
define('DB_PASS', 'K+5LTIQ@i^Ngq^OI69?^lqVG');
define('DB_NAME', 's278604_vault');

// Tipo de hash usado en SA-MP (cambiar según tu servidor)
// Opciones: 'whirlpool', 'md5', 'sha256', 'bcrypt'
define('PASSWORD_HASH_TYPE', 'whirlpool'); // Ajusta según tu gamemode

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevenir clonación
    private function __clone() {}
    
    // Prevenir unserialize
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Función para hash de contraseñas (adaptable a SA-MP)
function hashPassword($password, $salt = '') {
    switch(PASSWORD_HASH_TYPE) {
        case 'whirlpool':
            return strtoupper(hash('whirlpool', $password . $salt));
        case 'md5':
            return md5($password . $salt);
        case 'sha256':
            return hash('sha256', $password . $salt);
        case 'bcrypt':
            return password_hash($password, PASSWORD_HASH_BCRYPT);
        default:
            return strtoupper(hash('whirlpool', $password . $salt));
    }
}

// Función para verificar contraseña
function verifyPassword($password, $hash, $salt = '') {
    if (PASSWORD_HASH_TYPE === 'bcrypt') {
        return password_verify($password, $hash);
    } else {
        return hashPassword($password, $salt) === $hash;
    }
}
?>
