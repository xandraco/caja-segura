<?php
session_start();

include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$conn = conectar();

// Query para obtener usuarios
$query = "SELECT usedToken.id, users.user AS userName, usedToken.token, usedToken.useDate FROM usedToken JOIN users ON usedToken.ut_id_user = users.id;
";
$stmt = $conn->prepare($query);
$stmt->execute();
$tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($stmt) {
    echo json_encode(['STATUS' => 'SUCCESS', 'TOKENS' => $tokens]);
} else {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al obtener usuarios']);
}
?>