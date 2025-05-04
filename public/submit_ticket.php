<?php
require __DIR__ . '/../config.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// Basic validation
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
    http_response_code(400);
    echo 'Invalid input';
    exit;
}

// Insert ticket
$stmt = $db->prepare(
    'INSERT INTO tickets (name, email, message, status, created_at) VALUES (?, ?, ?, ? , NOW())'
);
$stmt->execute([$name, $email, $message, 'open']);

echo 'Ticket submitted successfully!';
