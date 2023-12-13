<?php
session_start();

$user = $_SESSION['usuario'];
include("../config/conexion.php");
$conn = conectar();

$queryCheckExisting = "DELETE FROM `tokenActual` WHERE ta_id_user = :idUsuario";
$stmt = $conn->prepare($queryCheckExisting);
$stmt->bindParam(":idUsuario", $user['id'], PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(['STATUS' => 'SUCCESS']);
} else {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al eliminar tokens']);
}
?>
