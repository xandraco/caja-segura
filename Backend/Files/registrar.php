<?php
  include("../config/conexion.php");
  $conn = conectar();
  $user = $_POST['user'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $admin = 0;

  // Verificar que el usuario exista
  $queryver = "SELECT * FROM users WHERE email = :email";
  $stmt = $conn->prepare($queryver);
  $stmt->bindParam(":email", $email, PDO::PARAM_STR);
  $stmt->execute();
  $validemail = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($validemail) == 0) {
      // Usuario no existe
      $passwordHash = password_hash($password, PASSWORD_BCRYPT);

      $queryInsert = "INSERT INTO users VALUES(null, :user, :email, :passwordHash, :admin)";
      $stmt = $conn->prepare($queryInsert);
      $stmt->bindParam(":user", $user, PDO::PARAM_STR);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->bindParam(":passwordHash", $passwordHash, PDO::PARAM_STR);
      $stmt->bindParam(":admin", $admin, PDO::PARAM_INT);
      
      $result = $stmt->execute();
      if ($result) {
          header("Location: ../../index.html");
      } else {
          header("Location: ../../registrar.html?error=true");
      }
  } else {
      // Usuario existe
      header("Location: ../../registrar.html?existe=true");
  }
?>
