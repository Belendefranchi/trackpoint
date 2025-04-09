<?php
session_start();

// Obtener los parámetros de URL
$module = $_GET['module'] ?? '';
$page = $_GET['page'] ?? '';

// Rutas públicas que no necesitan login
$rutasPublicas = [
  'auth/views/login',
  'auth/views/register'
];

// Combinar ruta actual
$rutaActual = "$module/$page";

// Si el usuario no está logueado y no está en una ruta pública → redirigir
if (!in_array($rutaActual, $rutasPublicas) && !isset($_SESSION['user'])) {
  header('Location: index.php?module=auth&page=login');
  exit;
}

// Si el usuario ya está logueado y va al login o registro, redirigir al inicio
if (isset($_SESSION['user']) && in_array($rutaActual, $rutasPublicas)) {
  require_once "../app/templates/welcome.php";
  exit;
}

