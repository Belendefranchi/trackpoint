<?php
/* require_once "../app/middleware/auth.middleware.php"; */


$module = $_GET['module'] ?? null;
$page = $_GET['page'] ?? null;

/* ob_start(); */

$viewPath = null;
if ($module && $page) {
    $viewPath = "../app/modules/$module/views/{$page}.view.php";
}

/* $content = ob_get_clean(); */
require_once "../app/templates/welcome.php";


