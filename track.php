<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$type = $_GET['type'] ?? 'ride';
$table = $type === 'ride' ? 'rides' : 'deliveries';
$stmt = $pdo->prepare("SELECT * FROM $table WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$booking = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track <?php echo ucfirst($type); ?> - Yango Clone</title>
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
        .track-container {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 500px;
            animation: slideIn 1s ease;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .map-placeholder {
            width: 100%;
            height: 300px;
            background: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .status {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .btn {
            background: #2a5298;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
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
            .track-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="track-container">
        <h2>Track Your <?php echo ucfirst($type); ?></h2>
        <div class="map-placeholder">Map Placeholder (Integrate Google Maps API)</div>
        <p class="status">Status: <?php echo $booking['status'] ?? 'Pending'; ?></p>
        <p>Pickup: <?php echo $booking['pickup_location'] ?? 'N/A'; ?></p>
        <p>Drop-off: <?php echo $booking['dropoff_location'] ?? 'N/A'; ?></p>
        <?php if ($type === 'delivery') { ?>
            <p>Package Details: <?php echo $booking['package_details'] ?? 'N/A'; ?></p>
        <?php } ?>
        <p>Fare: $<?php echo $booking['fare'] ?? '0.00'; ?></p>
        <button class="btn" onclick="redirect('index.php')">Back to Home</button>
    </div>
    <script>
        function redirect(page) {
            window.location.href = page;
        }
        // Simulate real-time status update
        setInterval(() => {
            document.querySelector('.status').innerText = 
                `Status: ${Math.random() > 0.5 ? 'In Progress' : 'Completed'}`;
        }, 5000);
    </script>
</body>
</html>
