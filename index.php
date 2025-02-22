<?php
require 'DataBase/db.php';
require 'server_query.php';

session_start();

$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['ip'], $_POST['port'])) {
        $name = trim($_POST['name']);
        $ip = trim($_POST['ip']);
        $port = (int)$_POST['port'];

        if (filter_var($ip, FILTER_VALIDATE_IP) && $port > 0 && $port <= 65535) {
            $stmt = $pdo->prepare('INSERT INTO servers (name, ip, port) VALUES (?, ?, ?)');
            $stmt->execute([$name, $ip, $port]);
            header('Location: index.php');
            exit();
        } else {
            die('Invalid IP or port.');
        }
    }
}

$stmt = $pdo->query('SELECT * FROM servers');
$servers = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Pulse</title>
    <link rel="icon" type="image/png" href="Assets/ico/icon_serverpulse.png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Иконки -->
</head>
<body>
    <!-- Навигационная панель -->
    <nav class="navbar">
        <div class="navbar-left">
            <a href="#" class="nav-item">
                <i class="fas fa-home"></i> Главная
            </a>
            <div class="dropdown">
                <a href="#" class="nav-item">
                    <i class="fas fa-gamepad"></i> Игры <i class="fas fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="#arma3">Arma 3</a>
                    <a href="#arma-reforger">Arma Reforger</a>
                    <a href="#rust">Rust</a>
                    <a href="#cs2">CS 2</a>
                </div>
            </div>
            <a href="#" class="nav-item">
                <i class="fas fa-users"></i> Игроки
            </a>
        </div>
        <div class="navbar-center">
            <img src="Assets/welcom_image.jpg" alt="Server Pulse Logo" class="navbar-logo">
            <h1>Server Pulse</h1>
        </div>
        <div class="navbar-right">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php" class="nav-item">Выйти</a>
            <?php else: ?>
                <a href="login.php" class="nav-item">Вход</a>
                <a href="register.php" class="nav-item">Регистрация</a>
            <?php endif; ?>
        </div>
    </nav>

    <main>
        <div class="content-wrapper">
            <div class="server-list">
                <h2>Добавить сервер</h2>
                <form method="POST" class="add-server-form">
                    <label for="name">Название Сервера:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="ip">IP Сервера:</label>
                    <input type="text" id="ip" name="ip" required>
                    <label for="port">Port Сервера:</label>
                    <input type="number" id="port" name="port" required>
                    <button type="submit">Добавить сервер</button>
                </form>

                <h2>Список серверов</h2>
                <ul>
                    <?php foreach ($servers as $server):?>
                        <?php
                        $serverInfos = getServerInfo($server['ip'], $server['port']);
                        foreach ($serverInfos as $serverInfo){
                            if ($serverInfo["gq_online"] == '1'):?>
                                <li>
                                    <a href="server.php?ip=<?= urlencode($server['ip']) ?>&port=<?= $server['port'] ?>">
                                        <?php htmlspecialchars(print ($serverInfo['gq_hostname'])) ?> (<?php print (($serverInfo['num_players'] ?? '0') . "/" . ($serverInfo['max_players'] ?? '0'))?>)
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="offline"><?= htmlspecialchars($server['name']) ;?> (Offline)</li>
                            <?php endif;?>
                        <?php }; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>