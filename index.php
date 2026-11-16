<?php
require_once 'conexion.php';

// Consulta preparada para listar incidencias con el nombre del técnico
$sql = "SELECT i.*, t.nombre AS tecnico_nombre 
        FROM incidencias i 
        LEFT JOIN tecnicos t ON i.tecnico_id = t.id 
        ORDER BY i.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taskshield - Soporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Panel de Incidencias</h2>
        <a href="nueva_incidencia.php" class="btn btn-primary">Nueva Incidencia</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Cliente</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Técnico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencias as $inc): ?>
                <tr>
                    <td><?= $inc['id'] ?></td>
                    <td><?= htmlspecialchars($inc['titulo']) ?></td>
                    <td><?= htmlspecialchars($inc['email_cliente']) ?></td>
                    <td><?= htmlspecialchars($inc['prioridad']) ?></td>
                    <td><?= htmlspecialchars($inc['estado']) ?></td>
                    <td><?= htmlspecialchars($inc['tecnico_nombre'] ?? 'Sin asignar') ?></td>
                    <td>
                        <a href="asignar_tecnico.php?id=<?= $inc['id'] ?>" class="btn btn-sm btn-info">Asignar</a>
                        <a href="editar_incidencia.php?id=<?= $inc['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="eliminar_incidencia.php?id=<?= $inc['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres borrar esta incidencia?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>