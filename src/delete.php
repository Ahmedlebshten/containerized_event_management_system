<?php
require_once __DIR__ . '/connection.php';
session_start();

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    try {
        // Delete query using prepared statement
        $stmt = $connection->prepare("DELETE FROM events WHERE id = :id");
        $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: admin-panel.php");
            exit();
        } else {
            echo "Error deleting event.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid event ID.";
    exit();
}
?>
