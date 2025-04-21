<?php
require_once __DIR__ . '/connection.php';
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            // Prepare the SQL statement using PDO
            $stmt = $connection->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_admin'] = $user['is_admin'];

                if ($user['is_admin'] == 1) {
                    header("Location: admin-panel.php");
                } else {
                    header("Location: events.php");
                }
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    } else {
        $error_message = "Please fill in both fields.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <style>
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            margin: auto;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1rem;
        }

        button {
            padding: 10px;
            font-size: 1rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>

        <!-- Display error message if any -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>