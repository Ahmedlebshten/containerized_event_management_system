<?php
require_once __DIR__ . '/connection.php';
session_start();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $event_date = $_POST['event_date'] ?? '';

    try {
        // Prepare the insert query using PDO
        $stmt = $connection->prepare("INSERT INTO events (title, description, event_date) VALUES (:title, :description, :event_date)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':event_date', $event_date);

        if ($stmt->execute()) {
            // Redirect to the events page after successful insertion
            header("Location: admin-panel.php");
            exit();
        } else {
            echo "Error creating event.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Create New Event</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create Event</button>
        <a href="events.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
