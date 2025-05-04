<?php
require __DIR__ . '/../config.php';

// Validate
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
  http_response_code(400);
  echo 'Invalid ID';
  exit;
}

// Delete
$stmt = $db->prepare('DELETE FROM tickets WHERE id = ?');
$stmt->execute([$id]);

echo 'OK';
