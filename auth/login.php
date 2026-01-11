
<!-- ============================================
     ARCHIVO: auth/login.php
     Sistema de autenticación
     ============================================ -->
<?php
define('APP_ACCESS', true);
require_once '../config/db.php';
require_once '../config/session.php';

// Si ya está logueado, redirigir
if (isLoggedIn()) {
    header('Location: /user/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Por favor, completa todos los campos.';
    } else {
        try {
            $db = Database::getInstance()->getConnection();
            
            // Buscar usuario
            $stmt = $db->prepare("SELECT ID, Nombre, Clave, Salt, JotoOtaku FROM cuentas WHERE Nombre = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && verifyPassword($password, $user['Clave'], $user['Salt'])) {
                // Login exitoso
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['username'] = $user['Nombre'];
                $_SESSION['admin_level'] = $user['JotoOtaku']; // Campo que indica nivel admin
                
                // Actualizar última conexión
                $stmt = $db->prepare("UPDATE cuentas SET UltimaConexion = ? WHERE ID = ?");
                $stmt->execute([date('H:i:s - d/m/Y'), $user['ID']]);
                
                setMessage('success', '¡Bienvenido de vuelta, ' . htmlspecialchars($username) . '!');
                header('Location: /user/dashboard.php');
                exit;
            } else {
                $error = 'Usuario o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            $error = 'Error en el sistema. Por favor, intenta más tarde.';
            error_log('Login error: ' . $e->getMessage());
        }
    }
}

$pageTitle = 'Iniciar Sesión - GTA VAULT';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #2a5298;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #2a5298;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: #2a5298;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #1e3c72;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🎮 GTA VAULT</h1>
            <p>Panel de Control de Usuario</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" class="form-control" 
                       placeholder="Tu usuario de SA-MP" required autofocus
                       value="<?php echo htmlspecialchars($username ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" 
                       placeholder="Tu contraseña" required>
            </div>
            
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>
        
        <p style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
            ¿No tienes cuenta? Regístrate en el servidor SA-MP
        </p>
    </div>
</body>
</html>
