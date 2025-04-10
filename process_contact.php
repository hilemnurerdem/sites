<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Veritabanı bağlantısı
        $db = new PDO("mysql:host=localhost;dbname=portfolio_messages", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Form verilerini al
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
        
        // Verileri veritabanına kaydet
        $stmt = $db->prepare("INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $message]);
        
        // Başarılı yanıt
        $response = [
            'status' => 'success',
            'message' => 'Mesajınız başarıyla gönderildi.'
        ];
    } catch (PDOException $e) {
        // Hata durumunda
        $response = [
            'status' => 'error',
            'message' => 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'
        ];
    }
    
    // JSON yanıtı gönder
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} 