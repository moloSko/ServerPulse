<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'DataBase/db.php'; // Подключаем базу данных

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Проверяем пользователя в базе данных
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        header('Location: index.php');
        exit();
    } else {
        $error = "Неверный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h2 class="active">Вход</h2>
            <h2 class="inactive underlineHover"><a href="register.php">Регистрация</a></h2>

            <form method="POST">
                <input type="text" id="username" class="fadeIn second" name="username" placeholder="Логин">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Пароль">
                <input type="submit" class="fadeIn fourth" value="Войти">
            </form>

            <div id="formFooter">
                <a class="underlineHover" href="#">Забыли пароль?</a>
            </div>
        </div>
    </div>
</body>
</html>