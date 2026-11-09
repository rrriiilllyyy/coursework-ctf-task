<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($password)) {
        $error = "Пароль не может быть пустым";
    } else {
        $username = str_replace("'", "\\'", $username);
        $password = str_replace("'", "\\'", $password);
        
        $db = getDB();
        
        $query = "SELECT * FROM users WHERE username = '$username'";

		file_put_contents('/tmp/sql_queries.log', 
		    date('Y-m-d H:i:s') . "\n" .
		    "Username: " . $_POST['username'] . "\n" .
		    "Password: " . $_POST['password'] . "\n" .
		    "Query: " . $query . "\n" .
		    "-----------------------------------\n", 
		    FILE_APPEND
		);
            $result = $db->query($query);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $user['username'] === 'admin') {
                if ($password === $user['password']) {
                    $_SESSION['user'] = $user['username'];
                    header('Location: admin.php');
                    exit();
                } else {
                    $error = "Неверный пароль";
                }
            } else {
                $error = "Пользователь не найден";
            }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход в систему</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 3px; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #45a049; }
        .error { color: red; margin: 10px 0; }
        .hint { color: #666; font-size: 0.9em; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Административная панель</h2>
        <p>Только для администраторов</p>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
        <div class="hint">
            <p><strong>Подсказка:</strong> Простые обходы больше не работают. Нужно узнать настоящий пароль администратора.</p>
            <p>Пароль хранится в базе данных и содержит флаг...</p>
        </div>
    </div>
</body>
</html>
