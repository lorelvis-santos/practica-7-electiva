<?php

$dbHost = getenv('DB_HOST') ?: 'db';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'hola_mundo';
$dbUser = getenv('DB_USER') ?: 'app_user';
$dbPassword = getenv('DB_PASSWORD') ?: 'app_password';

$databaseName = null;
$serverTime = null;

try {
    $connection = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPassword,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $result = $connection->query('SELECT DATABASE() AS database_name, NOW() AS server_time');
    $database = $result->fetch(PDO::FETCH_ASSOC);
    $databaseName = $database['database_name'];
    $serverTime = $database['server_time'];
} catch (PDOException $exception) {
    http_response_code(503);
}

function escapeHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hola mundo con MySQL</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { align-items: center; background: #f1f5f9; display: flex; justify-content: center; min-height: 100vh; margin: 0; }
        main { background: white; border-radius: 1rem; box-shadow: 0 1rem 3rem #0f172a18; max-width: 36rem; padding: 2.5rem; width: calc(100% - 3rem); }
        h1 { color: #0f172a; margin-top: 0; }
        .status { border-radius: .5rem; padding: 1rem; }
        .connected { background: #dcfce7; color: #166534; }
        .disconnected { background: #fee2e2; color: #991b1b; }
        code { background: #f1f5f9; border-radius: .25rem; padding: .15rem .35rem; }
    </style>
</head>
<body>
<main>
    <h1>¡Hola, mundo!</h1>
    <?php if ($databaseName !== null): ?>
        <section class="status connected" role="status">
            <strong>Conexión a MySQL exitosa.</strong>
            <p>Base de datos: <code><?= escapeHtml($databaseName) ?></code></p>
            <p>Hora del servidor: <code><?= escapeHtml($serverTime) ?></code></p>
        </section>
    <?php else: ?>
        <section class="status disconnected" role="alert">
            No fue posible conectar con la base de datos. Verifica que el servicio MySQL esté disponible.
        </section>
    <?php endif; ?>
</main>
</body>
</html>
