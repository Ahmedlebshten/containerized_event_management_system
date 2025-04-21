<?php
require_once __DIR__ . '/connection.php';
session_start();

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Fetch event data using PDO
    try {
        $stmt = $connection->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            echo "Event not found.";
            exit();
        }

        // Handle form submission for update
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $event_date = $_POST['event_date'] ?? '';

            // Update the event using prepared statement
            $update_stmt = $connection->prepare("UPDATE events SET title = :title, description = :description, event_date = :event_date WHERE id = :id");
            $update_stmt->bindParam(':title', $title);
            $update_stmt->bindParam(':description', $description);
            $update_stmt->bindParam(':event_date', $event_date);
            $update_stmt->bindParam(':id', $event_id, PDO::PARAM_INT);

            if ($update_stmt->execute()) {
                header("Location: admin-panel.php");
                exit();
            } else {
                echo "Error updating event.";
            }
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid event ID.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Update Event</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="events.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
