<?php
include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);
$token = $body['token'];
$idUsuario = $body['idUsuario'];
$tokenhash = password_hash($token, PASSWORD_BCRYPT);

$queryCheckExisting = "SELECT * FROM tokenActual WHERE id = '$idUsuario'";
$resultadoCheck = mysqli_query($conn, $queryCheckExisting);


if ($resultadoCheck && mysqli_num_rows($resultadoCheck) > 0) {
  // Si existe un registro para este usuario, elimínalo
  $queryDeleteExisting = "DELETE FROM tokenActual WHERE id = '$idUsuario'";
  $resultadoDelete = mysqli_query($conn, $queryDeleteExisting);

  if (!$resultadoDelete) {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al eliminar el token existente']);
    exit();
  }
}


$queryInsertToken = "INSERT INTO tokenActual VALUES ('$idUsuario', '$tokenhash', '$idUsuario')";
$resultadoInsert = mysqli_query($conn, $queryInsertToken);

if ($resultadoInsert) {
  echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => $tokenhash]);
} else {
  echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al almacenar el token']);
}
?>