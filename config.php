<?php
// config.php
// Update credentials as needed
$db = new PDO(
    'mysql:host=localhost;dbname=support;charset=utf8mb4',
    'root',
    'admin',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
