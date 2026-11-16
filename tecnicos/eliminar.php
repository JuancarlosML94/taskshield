<?php
require_once '../conexion.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $conexion->prepare("DELETE FROM tecnicos WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        // Manejo de errores si fuera necesario (ej. restricciones de clave ajena)
    }
}

header("Location: index.php");
exit;