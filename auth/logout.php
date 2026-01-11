
<!-- ============================================
     ARCHIVO: auth/logout.php
     Cerrar sesión
     ============================================ -->
<?php
define('APP_ACCESS', true);
require_once '../config/session.php';

// Destruir sesión
session_destroy();

// Redirigir al login
header('Location: /auth/login.php');
exit;
?>
