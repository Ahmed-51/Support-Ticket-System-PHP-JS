<?php
require __DIR__ . '/../config.php';

// Ensure ID and status are provided
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$current = isset($_POST['status']) ? $_POST['status'] : '';

// Toggle logic: open -> closed, other -> open
$newStatus = ($current === 'open') ? 'closed' : 'open';

// Update the ticket status
$stmt = $db->prepare('UPDATE tickets SET status = ? WHERE id = ?');
$stmt->execute([$newStatus, $id]);

echo 'OK';