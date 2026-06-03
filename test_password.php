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

    if ($users) {
        $user_db = $users[0];
        $stored_hash = $user_db['userpassword'];

        echo "Testing password verification...\n";
        echo "Stored hash: " . $stored_hash . "\n\n";

        // Test beberapa password umum
        $passwords_to_test = ['admin', 'admin123', 'password', '123456', 'admin@123'];

        foreach ($passwords_to_test as $pwd) {
            $is_valid = password_verify($pwd, $stored_hash);
            echo "Password: '$pwd' => " . ($is_valid ? "VALID ✓" : "INVALID ✗") . "\n";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
