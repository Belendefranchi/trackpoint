<?php
session_start();
session_destroy();
header('Location: index.php?module=auth&page=login');
exit;
