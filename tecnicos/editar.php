<?php
require_once '../conexion.php';

$error = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

// Si se envía el formulario por POST, actualizamos los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');

    if (!empty($nombre) && !empty($email)) {
        try {
            $sql = "UPDATE tecnicos SET nombre = :nombre, email = :email, especialidad = :especialidad WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':especialidad' => $especialidad,
                ':id' => $id
            ]);

            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error al actualizar el técnico: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, rellena los campos obligatorios.";
    }
} else {
    // Consultamos los datos actuales del técnico
    try {
        $stmt = $conexion->prepare("SELECT * FROM tecnicos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $tecnico = $stmt->fetch();

        if (!$tecnico) {
            header("Location: index.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Error al cargar el técnico: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taskshield - Editar Técnico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h3>Editar Técnico</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="editar.php?id=<?= $id ?>" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre y Apellidos *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($tecnico['nombre']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($tecnico['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?= htmlspecialchars($tecnico['especialidad'] ?? '') ?>">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>