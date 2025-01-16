<?php require 'db.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Generate unique number
    $stmt = $pdo->query("SELECT COUNT(*) AS count FROM users");
    $row = $stmt->fetch();
    $unique_number = "+786-1001-" . str_pad($row['count'] + 1, 4, '0', STR_PAD_LEFT);
    $sql = "INSERT INTO users (name, password, unique_number) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $password, $unique_number]);
    header('Location: index.php?signup=success');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #008069;
        }

        .signup-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
            text-align: center;
        }

        .signup-logo {
            width: 100px;
            margin-bottom: 20px;
            fill: #008069;
        }

        h2 {
            color: #008069;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .input-group {
            margin-bottom: 15px;
            position: relative;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus {
            border-color: #008069;
            box-shadow: 0 0 0 2px rgba(0, 128, 105, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #008069;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #017361;
        }

        button:active {
            transform: scale(0.98);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .signup-container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <svg class="signup-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12.011 13.348l-3.643-3.642c-.175-.175-.175-.457 0-.632l1.27-1.27c.175-.175.457-.175.632 0l2.021 2.022 4.295-4.296c.175-.175.457-.175.632 0l1.27 1.27c.175.175.175.457 0 .632l-5.877 5.916z"/>
        </svg>
        <h2>Create Your Account</h2>
        <form method="POST" action="signup.php">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
