<?php
require_once 'conexion.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Uso obligatorio de filter_input para validar y sanitizar
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
    $prioridad = filter_input(INPUT_POST, 'prioridad', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email_cliente', FILTER_VALIDATE_EMAIL);

    if (!$titulo || !$descripcion || !$email) {
        $error = "Datos inválidos. Revisa que todos los campos estén rellenos y el email sea correcto.";
    } else {
        try {
            $sql = "INSERT INTO incidencias (titulo, descripcion, prioridad, email_cliente) 
                    VALUES (:titulo, :descripcion, :prioridad, :email)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo'      => $titulo,
                ':descripcion' => $descripcion,
                ':prioridad'   => $prioridad ?: 'Media',
                ':email'       => $email
            ]);

            $nuevoId = $pdo->lastInsertId();
            header("Location: index.php?msg=" . urlencode("Incidencia creada correctamente con ID #" . $nuevoId));
            exit;
        } catch (PDOException $e) {
            $error = "Error al guardar la incidencia.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>Registrar Nueva Incidencia</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email del cliente</label>
            <input type="text" name="email_cliente" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select">
                <option value="Baja">Baja</option>
                <option value="Media" selected>Media</option>
                <option value="Alta">Alta</option>
                <option value="Urgente">Urgente</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>