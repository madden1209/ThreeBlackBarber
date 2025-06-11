<?php
// Path for bookings JSON file
$bookingsFile = __DIR__ . '/bookings.json';

// Read bookings data
$bookings = [];
if (file_exists($bookingsFile)) {
  $json = file_get_contents($bookingsFile);
  $bookings = json_decode($json, true) ?? [];
}

// Sort bookings ascending by date-time
usort($bookings, function($a, $b) {
  return strtotime($a['dateTime']) - strtotime($b['dateTime']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barbershop Admin - Bookings</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet" />
</head>
<body>
  <header>
    <nav class="nav-container" role="navigation" aria-label="Primary navigation">
      <div class="logo" aria-label="Barbershop logo">Barbershop Admin</div>
      <ul class="nav-links" role="menubar" aria-label="Main menu">
        <li role="none"><a role="menuitem" href="index.html">Booking Page</a></li>
        <li role="none"><a role="menuitem" href="admin.php" class="active" aria-current="page">Admin</a></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1>Upcoming Bookings</h1>
    <?php if (count($bookings) === 0): ?>
      <p class="no-data">No bookings found.</p>
    <?php else: ?>
      <section aria-live="polite" aria-relevant="additions removals">
        <table>
          <thead>
            <tr>
              <th>Customer Name</th>
              <th>Service</th>
              <th>Barber</th>
              <th>Date &amp; Time</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($bookings as $b): ?>
              <tr tabindex="0" role="row" aria-label="Booking for <?=htmlspecialchars($b['customerName'])?>">
                <td><?=htmlspecialchars($b['customerName'])?></td>
                <td><?=htmlspecialchars($b['service'])?></td>
                <td><?=htmlspecialchars($b['barber'])?></td>
                <td><?=htmlspecialchars(date('D, j M Y, H:i', strtotime($b['dateTime'])))?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    <?php endif; ?>
  </main>
</body>
</html>
