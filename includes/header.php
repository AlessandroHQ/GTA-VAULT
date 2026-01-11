<!-- ============================================
     ARCHIVO: includes/header.php
     Header HTML común
     ============================================ -->
<?php
defined('APP_ACCESS') or die('Acceso denegado');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'GTA VAULT - Panel de Control'; ?></title>
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
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .navbar-menu {
            display: flex;
            gap: 20px;
            list-style: none;
        }
        
        .navbar-menu a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .navbar-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .card-header {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2a5298;
            border-bottom: 2px solid #2a5298;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
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
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #2a5298;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1e3c72;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2a5298;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .badge-primary {
            background: #2a5298;
            color: white;
        }
        
        .character-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .character-card {
            background: white;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .character-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border-color: #2a5298;
        }
        
        .character-name {
            font-size: 20px;
            font-weight: bold;
            color: #2a5298;
            margin-bottom: 15px;
        }
        
        .character-info {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 14px;
        }
        
        .character-info strong {
            color: #555;
        }
    </style>
</head>
<body>
    <?php if (isLoggedIn()): ?>
    <nav class="navbar">
        <div class="container">
            <a href="/index.php" class="navbar-brand">🎮 GTA VAULT</a>
            <ul class="navbar-menu">
                <li><a href="/user/dashboard.php">Mi Panel</a></li>
                <li><a href="/user/characters.php">Mis Personajes</a></li>
                <?php if (isAdmin()): ?>
                    <li><a href="/admin/dashboard.php">Admin Panel</a></li>
                    <li><a href="/admin/users.php">Usuarios</a></li>
                <?php endif; ?>
                <li><a href="/auth/logout.php">Cerrar Sesión (<?php echo htmlspecialchars(getUsername()); ?>)</a></li>
            </ul>
        </div>
    </nav>
    <?php endif; ?>
    
    <div class="container">
        <?php
        // Mostrar mensajes
        if ($success = getMessage('success')) {
            echo '<div class="alert alert-success">' . htmlspecialchars($success) . '</div>';
        }
        if ($error = getMessage('error')) {
            echo '<div class="alert alert-error">' . htmlspecialchars($error) . '</div>';
        }
        if ($info = getMessage('info')) {
            echo '<div class="alert alert-info">' . htmlspecialchars($info) . '</div>';
        }
        ?>
