<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver') {
    header("Location: login.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $type = $_POST['type'];
    $table = $type === 'ride' ? 'rides' : 'deliveries';
    $stmt = $pdo->prepare("UPDATE $table SET driver_id = :driver_id, status = 'accepted' WHERE id = :id");
    $stmt->execute(['driver_id' => $_SESSION['user_id'], 'id' => $booking_id]);
    header("Location: driver.php");
}
$stmt_rides = $pdo->query("SELECT * FROM rides WHERE status = 'pending'");
$stmt_deliveries = $pdo->query("SELECT * FROM deliveries WHERE status = 'pending'");
$rides = $stmt_rides->fetchAll();
$deliveries = $stmt_deliveries->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - Yango Clone</title>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .dashboard {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 600px;
            animation: slideIn 1s ease;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .request {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            margin-bottom: 10px;
        }
        .btn {
            background: #2a5298;
            color: #fff;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #1e3c72;
        }
        @keyframes slideIn {
            0% { transform: translateY(-50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @media (max-width: 480px) {
            .dashboard {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Driver Dashboard</h2>
        <h3>Pending Rides</h3>
        <?php foreach ($rides as $ride) { ?>
            <div class="request">
                <p>Pickup: <?php echo $ride['pickup_location']; ?></p>
                <p>Drop-off: <?php echo $ride['dropoff_location']; ?></p>
                <p>Fare: $<?php echo $ride['fare']; ?></p>
                <form method="POST">
                    <input type="hidden" name="booking_id" value="<?php echo $ride['id']; ?>">
                    <input type="hidden" name="type" value="ride">
                    <button type="submit" class="btn">Accept Ride</button>
                </form>
            </div>
        <?php } ?>
        <h3>Pending Deliveries</h3>
        <?php foreach ($deliveries as $delivery) { ?>
            <div class="request">
                <p>Pickup: <?php echo $delivery['pickup_location']; ?></p>
                <p>Drop-off: <?php echo $delivery['dropoff_location']; ?></p>
                <p>Package: <?php echo $delivery['package_details']; ?></p>
                <p>Fare: $<?php echo $delivery['fare']; ?></p>
                <form method="POST">
                    <input type="hidden" name="booking_id" value="<?php echo $delivery['id']; ?>">
                    <input type="hidden" name="type" value="delivery">
                    <button type="submit" class="btn">Accept Delivery</button>
                </form>
            </div>
        <?php } ?>
        <button class="btn" onclick="redirect('index.php')">Back to Home</button>
    </div>
    <script>
        function redirect(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
