<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Админ панель</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .upload-form { border: 1px solid #ccc; padding: 20px; margin: 20px 0; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .result { margin-top: 20px; padding: 10px; background: #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Админ панель</h1>
        <p>Добро пожаловать, admin!</p>
        
        <div class="upload-form">
            <h2>Загрузка изображений по URL</h2>
            <form action="upload.php" method="POST">
                <label>URL изображения:</label>
                <input type="text" name="image_url" placeholder="https://example.com/image.jpg" required>
                <label>Название:</label>
                <input type="text" name="title" placeholder="Название изображения">
                <button type="submit">Загрузить</button>
            </form>
            <p><small>Поддерживаются только изображения с удаленных серверов</small></p>
        </div>
        
        <div class="gallery">
            <h2>Галерея</h2>
            <?php include 'gallery.php'; ?>
        </div>
        
        <p><a href="logout.php">Выйти</a></p>
    </div>
</body>
</html>
