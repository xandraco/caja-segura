<?php
  include("../config/conexion.php");
  $conn = conectar();
  $dataPost = file_get_contents('php://input');
  $body = json_decode($dataPost, true);
  $email = $body['email'];
  $queryUsuario = "SELECT * FROM users WHERE email = '$email'";
  $validaUsuario = mysqli_query($conn, $queryUsuario);

  if ($validaUsuario -> num_rows > 0) {
    $user = $validaUsuario -> fetch_assoc();
    echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => $user]);
  } else {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'No se encontro usuario']);
  }

?>
