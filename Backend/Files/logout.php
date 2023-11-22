<?php
session_start();

$user = $_SESSION['usuario'];
include("../config/conexion.php");
$conn = conectar();
$queryCheckExisting = "DELETE FROM `tokenActual` WHERE ta_id_user = :idUsuario";
$stmt = $conn->prepare($queryCheckExisting);
$stmt->bindParam(":idUsuario", $user['id'], PDO::PARAM_INT);
$stmt->execute();
$validTokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Elimina todas las variables de sesión
$_SESSION = array();

// Invalida la sesión
session_destroy();

// Redirige al usuario a la página de inicio de sesión
header("Location: /"); // Ajusta la ruta según tu estructura de archivos
exit();
?>