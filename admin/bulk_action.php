<?php
require __DIR__.'/../config.php';
$action = $_POST['action'] ?? '';
$ids    = $_POST['ids']    ?? [];

if (!in_array($action,['close','delete']) || !is_array($ids) || empty($ids)) {
  header('Location: index.php'); exit;
}

// Build placeholders
$placeholders = implode(',', array_fill(0, count($ids), '?'));

if ($action==='close') {
  $sql = "UPDATE tickets SET status='closed' WHERE id IN ($placeholders)";
} else {
  $sql = "DELETE FROM tickets WHERE id IN ($placeholders)";
}

$stmt = $db->prepare($sql);
$stmt->execute($ids);

header('Location: index.php');
exit;
