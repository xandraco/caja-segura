<?php
session_start();

// Verifica si no hay una sesión activa
if (!isset($_SESSION['usuario'])) {
  header('Location: /'); // Cambia la ruta según tu estructura de archivos
  exit();
}
$user = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>IPower Token</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./css/home.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
        <h4 id="userBlog">Cargando...</h4>
        <ul class="nav nav-pills nav-stacked">
          <?php if ($user['admin']) { ?>
            <li><a href="home.php">Token de acceso</a></li>
            <li><a href="adminUser.php">Administrar usuarios</a></li>
            <li><a href="tokenLog.php">Bitácora de tokens</a></li>
          <?php } ?>
        </ul><br>
        <div class="m-2">
          <a href="./Backend/Files/logout.php">Cerrar Sesión</a>
        </div>
      </div>

      <div class="col-sm-9 text-center">
        <h3>Token de la caja</h3>
        <h4><span id="tokenDisplay"></span></h4>
        <h4><span id="counter"></span></h4>
        <div class="progress">
          <div 
            id="timeBar"
            class="progress-bar" 
            role="progressbar" 
            aria-valuenow="100" 
            aria-valuemin="0" 
            aria-valuemax="100"
            aria-value-now = "50"
          ></div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./js/home.js"></script>
    <script src="./js/showToken.js"></script>
</body>

</html>
