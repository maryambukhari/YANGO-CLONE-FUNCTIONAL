<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pickup = filter_input(INPUT_POST, 'pickup', FILTER_SANITIZE_STRING);
        $dropoff = filter_input(INPUT_POST, 'dropoff', FILTER_SANITIZE_STRING);
        $package_details = filter_input(INPUT_POST, 'package_details', FILTER_SANITIZE_STRING);
        $fare = rand(5, 30); // Simulated fare calculation
        $user_id = $_SESSION['user_id'];

        // Insert delivery into database
        $stmt = $pdo->prepare("INSERT INTO deliveries (user_id, pickup_location, dropoff_location, package_details, fare) 
                               VALUES (:user_id, :pickup, :dropoff, :package_details, :fare)");
        $stmt->execute([
            'user_id' => $user_id,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'package_details' => $package_details,
            'fare' => $fare
        ]);

        // Simulate driver assignment (replace with real logic in production)
        $driver_id = 1; // Simulated driver ID
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, driver_id, message, type) 
                               VALUES (:user_id, :driver_id, :message, 'delivery')");
        $stmt->execute([
            'user_id' => $user_id,
            'driver_id' => $driver_id,
            'message' => 'Delivery booked successfully!'
        ]);

        // Redirect to tracking page
        header("Location: track.php?type=delivery");
        exit();
    } catch (Exception $e) {
        // Log error and display user-friendly message
        error_log("Error in delivery.php: " . $e->getMessage());
        die("An error occurred while booking your delivery. Please try again later.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Delivery - Yango Clone</title>
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
        .form-container {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 400px;
            animation: slideIn 1s ease;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        .error {
            color: red;
            text-align: center;
        }
        @keyframes slideIn {
            0% { transform: translateY(-50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @media (max-width: 480px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Book a Delivery</h2>
        <form method="POST" action="">
            <label for="pickup">Pickup Location</label>
            <input type="text" id="pickup" name="pickup" required>
            <label for="dropoff">Drop-off Location</label>
            <input type="text" id="dropoff" name="dropoff" required>
            <label for="package_details">Package Details</label>
            <textarea id="package_details" name="package_details" required></textarea>
            <button type="submit" class="btn">Book Delivery</button>
        </form>
        <p><a href="javascript:void(0)" onclick="redirect('index.php')">Back to Home</a></p>
    </div>
    <script>
        function redirect(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
