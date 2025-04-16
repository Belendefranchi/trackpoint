<?php
session_start();
if (!isset($_SESSION['id'])) {
  header('Location: /trackpoint/public/login');
  exit();
}
?>

