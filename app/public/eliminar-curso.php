<?php
/**
 * Eliminar Curso Individual - Mongruas Formación
 * Maneja la eliminación de cursos específicos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Verificar que es una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Verificar que se envió el índice del curso
if (!isset($_POST['course_index'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Índice de curso no especificado']);
    exit;
}

$course_index = intval($_POST['course_index']);

// Obtener cursos actuales
$courses = get_option('mongruas_courses', []);

// Verificar que el índice existe
if (!isset($courses[$course_index])) {
    http_response_code(404);
    echo json_encode(['error' => 'Curso no encontrado']);
    exit;
}

// Eliminar el curso
$deleted_course = $courses[$course_index];
unset($courses[$course_index]);

// Reindexar el array
$courses = array_values($courses);

// Guardar los cambios
update_option('mongruas_courses', $courses);

// Respuesta exitosa
echo json_encode([
    'success' => true,
    'message' => 'Curso eliminado correctamente',
    'deleted_course' => $deleted_course['name'],
    'remaining_courses' => count($courses)
]);
?>