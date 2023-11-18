<?php
  function conectar() {
    $host = "auth-db531.hstgr.io";
    $user = "u351541285_SSPS_admin";
    $pass = "HW[CPUs9^Vp";
    $db = "u351541285_ssp_safe";
    
    try {
      $pdo = new PDO("mysql:host=$host; dbname=$db", $user, $pass);
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      die ("Error de conexion en la base de datos: " . $e->getMessage());
    }
  }
?>
