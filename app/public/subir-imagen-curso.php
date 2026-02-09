<?php
/**
 * Subida de imágenes para cursos
 * Permite subir imágenes y devuelve la URL
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

// Verificar que se subió un archivo
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No se subió ningún archivo válido']);
    exit;
}

$file = $_FILES['image'];

// Validar tipo de archivo
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowed_types)) {
    http_response_code(400);
    echo json_encode(['error' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF y WebP']);
    exit;
}

// Validar tamaño (máximo 5MB)
if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['error' => 'El archivo es demasiado grande. Máximo 5MB']);
    exit;
}

// Crear directorio si no existe
$upload_dir = wp_upload_dir();
$course_dir = $upload_dir['basedir'] . '/course-images';
$course_url = $upload_dir['baseurl'] . '/course-images';

if (!file_exists($course_dir)) {
    wp_mkdir_p($course_dir);
}

// Generar nombre único
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'curso-' . time() . '-' . wp_generate_password(8, false) . '.' . $extension;
$filepath = $course_dir . '/' . $filename;

// Mover archivo
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // Redimensionar imagen si es muy grande
    $image_editor = wp_get_image_editor($filepath);
    if (!is_wp_error($image_editor)) {
        $image_editor->resize(800, 600, false);
        $image_editor->save($filepath);
    }
    
    $file_url = $course_url . '/' . $filename;
    
    echo json_encode([
        'success' => true,
        'url' => $file_url,
        'filename' => $filename
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el archivo']);
}
?>