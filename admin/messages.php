<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Veritabanı bağlantısı
$db = new PDO("mysql:host=localhost;dbname=portfolio_messages", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Mesajları getir
$query = $db->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlar</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .messages-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 2rem;
        }
        .message-card {
            background: white;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }
        .message-date {
            color: #666;
            font-size: 0.9rem;
        }
        .message-content {
            color: #333;
            line-height: 1.6;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            float: right;
            margin-bottom: 1rem;
        }
        .no-messages {
            text-align: center;
            padding: 2rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="messages-container">
        <a href="logout.php" class="logout-btn">Çıkış Yap</a>
        <h2 style="margin-bottom: 2rem;">Gelen Mesajlar</h2>
        
        <?php if(empty($messages)): ?>
            <div class="no-messages">
                <p>Henüz mesaj bulunmuyor.</p>
            </div>
        <?php else: ?>
            <?php foreach($messages as $message): ?>
                <div class="message-card">
                    <div class="message-header">
                        <div>
                            <strong><?php echo htmlspecialchars($message['name']); ?></strong>
                            <span style="margin-left: 1rem;"><?php echo htmlspecialchars($message['email']); ?></span>
                        </div>
                        <div class="message-date">
                            <?php echo date('d.m.Y H:i', strtotime($message['created_at'])); ?>
                        </div>
                    </div>
                    <div class="message-content">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html> 