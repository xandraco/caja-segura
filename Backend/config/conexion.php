<?php
  function conectar() {
    $host = "localhost:8889";
    $user = "root";
    $pass = "root";
    $db = "crud_sistema";
    $conn = mysqli_connect($host,$user,$pass);
    mysqli_select_db($conn, $db);
    return $conn;
  }
?>
