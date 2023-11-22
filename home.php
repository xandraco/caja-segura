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
          <?php if ($user['admin']) { ?>
            <li><a href="#" onclick="changeContent('showToken')">Token de acceso</a></li>
            <li><a href="#" onclick="changeContent('showAdminUser')">Administrar usuarios</a></li>
            <li><a href="#" onclick="changeContent('showTokenLog')">Bitácora de tokens</a></li>
          <?php } ?>
        </ul><br>
        <div class="m-2">
          <a href="./Backend/Files/logout.php">Cerrar Sesión</a>
        </div>
      </div>

      <div class="col-sm-9">
        <!-- Contenido principal -->
        <div id="mainContent">
          <?php include './components/showToken.php'; ?> <!-- Componente predeterminado -->
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