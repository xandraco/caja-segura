<?php
  function conectar() {
    $host = "https://auth-db531.hstgr.io/";
    $user = "u351541285_SSPS_admin";
    $pass = "HW[CPUs9^Vp";
    $db = "u351541285_ssp_safe";
    $conn = mysqli_connect($host,$user,$pass);
    mysqli_select_db($conn, $db);
    return $conn;
  }
?>
