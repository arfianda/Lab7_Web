<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'portal_berita';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT id, username, useremail, userpassword FROM user');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Data User di Database:\n";
    echo str_repeat("=", 80) . "\n";
    foreach ($users as $user) {
        echo "ID: " . $user['id'] . "\n";
        echo "Username: " . $user['username'] . "\n";
        echo "Email: " . $user['useremail'] . "\n";
        echo "Password (first 50 chars): " . substr($user['userpassword'], 0, 50) . "\n";
        echo "Password length: " . strlen($user['userpassword']) . "\n";
        echo "---\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
