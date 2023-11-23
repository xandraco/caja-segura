<?php
session_start();

include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$conn = conectar();

// Query para obtener usuarios
$query = "SELECT * FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($stmt) {
    echo json_encode(['STATUS' => 'SUCCESS', 'USERS' => $users]);
} else {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al obtener usuarios']);
}
?>