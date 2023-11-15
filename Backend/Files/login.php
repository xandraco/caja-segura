<?
  include("../config/conexion.php");
  $conn = conectar();
  $dataPost = file_get_contents('php://input');
  $body = json_decode($dataPost, true);

  if ($body !== null) {
    $email = $body['email'];
    $password = $body['password'];

    $queryUsuario = "SELECT * FROM usuarios WHERE email = '$email'";
    $validaUsuario = mysqli_query($conn, $queryUsuario);

    if($validaUsuario -> num_rows > 0) {
      $usuario = $validaUsuario -> fetch_assoc();
      if (password_verify($password, $usuario['password'])) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'success', 'USUARIO' => $usuario]);
      } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Invalid password']);
      }
      // echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => $usuario]);
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
