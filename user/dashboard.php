
<!-- ============================================
     ARCHIVO: user/dashboard.php
     Panel principal del usuario
     ============================================ -->
<?php
define('APP_ACCESS', true);
require_once '../config/db.php';
require_once '../config/session.php';

requireLogin();

$pageTitle = 'Mi Panel - GTA VAULT';

try {
    $db = Database::getInstance()->getConnection();
    $userId = getUserId();
    
    // Obtener información de la cuenta
    $stmt = $db->prepare("SELECT * FROM cuentas WHERE ID = ?");
    $stmt->execute([$userId]);
    $account = $stmt->fetch();
    
    // Contar personajes
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM personajes WHERE CuentaID = ?");
    $stmt->execute([$userId]);
    $characterCount = $stmt->fetch()['total'];
    
    // Obtener personajes
    $stmt = $db->prepare("SELECT * FROM personajes WHERE CuentaID = ? ORDER BY ID DESC LIMIT 5");
    $stmt->execute([$userId]);
    $characters = $stmt->fetchAll();
    
} catch (PDOException $e) {
    setMessage('error', 'Error al cargar los datos.');
    error_log('Dashboard error: ' . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="card">
    <div class="card-header">📊 Panel Principal</div>
    
    <h2>Bienvenido, <?php echo htmlspecialchars($account['Nombre']); ?>!</h2>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Personajes</div>
            <div class="stat-value"><?php echo $characterCount; ?></div>
        </div>
        
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="stat-label">Estado VIP</div>
            <div class="stat-value"><?php echo $account['VIP'] > 0 ? '✓ Activo' : '✗ No'; ?></div>
        </div>
        
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stat-label">Ranuras Disponibles</div>
            <div class="stat-value"><?php echo $account['Ranuras']; ?></div>
        </div>
        
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="stat-label">Nivel Admin</div>
            <div class="stat-value"><?php echo $account['JotoOtaku']; ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">🎭 Mis Últimos Personajes</div>
    
    <?php if (empty($characters)): ?>
        <p>No tienes personajes creados aún. ¡Conéctate al servidor para crear uno!</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Dinero</th>
                    <th>Facción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($characters as $char): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($char['Nombre_Apellido']); ?></strong></td>
                    <td>Nivel <?php echo $char['Payday']; ?></td>
                    <td>$<?php echo number_format($char['BolosUwU']); ?></td>
                    <td>
                        <?php if ($char['MiembroFaccion'] > 0): ?>
                            <span class="badge badge-primary">Facción #<?php echo $char['MiembroFaccion']; ?></span>
                        <?php else: ?>
                            <span class="badge badge-danger">Sin facción</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/user/character.php?id=<?php echo $char['ID']; ?>" class="btn btn-primary" style="padding: 5px 15px; font-size: 14px;">Ver Detalles</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="/user/characters.php" class="btn btn-primary">Ver Todos Mis Personajes</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-header">📋 Información de la Cuenta</div>
    
    <div class="character-info">
        <strong>Fecha de Registro:</strong>
        <span><?php echo htmlspecialchars($account['FechaRegistro']); ?></span>
    </div>
    
    <div class="character-info">
        <strong>Última Conexión:</strong>
        <span><?php echo htmlspecialchars($account['UltimaConexion']); ?></span>
    </div>
    
    <div class="character-info">
        <strong>Email:</strong>
        <span><?php echo htmlspecialchars($account['Email']); ?></span>
    </div>
    
    <div class="character-info">
        <strong>Máximo de Casas:</strong>
        <span><?php echo $account['MaxCasas']; ?></span>
    </div>
    
    <div class="character-info">
        <strong>Máximo de Negocios:</strong>
        <span><?php echo $account['MaxNegocios']; ?></span>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
