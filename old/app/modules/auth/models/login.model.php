<?php
require_once '../../config/db.php';

function getUserByUsername($username) {
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
