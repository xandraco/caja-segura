<?php 
  include("../config/conexion.php");
  $conn = conectar();
  $user = $_POST['user'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $admin = 0;

  // Verficar que el usuario exista
  $queryver = "SELECT * FROM users
  WHERE email = '$email'";

  $validemail = mysqli_query($conn, $queryver);
  if ($validemail->num_rows==0) {
    // usuario no existe
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $queryInsert = "INSERT INTO users
      VALUES(null, '$user', '$email', '$passwordHash', $admin)";
    
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
