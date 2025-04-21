<?php

session_start();
require_once __DIR__ . '/connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
  header("Location: login.php");
  exit;
}

try {
  // Fetch admin info
  $stmtAdmin = $connection->prepare("SELECT * FROM users WHERE is_admin = 1 LIMIT 1");
  $stmtAdmin->execute();
  $admin_info = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

  // Fetch events
  $stmtEvents = $connection->prepare("SELECT * FROM events");
  $stmtEvents->execute();
  $events = $stmtEvents->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  // Handle DB errors
  echo "Database error: " . $e->getMessage();
  exit;
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <div class="container">
    <!-- Admin Info Section -->
    <?php if ($admin_info): ?>
      <div class="alert alert-info mt-3">
        <h4>Admin Information</h4>
        <p><strong>Name:</strong> <?= htmlspecialchars($admin_info['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($admin_info['email']) ?></p>
      </div>
    <?php else: ?>
      <div class="alert alert-warning mt-3">
        <p>No admin found.</p>
      </div>
    <?php endif; ?>

    <!-- Events Section -->
    <h3 class="mt-4">Upcoming Events</h3>
    <a href="create.php" class="btn btn-success mb-3">Create New Event</a>

    <?php if (count($events) > 0): ?>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Event Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $event): ?>
            <tr>
              <td><?= htmlspecialchars($event['id']) ?></td>
              <td><?= htmlspecialchars($event['title']) ?></td>
              <td><?= htmlspecialchars($event['description']) ?></td>
              <td><?= htmlspecialchars($event['event_date']) ?></td>
              <td>
                <a href="update.php?id=<?= urlencode($event['id']) ?>" class="btn btn-primary">Edit</a>
                <a href="delete.php?id=<?= urlencode($event['id']) ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
     <a style="text-decoration:none" href="logout.php">Logout</a>
    <?php else: ?>
      <div class="alert alert-info">
        <p>No events available.</p>
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>