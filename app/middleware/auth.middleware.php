<?php
session_start();
if (isset($_SESSION['id'])) {
  if(($_SESSION['rol']) == 'admin'){
    // Si el usuario está autenticado pero no tiene rol, lo redirigimos al home
    header('Location: /trackpoint/public/home');
    exit();
  }
/*   // Si el usuario no está autenticado, redirigimos al login
  header('Location: /trackpoint/public/login');
  exit(); */
}

