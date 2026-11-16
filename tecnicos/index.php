<?php
// Incluimos la conexión (subiendo un nivel desde la carpeta tecnicos)
require_once '../conexion.php';

try {
    $stmt = $conexion->query("SELECT * FROM tecnicos ORDER BY id DESC");
    $tecnicos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al cargar los técnicos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taskshield - Gestión de Técnicos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Técnicos</h1>
        <div>
            <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
            <a href="crear.php" class="btn btn-primary">Nuevo Técnico</a>
        </div>
    </div>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($tecnicos) > 0): ?>
                <?php foreach ($tecnicos as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($t['nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($t['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($t['especialidad'] ?? 'General') ?></td>
                        <td>
                            <a href="editar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este técnico?');">Eliminar</a>
                         </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay técnicos registrados todavía.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>