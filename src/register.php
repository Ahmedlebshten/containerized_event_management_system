<?php
require_once __DIR__ . '/connection.php';

$registrationSuccess = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get raw input
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Trim input
    $username = trim($username);
    $email = trim($email);

    // Validate fields
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        try {
            // Check if username or email exists
            $stmt_check = $connection->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $stmt_check->bindParam(':username', $username);
            $stmt_check->bindParam(':email', $email);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                $error_message = "Username or email already exists.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user
                $stmt_insert = $connection->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
                $stmt_insert->bindParam(':username', $username);
                $stmt_insert->bindParam(':password', $hashed_password);
                $stmt_insert->bindParam(':email', $email);

                if ($stmt_insert->execute()) {
                    $registrationSuccess = true;
                } else {
                    $error_message = "Failed to register user.";
                }
            }

        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
    <style>
        .message {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

         a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Register</h2>

        <?php if ($registrationSuccess): ?>
            <div class="message success-message">
                Account created successfully! <a href="login.php">Login here</a>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="message error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>