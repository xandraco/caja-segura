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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/66909aad39.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="./css/home.css">
</head>

<body>

  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
        <h4 id="userBlog">Cargando...</h4>
        <ul class="nav nav-pills nav-stacked">
          <?php if ($user['admin']) { ?>
            <div class="d-grid mt-2 w-100">
              <li><a href="home.php" class="btn btn-secondary rounded-pill w-100 mb-2" role="button">Token de acceso</a></li>
              <li><a href="adminUser.php" class="btn btn-secondary rounded-pill w-100 mb-2" role="button">Administrar usuarios</a></li>
              <li><a href="tokenLog.php" class="btn btn-secondary rounded-pill w-100 mb-2" role="button">Bitácora de tokens</a></li>
            </div>
          <?php } ?>
        </ul><br>
        <div class="mt-2 d-grid">
          <a href="./Backend/Files/logout.php" class="btn btn-lg btn-secondary" role="button" id="logout-btn">Cerrar Sesión</a>
        </div>  
      </div>

      <div class="col-sm-9">
        <!-- Contenedor para la tabla de usuarios -->
        <h2>Administrar Usuarios</h2>
        <table id="TablaUsuarios" class="table">
          <thead>
            <tr>
              <th>ID Token</th>
              <th>Persona que lo uso</th>
              <th>token</th>
              <th>Privilegios</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="user-table">
            <!-- Aquí se agregarán dinámicamente los usuarios -->
          </tbody>
        </table>
        <button type="submit" id='btnAdd' class="btn btn-primary" class="AddUsuarioBtn" data-bs-toggle="modal" data-bs-target="#AddUsuarioModal">Agregar Usuario</button>
      </div>
    </div>

    <!-- Modal Editar usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" role="dialog"
      aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #484848!important;">
            <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="background-color: #32352E!important;">
            <!-- Formulario para editar usuario -->
            <form id="editarUsuarioForm">
              <input type="hidden" id="idUsuarioUpdate" name="idUsuario" value="">
              <div class="form-group">
                <label for="nombreUsuario">Nombre de usuario</label>
                <input type="text" class="form-control" id="userUpdate"
                  placeholder="Nombre de usuario (Dejar en blanco para no cambiar)">
              </div>
              <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="passwordUpdate"
                  placeholder="Contraseña (Dejar en blanco para no cambiar)">
              </div>
              <div class="form-group">
                <label>Privilegios:</label>
                <div class="radio">
                  <label><input type="radio" name="admin" value="1">Admin</label>
                </div>
                <div class="radio">
                  <label><input type="radio" id="adminUpdateFalse" name="admin" value="0" checked>Usuario</label>
                </div>
              </div>
              <button type="submit" id='btnUpdate' class="btn btn-primary">Guardar cambios</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal Agregar usuario -->
    <div class="modal fade" id="AddUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="AgregarUsuarioModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #484848!important;">
          <h5 class="modal-title" id="AddUsuarioModalLabel">Agregar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="background-color: #32312e!important;">
            <!-- Formulario para Agregar usuario -->
            <form id="AddUsuarioForm">
              <div class="form-group">
                <label for="EmailUsuario">Email</label>
                <input type="text" class="form-control" id="EmailAdd"
                  placeholder="Email">
              </div>
              <div class="form-group">
                <label for="nombreUsuario">Nombre de usuario</label>
                <input type="text" class="form-control" id="userAdd"
                  placeholder="Nombre de usuario">
              </div>
              <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="passwordAdd"
                  placeholder="Contraseña">
              </div>
              <div class="form-group">
                <label>Privilegios:</label>
                <div class="radio">
                  <label><input type="radio" name="admin" value="1">Admin</label>
                </div>
                <div class="radio">
                  <label><input type="radio" id="adminAddFalse" name="admin" value="0" checked>Usuario</label>
                </div>
              </div>
              <button type="submit" id='btnAddUser' class="btn btn-primary">Guardar cambios</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="container-fluid">
      <p>Footer Text</p>
    </footer>

  </div>



  <template id="DataUsers">
    <!-- Plantilla para mostrar datos de usuario -->
    <tr>
      <th></th>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <!-- Botones para editar y borrar -->
        <a href="" class="editarUsuarioBtn btn btn-success admin-buttons fa-solid fa-pencil" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
          data-user-id="" role="button">
        </a>
        <a href="" class="btn btn-danger admin-buttons fa-solid fa-trash" role="button">
        </a>
      </td>
    </tr>
  </template>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="./js/home.js"></script>
  <script src="./js/adminUsers.js"></script>


</body>

</html>