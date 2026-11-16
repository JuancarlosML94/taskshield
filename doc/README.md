# Taskshield - Intranet de Soporte Técnico

Aplicación web desarrollada en PHP 8 y MySQL utilizando PDO para la gestión de incidencias técnicas.

## Estructura del Proyecto
- `config.php`: Credenciales de conexión (excluido en `.gitignore`).
- `conexion.php`: Instancia PDO con manejo de excepciones y emulación de preparadas desactivada.
- `index.php`: Listado principal de incidencias mediante `LEFT JOIN` y `fetchAll(PDO::FETCH_ASSOC)`.
- `nueva_incidencia.php`: Alta de incidencias con validación `filter_input` y redirección con `lastInsertId()`.
- `editar_incidencia.php`: Modificación de estado y prioridad verificando existencia por `GET`.
- `eliminar_incidencia.php`: Borrado seguro comprobando `rowCount()`.
- `asignar_tecnico.php`: Asignación transaccional (`beginTransaction`, `commit`, `rollBack`) que actualiza la incidencia e incrementa `tareas_activas` en el técnico.
- `doc/`: Script SQL y tabla de casos de prueba.

## Instalación
1. Importar `doc/schema.sql` en phpMyAdmin.
2. Configurar `config.php` con los datos del servidor MySQL local.
3. Acceder desde `http://localhost/taskshield/`.