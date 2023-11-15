<?php
  session_start();

  // Elimina todas las variables de sesión
  $_SESSION = array();

  // Invalida la sesión
  session_destroy();

  // Redirige al usuario a la página de inicio de sesión
  header("Location: /SecureLogin/"); // Ajusta la ruta según tu estructura de archivos
  exit();
?>