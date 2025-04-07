<?php
$ciclo = $_GET['ciclo'] ?? null;
$module = $_GET['module'] ?? null;
$page = $_GET['page'] ?? null;

$viewPath = null;
if ($ciclo && $module && $page) {
    $viewPath = "../app/modules/$ciclo/$module/views/{$page}.view.php";
}

require_once "../app/templates/welcome.php";
