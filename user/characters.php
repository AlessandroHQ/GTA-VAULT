<!-- ============================================
     ARCHIVO: user/characters.php
     Lista completa de personajes del usuario
     ============================================ -->
<?php
define('APP_ACCESS', true);
require_once '../config/db.php';
require_once '../config/session.php';

requireLogin();

$pageTitle = 'Mis Personajes - GTA VAULT';

try {
    $db = Database::getInstance()->getConnection();
    $userId = getUserId();
    
    // Obtener todos los personajes del usuario
    $stmt = $db->prepare("SELECT * FROM personajes WHERE CuentaID = ? ORDER BY ID DESC");
    $stmt->execute([$userId]);
    $characters = $stmt->fetchAll();
    
} catch (PDOException $e) {
    setMessage('error', 'Error al cargar los personajes.');
    error_log('Characters error: ' . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="card">
    <div class="card-header">🎭 Todos Mis Personajes (<?php echo count($characters); ?>)</div>
    
    <?php if (empty($characters)): ?>
        <p style="text-align: center; padding: 40px; color: #666;">
            No tienes personajes creados aún.<br>
            ¡Conéctate al servidor para crear tu primer personaje!
        </p>
    <?php else: ?>
        <div class="character-list">
            <?php foreach ($characters as $char): ?>
                <div class="character-card">
                    <div class="character-name">
                        <?php echo htmlspecialchars($char['Nombre_Apellido']); ?>
                    </div>
                    
                    <div class="character-info">
                        <strong>💰 Dinero en mano:</strong>
                        <span>$<?php echo number_format($char['BolosUwU']); ?></span>
                    </div>
                    
                    <div class="character-info">
                        <strong>🏦 Banco:</strong>
                        <span>$<?php echo number_format($char['BanescoOwO']); ?></span>
                    </div>
                    
                    <div class="character-info">
                        <strong>📅 Nivel:</strong>
                        <span><?php echo $char['Payday'];