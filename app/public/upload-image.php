<?php
/**
 * Manejador de Subida de Imágenes - Mongruas Formación
 * Procesa la subida de imágenes para el panel de gestión
 */

header('Content-Type: application/json');

// Verificar que es una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Verificar que se envió un archivo
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibió ningún archivo válido']);
    exit;
}

$file = $_FILES['image'];
$courseId = $_POST['course_id'] ?? 'unknown';

// Validar tipo de archivo
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF y WebP']);
    exit;
}

// Validar tamaño (máximo 5MB)
$maxSize = 5 * 1024 * 1024; // 5MB
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode(['error' => 'El archivo es demasiado grande. Máximo 5MB']);
    exit;
}

// Crear directorio si no existe
$uploadDir = 'wp-content/uploads/cursos/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generar nombre único para el archivo
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileName = 'curso_' . $courseId . '_' . time() . '.' . $extension;
$filePath = $uploadDir . $fileName;

// Mover archivo subido
if (move_uploaded_file($file['tmp_name'], $filePath)) {
    // Éxito
    echo json_encode([
        'success' => true,
        'message' => 'Imagen subida correctamente',
        'file_path' => $filePath,
        'file_url' => '/' . $filePath
    ]);
} else {
    // Error al mover archivo
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el archivo']);
}
?>