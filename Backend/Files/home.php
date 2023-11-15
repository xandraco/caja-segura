<?php
  include("../config/conexion.php");
  $conn = conectar();
  $dataPost = file_get_contents('php://input');
  $body = json_decode($dataPost, true);

  if ($body !== null) {
    $email = $body['email'];

    // Buscamos el usuario dentro de la base de datos
    $queryUsuario = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($queryUsuario);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $validaUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($validaUsuario) > 0) {
      $user = $validaUsuario[0];
      echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => $user]);
    } else {
      echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'No se encontró usuario']);
    }
  }

?>
