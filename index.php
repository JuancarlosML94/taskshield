<?php
require_once 'conexion.php';

try {
    // Realizamos una consulta de prueba (cambia 'tecnicos' por una tabla de tu esquema)
    $stmt = $conexion->query("SELECT * FROM tecnicos");
    $resultados = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taskshield - Panel Principal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Taskshield - Listado de Técnicos</h1>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($resultados) > 0): ?>
                <?php foreach ($resultados as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id'] ?? $row['id_tecnico'] ?? 1) ?></td>
                        <td><?= htmlspecialchars($row['nombre'] ?? 'Sin nombre') ?></td>
                        <td><?= htmlspecialchars($row['email'] ?? 'Sin email') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No hay registros en la base de datos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>