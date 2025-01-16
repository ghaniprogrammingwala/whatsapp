<?php require 'db.php'; ?>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->execute([$name]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['unique_number'] = $user['unique_number'];
        header('Location: chat.php');
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #008069;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        .login-logo {
            width: 100px;
            margin-bottom: 20px;
            fill: #008069;
        }

        h2 {
            color: #008069;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .error-message {
            color: #ff5252;
            margin-bottom: 15px;
            font-size: 14px;
            opacity: 0.9;
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

        .signup-link {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .signup-link a {
            color: #008069;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .signup-link a:hover {
            color: #017361;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <svg class="login-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12.011 13.348l-3.643-3.642c-.175-.175-.175-.457 0-.632l1.27-1.27c.175-.175.457-.175.632 0l2.021 2.022 4.295-4.296c.175-.175.457-.175.632 0l1.27 1.27c.175.175.175.457 0 .632l-5.877 5.916z"/>
        </svg>
        <h2>Login to WhatsApp</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        
        <div class="signup-link">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
