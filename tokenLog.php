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
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./css/home.css">
  <link rel="icon" href="imgs/logo-ipower.png" type="image/x-icon">
</head>

<body>

  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
        <h4 id="userBlog">Cargando...</h4>
        <ul class="nav nav-pills nav-stacked">
          <?php if ($user['admin']) { ?>
            <div class="d-grid mt-2 w-100">
              <li><a href="home.php" class="btn btn-secondary rounded w-100 mb-2" role="button">Token de acceso</a>
              </li>
              <li><a href="adminUser.php" class="btn btn-secondary rounded w-100 mb-2" role="button">Administrar
                  usuarios</a></li>
              <li><a href="tokenLog.php" class="btn btn-secondary rounded w-100 mb-2" role="button">Bitácora de
                  tokens</a></li>
            </div>
          <?php } ?>
        </ul><br>
        <div class="mt-2 d-grid">
          <a href="./Backend/Files/logout.php" class="btn btn-lg btn-secondary" role="button" id="logout-btn">Cerrar
            Sesión</a>
        </div>
      </div>

      <div class="col-sm-9">
        <h2>Administrar Tokens</h2>
        <!-- Contenedor de buscador-->
        <div class="card-body ">
          <form id="search-form">
            <div class="row">
              <div class="col-12">
                <div class="row no-gutters">
                  <div class="col-lg-5 col-md-6 col-sm-12 p-0">
                    <input type="text" placeholder="Usuario" class="form-control" id="search" name="search">
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                    <input placeholder="Desde" type="text" class="form-control" id="dateInit" />
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                    <input placeholder="Hasta" type="text" class="form-control" id="dateEnd" />
                  </div>
                  <div class="col-lg-1 col-md-3 col-sm-12 p-0">
                    <button type="submit" id='btnUpdate' class="btn btn-light">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="table-responsive">
          <!-- Contenedor para la tabla de usuarios -->
          <table id="TokenTable" class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Token</th>
                <th>Fecha</th>
                <th>Hora</th>
              </tr>
            </thead>
            <tbody class="Token-table">
              <!-- Aquí se agregarán dinámicamente los usuarios -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



  <template id="DataToken">
    <!-- Plantilla para mostrar datos de usuario -->
    <tr>
      <th></th>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </template>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="./js/home.js"></script>
  <script src="./js/tokenLog.js"></script>


</body>

</html>