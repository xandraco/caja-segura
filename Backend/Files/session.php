<?php
session_start();

// Verifica si hay una sesión activa
if (isset($_SESSION['usuario'])) {
    // Ya hay una sesión activa, podrías manejarlo de acuerdo a tus necesidades
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Ya hay una sesión activa']);
} else {
    // Recibe los datos del usuario desde la solicitud
    $dataPost = file_get_contents('php://input');
    $userData = json_decode($dataPost, true);

    if ($userData !== null && isset($userData['usuario'])) {
        // Almacena la información del usuario en la sesión
        $_SESSION['usuario'] = $userData['usuario'];

        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'Sesion validada','USER' => $userData]);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Datos no válidos']);
    }
}
?>
