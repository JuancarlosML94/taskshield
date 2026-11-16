<?php
require_once 'conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php?msg=" . urlencode("ID inválido."));
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tecnico_id = filter_input(INPUT_POST, 'tecnico_id', FILTER_VALIDATE_INT);

    try {
        // Iniciamos la transacción
        $pdo->beginTransaction();

        // 1. Actualizar estado y asignar técnico a la incidencia
        $sql1 = "UPDATE incidencias SET estado = 'En Proceso', tecnico_id = :tecnico_id WHERE id = :id";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([':tecnico_id' => $tecnico_id, ':id' => $id]);

        // 2. Incrementar en +1 las tareas_activas del técnico
        $sql2 = "UPDATE tecnicos SET tareas_activas = tareas_activas + 1 WHERE id = :tecnico_id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([':tecnico_id' => $tecnico_id]);

        // Comprobamos que el técnico realmente existía (afectó a 1 fila)
        if ($stmt2->rowCount() === 0) {
            throw new Exception("El técnico seleccionado no existe.");
        }

        // Si ambas van bien, confirmamos cambios
        $pdo->commit();
        header("Location: index.php?msg=" . urlencode("Incidencia #$id asignada correctamente."));
        exit;

    } catch (Exception $e) {
        // Si algo falla, deshacemos toda la operación
        $pdo->rollBack();
        $error = "Error en la asignación (RollBack ejecutado): " . $e->getMessage();
    }
}

// Cargar técnicos disponibles para el select
$tecnicos = $pdo->query("SELECT id, nombre, especialidad, tareas_activas FROM tecnicos")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>Asignar Técnico a Incidencia #<?= $id ?></h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Selecciona un Técnico</label>
            <select name="tecnico_id" class="form-select" required>
                <?php foreach ($tecnicos as $t): ?>
                    <option value="<?= $t['id'] ?>">
                        <?= htmlspecialchars($t['nombre']) ?> (Tareas activas: <?= $t['tareas_activas'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-info">Asignar Incidencia</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>