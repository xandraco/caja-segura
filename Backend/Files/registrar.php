<?php 
  include("../config/conexion.php");
  $conn = conectar();
  $nombre = $_POST['nombre'];
  $apaterno = $_POST['apaterno'];
  $amaterno = $_POST['amaterno'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Verficar que el usuario exista
  $queryVerifica = "SELECT * FROM usuarios
  WHERE email = '$email'";

  $validaCorreo = mysqli_query($conn, $queryVerifica);
  if ($validaCorreo->num_rows==0) {
    // usuario no existe
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $queryInsert = "INSERT INTO usuarios
      VALUES(null, '$nombre', '$apaterno', '$amaterno', '$email', '$passwordHash')";
    
    $result = mysqli_query($conn, $queryInsert);
    if ($result) {
      Header("Location: ../../index.html");
    } else {
      Header("Location: ../../registrar.html?error=true");
    }
  } else {
    // usuario existe
    Header("Location: ../../registrar.html?existe=true");
  }
?>
