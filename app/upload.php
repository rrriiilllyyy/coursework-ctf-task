<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_url'])) {
    $url = $_POST['image_url'];
    $title = $_POST['title'] ?? 'Без названия';
    
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS | CURLPROTO_FILE);
        
        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        
        if ($content !== false && $httpCode == 200) {
            $filename = uniqid() . '_' . basename(parse_url($url, PHP_URL_PATH));
            if (empty($filename) || $filename == '_') {
                $filename = uniqid() . '_download.dat';
            }
            
            $filepath = 'uploads/' . $filename;
            
            file_put_contents($filepath, $content);
            
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO gallery (filename, uploaded_by, upload_date) VALUES (?, ?, NOW())");
            $stmt->execute([$filename, $_SESSION['user']]);
            
            $message = "Файл успешно загружен! <a href='uploads/$filename'>Просмотреть</a>";
        } else {
            $message = "Ошибка загрузки: HTTP $httpCode";
            if ($content) {
                $message .= "<br>Ответ: " . htmlspecialchars(substr($content, 0, 500));
            }
        }
        
        curl_close($ch);
    } else {
        $message = "Неверный URL формат";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Результат загрузки</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .message { background: #e7f3ff; padding: 20px; border-radius: 5px; margin: 20px 0; }
        a { color: #4CAF50; }
    </style>
</head>
<body>
    <div class="message">
        <?php echo $message; ?>
    </div>
    <p><a href="admin.php">Вернуться в админ-панель</a></p>
</body>
</html>
