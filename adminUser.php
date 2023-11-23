<?php
session_start();

// Verifica si no hay una sesión activa
if (!isset($_SESSION['usuario'])) {
  header('Location: /'); // Cambia la ruta según tu estructura de archivos
  exit();
}

$user = $_SESSION['usuario'];

if ($user['admin'] == 0) {
  header('Location: /home.php'); // Cambia la ruta según tu estructura de archivos
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

      <div class="col-sm-9">
        <!-- Contenedor para la tabla de usuarios -->
        <h2>Administrar Usuarios</h2>
        <table id="TablaUsuarios">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Privilegios</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="user-table">
            <!-- Aquí se agregarán dinámicamente los usuarios -->
          </tbody>
        </table>
      </div>
    </div>

    <footer class="container-fluid">
      <p>Footer Text</p>
    </footer>

    <template id="DataUsers">
      <!-- Plantilla para mostrar datos de usuario -->
      <tr>
        <th></th>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <!-- Botones para editar y borrar -->
          <a href="">Editar</a>
          <a href="">Borrar</a>
        </td>
      </tr>
    </template>

    <script src="./js/home.js"></script>
    <script src="./js/adminUsers.js"></script>
  </div>
</body>

</html>