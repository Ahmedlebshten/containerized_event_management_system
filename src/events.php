<?php
session_start();
require_once __DIR__ . '/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

try {
    $stmt = $connection->query("SELECT * FROM events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

  <div class="container">
    <h3>Upcoming Events </h3>
    <table class="table">
     <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Event Date</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($events as $event): ?>
    <tr>
        <td><?php echo htmlspecialchars($event['id']); ?></td>
        <td><?php echo htmlspecialchars($event['title']); ?></td>
        <td><?php echo htmlspecialchars($event['description']); ?></td> 
        <td><?php echo htmlspecialchars($event['event_date']); ?></td>
    </tr>
    <?php endforeach; ?>

    </tbody>
  </table>
  <a style="text-decoration:none" href="logout.php">Logout</a>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>