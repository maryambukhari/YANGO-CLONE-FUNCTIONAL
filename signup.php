<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $vehicle_type = $_POST['vehicle_type'] ?? null;
    $license_plate = $_POST['license_plate'] ?? null;

    $table = $role === 'driver' ? 'drivers' : 'users';
    $sql = "INSERT INTO $table (name, email, password, phone" . ($role === 'driver' ? ", vehicle_type, license_plate" : "") . ") 
            VALUES (:name, :email, :password, :phone" . ($role === 'driver' ? ", :vehicle_type, :license_plate" : "") . ")";
    $stmt = $pdo->prepare($sql);
    $params = ['name' => $name, 'email' => $email, 'password' => $password, 'phone' => $phone];
    if ($role === 'driver') {
        $params['vehicle_type'] = $vehicle_type;
        $params['license_plate'] = $license_plate;
    }
    $stmt->execute($params);
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Yango Clone</title>
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
        input, select {
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
        .driver-fields {
            display: none;
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
        <h2>Sign Up</h2>
        <form method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" required>
            <label for="role">Role</label>
            <select id="role" name="role" onchange="toggleDriverFields()">
                <option value="user">User</option>
                <option value="driver">Driver</option>
            </select>
            <div class="driver-fields" id="driverFields">
                <label for="vehicle_type">Vehicle Type</label>
                <input type="text" id="vehicle_type" name="vehicle_type">
                <label for="license_plate">License Plate</label>
                <input type="text" id="license_plate" name="license_plate">
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="javascript:void(0)" onclick="redirect('login.php')">Login</a></p>
    </div>
    <script>
        function toggleDriverFields() {
            const role = document.getElementById('role').value;
            document.getElementById('driverFields').style.display = role === 'driver' ? 'block' : 'none';
        }
        function redirect(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
