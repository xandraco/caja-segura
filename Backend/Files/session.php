<?php
    session_start();

    if (isset($_SESSION['usuario'])) {
        $user = $_SESSION['usuario'];
        echo json_encode(['STATUS' => 'SUCCESS', 'USER' => $user]);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'No hay sesión activa']);
    }
?>
