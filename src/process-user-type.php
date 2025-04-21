<?php
session_start();
require_once __DIR__ . '/connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: try-again.html");
        exit();
    }

    if ($user_type === 'user' || $user_type === 'admin') {
        $is_admin = $user_type === 'admin' ? 1 : 0;

        try {
            $stmt = $connection->prepare("SELECT * FROM users WHERE email = :email AND is_admin = :admin");
            $stmt->execute([
                ':email' => $email,
                ':admin' => $is_admin
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($is_admin) {
                    header("Location: admin-panel.php");
                } else {
                    header("Location: home.html");
                }
                exit();
            } else {
                header("Location: try-again.html");
                exit();
            }

        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            exit();
        }
    } else {
        header("Location: try-again.html");
        exit();
    }
} else {
    header("Location: try-again.html");
   exit();
}
