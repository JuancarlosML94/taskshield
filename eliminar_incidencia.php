<?php
require_once 'conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM incidencias WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        header("Location: index.php?msg=" . urlencode("Incidencia #$id eliminada correctamente."));
        exit;
    }
}

header("Location: index.php?msg=" . urlencode("No se pudo eliminar: la incidencia no existe."));
exit;