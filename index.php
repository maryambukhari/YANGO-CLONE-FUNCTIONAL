<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yango Clone - Ride & Delivery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        header {
            width: 100%;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            text-align: center;
        }
        header h1 {
            font-size: 2.5em;
            animation: fadeIn 2s ease-in-out;
        }
        .container {
            display: flex;
            justify-content: space-around;
            width: 80%;
            margin-top: 50px;
        }
        .card {
            background: #fff;
            color: #333;
            padding: 20px;
            border-radius: 10px;
            width: 45%;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h2 {
            font-size: 1.8em;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        .btn {
            background: #2a5298;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #1e3c72;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 90%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Yango Clone</h1>
    </header>
    <div class="container">
        <div class="card">
            <h2>Ride-Hailing</h2>
            <p>Book a ride to your destination with ease and track your driver in real-time.</p>
            <a href="javascript:void(0)" onclick="redirect('ride.php')" class="btn">Book a Ride</a>
        </div>
        <div class="card">
            <h2>Parcel Delivery</h2>
            <p>Send packages quickly and reliably with our delivery service.</p>
            <a href="javascript:void(0)" onclick="redirect('delivery.php')" class="btn">Send a Package</a>
        </div>
    </div>
    <script>
        function redirect(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
