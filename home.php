<?php
  session_start();

  // Verifica si no hay una sesión activa
  if (!isset($_SESSION['usuario'])) {
    header('Location: /'); // Cambia la ruta según tu estructura de archivos
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>IPower Token</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
        <li class="active"><a href="#section1">Home</a></li>
        <li><a href="#section2">Friends</a></li>
        <li><a href="#section3">Family</a></li>
        <li><a href="#section3">Photos</a></li>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>

    <div class="col-sm-9">
      <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Token</div>
        <div class="card-body">
          <h5 class="card-title"><span id="counter"></span></h5>
          <p class="card-text"><span id="tokenDisplay"></span></p>
        </div>
      </div><div class="m-2">
      <a href="/logout.php">Cerrar Sesión</a>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>

<script src="./js/home.js"></script>

</body>
</html>