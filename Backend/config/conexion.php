<?php
  function conectar() {
    $host = "https://auth-db531.hstgr.io/";
    $user = "u351541285_SSPS_admin";
    $pass = ';j$e[Gw7?G';
    $db = "u351541285_ssp_safe";
    $conn = mysqli_connect($host,$user,$pass);
    mysqli_select_db($conn, $db);
    return $conn;
  }
?>
