<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$unique_number = $_SESSION['unique_number'];

// Fetch all users except the logged-in user
$users = $pdo->query("SELECT * FROM users WHERE id != $user_id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f0f2f5;
            color: #111b21;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00a884;
            padding: 15px;
            height: 60px;
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-right {
            display: flex;
            gap: 20px;
            color: white;
        }

        .header-right i {
            cursor: pointer;
            transition: color 0.3s;
        }

        .header-right i:hover {
            color: #e9edef;
        }

        .chat-container {
            display: flex;
            flex: 1;
            height: calc(100vh - 60px);
            background-color: white;
            box-shadow: -1px 0 15px rgba(0,0,0,0.1);
        }

        .contacts {
            width: 30%;
            background-color: white;
            border-right: 1px solid #e9edef;
            overflow-y: auto;
        }

        .search-container {
            padding: 10px;
            background-color: #f0f2f5;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            background-color: #f0f2f5;
            border: 1px solid #e9edef;
            border-radius: 8px;
            color: #111b21;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            border-color: #00a884;
        }

        .contact-list {
            list-style: none;
            padding: 0;
        }

        .contact-list li {
            display: flex;
            align-items: center;
            padding: 15px;
            cursor: pointer;
            border-bottom: 1px solid #e9edef;
            transition: background-color 0.3s;
        }

        .contact-list li:hover {
            background-color: #f5f6f6;
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            background-color: #dcf8c6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111b21;
            font-weight: 500;
        }

        .contact-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .contact-name {
            font-weight: 500;
        }

        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #e5ddd5;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" opacity="0.05"><pattern id="pattern" width="8" height="8" patternUnits="userSpaceOnUse"><rect width="4" height="4" x="0" y="0" fill="%23111b21"/><rect width="4" height="4" x="4" y="4" fill="%23111b21"/></pattern><rect width="100%" height="100%" fill="url(%23pattern)"/></svg>');
        }

        .chat-header {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #f0f2f5;
            border-bottom: 1px solid #e9edef;
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            background-color: #dcf8c6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111b21;
            font-weight: 500;
        }

        .chat-area {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .message {
            max-width: 70%;
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            clear: both;
            position: relative;
            word-wrap: break-word;
        }

        .sent {
            background-color: #dcf8c6;
            color: #111b21;
            float: right;
            clear: both;
            margin-left: auto;
        }

        .received {
            background-color: white;
            color: #111b21;
            float: left;
            clear: both;
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
        }

        .message small {
            display: block;
            font-size: 0.7em;
            margin-top: 5px;
            color: #667781;
            text-align: right;
        }

        .input-area {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: white;
            border-top: 1px solid #e9edef;
            gap: 10px;
        }

        .input-area input {
            flex: 1;
            padding: 10px;
            background-color: white;
            border: 1px solid #e9edef;
            border-radius: 8px;
            color: #111b21;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-area input:focus {
            border-color: #00a884;
        }

        .input-area button {
            background-color: #00a884;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-area button:hover {
            background-color: #02bf7d;
        }

        .empty-chat {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #667781;
        }

        /* Scrollbar customization */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f2f5;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c4c7;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <i class="fas fa-user-circle" style="font-size: 24px;"></i>
            <span>WhatsApp</span>
        </div>
        <div class="header-right">
            <i class="fas fa-search"></i>
            <i class="fas fa-ellipsis-v"></i>
        </div>
    </div>
    <div class="chat-container">
        <div class="contacts">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search contacts">
            </div>
            <ul class="contact-list">
                <?php foreach ($users as $user): ?>
                    <li>
                        <a href="chat.php?receiver_id=<?php echo $user['id']; ?>" style="display: contents;">
                            <div class="contact-avatar">
                                <?php echo strtoupper(substr($user['unique_number'], -2)); ?>
                            </div>
                            <div class="contact-info">
                                <span class="contact-name"><?php echo $user['unique_number']; ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if (isset($_GET['receiver_id'])): ?>
            <div class="chat-window">
                <div class="chat-header">
                    <div class="chat-header-avatar">
                        <?php 
                        $receiver_user = $pdo->query("SELECT * FROM users WHERE id = " . intval($_GET['receiver_id']))->fetch(); 
                        echo strtoupper(substr($receiver_user['unique_number'], -2)); 
                        ?>
                    </div>
                    <div class="contact-info">
                        <span class="contact-name"><?php echo $receiver_user['unique_number']; ?></span>
                    </div>
                </div>
                <div id="messages" class="chat-area"></div>
                <div class="input-area">
                    <input id="message" type="text" placeholder="Type a message...">
                    <button id="send">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="chat-window empty-chat">
                <div>
                    <i class="fas fa-comments fa-3x" style="color: #00a884; margin-bottom: 15px;"></i>
                    <h2>Start Messaging</h2>
                    <p>Select a contact to begin your conversation</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const receiverId = <?php echo isset($_GET['receiver_id']) ? $_GET['receiver_id'] : 'null'; ?>;
        const messagesDiv = document.getElementById('messages');
        const messageInput = document.getElementById('message');
        const sendButton = document.getElementById('send');

        // Fetch messages periodically
        function fetchMessages() {
            if (!receiverId) return;
            fetch('fetch_messages.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ receiver_id: receiverId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messagesDiv.innerHTML = data.messages.map(msg => `
                        <div class="message ${msg.sender_id == <?php echo $user_id; ?> ? 'sent' : 'received'}">
                            ${msg.message}
                            <small>${msg.created_at}</small>
                        </div>
                    `).join('');
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }
            });
        }

        // Send message
        sendButton.addEventListener('click', () => {
            const message = messageInput.value.trim();
            if (!message) return;

            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ receiver_id: receiverId, message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageInput.value = '';
                    fetchMessages();
                }
            });
        });

        // Allow sending message on Enter key
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendButton.click();
            }
        });

        // Poll messages every 2 seconds
        setInterval(fetchMessages, 2000);
        fetchMessages();
    </script>
</body>
</html>
