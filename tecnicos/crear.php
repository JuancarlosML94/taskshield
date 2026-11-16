<?php
// Incluimos la conexión subiendo un nivel desde la carpeta tecnicos
require_once '../conexion.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos y limpiamos los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');

    // Validación básica
    if (!empty($nombre) && !empty($email)) {
        try {
            // Sentencia SQL con marcadores de posición para PDO
            $sql = "INSERT INTO tecnicos (nombre, email, especialidad) VALUES (:nombre, :email, :especialidad)";
            $stmt = $conexion->prepare($sql);
            
            // Ejecutamos pasando los parámetros de forma segura
            $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':especialidad' => $especialidad
            ]);

            // Redirigimos al listado principal de técnicos tras el éxito
            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $error = "Error al registrar el técnico: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, rellena al menos el nombre y el correo electrónico.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taskshield - Nuevo Técnico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h3>Registrar Nuevo Técnico</h3>
                </div>
                <div class="card-body">
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form action="crear.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre y Apellidos *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Ej: Redes, Hardware, Reparación...">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Técnico</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>