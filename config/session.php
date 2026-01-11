<!-- ============================================
     ARCHIVO: config/session.php
     Gestión de sesiones
     ============================================ -->
<?php
defined('APP_ACCESS') or die('Acceso denegado');

// Iniciar sesión segura
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'use_strict_mode' => true,
        'cookie_samesite' => 'Strict'
    ]);
}

// Funciones de sesión
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

function isAdmin() {
    return isLoggedIn() && isset($_SESSION['admin_level']) && $_SESSION['admin_level'] > 0;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /auth/login.php');
        exit;
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        $_SESSION['error'] = 'Acceso denegado. Se requieren permisos de administrador.';
        header('Location: /user/dashboard.php');
        exit;
    }
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getUsername() {
    return $_SESSION['username'] ?? null;
}

function setMessage($type, $message) {
    $_SESSION[$type] = $message;
}

function getMessage($type) {
    if (isset($_SESSION[$type])) {
        $message = $_SESSION[$type];
        unset($_SESSION[$type]);
        return $message;
    }
    return null;
}
?>