<?php
include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);
$token = $body['token'];
$idUsuario = $body['idUsuario'];

$queryInsertToken = "INSERT INTO tokenActual VALUES (NULL, '$token', '$idUsuario')";
$resultadoInsert = mysqli_query($conn, $queryInsertToken);

if ($resultadoInsert) {
  echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'Token almacenado en la base de datos']);
} else {
  echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al almacenar el token']);
}
?>