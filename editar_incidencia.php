<?php
require_once 'conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php?msg=" . urlencode("ID de incidencia no válido."));
    exit;
}

// Verificar que el registro existe antes de mostrar o actualizar
$stmt = $pdo->prepare("SELECT * FROM incidencias WHERE id = :id");
$stmt->execute([':id' => $id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    header("Location: index.php?msg=" . urlencode("Error: La incidencia #$id no existe."));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS);
    $prioridad = filter_input(INPUT_POST, 'prioridad', FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "UPDATE incidencias SET estado = :estado, prioridad = :prioridad WHERE id = :id";
    $stmtUpdate = $pdo->prepare($sql);
    $stmtUpdate->execute([
        ':estado'    => $estado,
        ':prioridad' => $prioridad,
        ':id'        => $id
    ]);

    header("Location: index.php?msg=" . urlencode("Incidencia #$id actualizada."));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>Editar Incidencia #<?= $incidencia['id'] ?> - <?= htmlspecialchars($incidencia['titulo']) ?></h3>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Pendiente" <?= $incidencia['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="En Proceso" <?= $incidencia['estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
                <option value="Resuelta" <?= $incidencia['estado'] === 'Resuelta' ? 'selected' : '' ?>>Resuelta</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select">
                <option value="Baja" <?= $incidencia['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
                <option value="Media" <?= $incidencia['prioridad'] === 'Media' ? 'selected' : '' ?>>Media</option>
                <option value="Alta" <?= $incidencia['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
                <option value="Urgente" <?= $incidencia['prioridad'] === 'Urgente' ? 'selected' : '' ?>>Urgente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>