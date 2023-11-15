<?php
  include("../config/conexion.php");
  $conn = conectar();
  $dataPost = file_get_contents('php://input');
  $body = json_decode($dataPost, true);

  if ($body !== null) {
    $email = $body['email'];
    $password = $body['password'];

    $queryuser = "SELECT * FROM users WHERE email = '$email'";
    $validuser = mysqli_query($conn, $queryuser);

    if($validuser -> num_rows > 0) {
      $usuario = $validuser -> fetch_assoc();
      if (password_verify($password, $usuario['password'])) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'success', 'USUARIO' => $usuario]);
      } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Contraseña incorrecta']);
      }
      die;
    } else {
      echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'No se encontro el usuario']);
    }

    // echo $email . ' ' . $password;
  } else {
    http_response_code(400);
    echo 'Invalid Data';
  }
?>
