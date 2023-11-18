<?php
  session_start();

  include("../config/conexion.php");
  $conn = conectar();
  $dataPost = file_get_contents('php://input');
  $body = json_decode($dataPost, true);

  if ($body !== null) {
    $email = $body['email'];
    $password = $body['password'];

    // Buscamos el usuario dentro de la base de datos
    $queryuser = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn -> prepare ($queryuser);
    $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
    $stmt -> execute();
    $validuser = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if (count($validuser) > 0) {
      $usuario = $validuser[0];
      if (password_verify($password, $usuario['password'])) {
        // Almacenamos la información de la sesión
        $_SESSION['usuario'] = $usuario;

        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'success']);
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