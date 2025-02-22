<?php
require 'DataBase/db.php';
require 'server_query.php';

$ip = $_GET['ip'];
$port = $_GET['port'];

$serverInfos = getServerInfo($ip, $port);

if (!$serverInfos) {
    die('Server is offline or unreachable.');
}

foreach ($serverInfos as $serverInfo){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($serverInfo['gq_hostname']) ?></title>
    <link rel="icon" type="image/png" href="Assets/ico/icon_serverpulse.png">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($serverInfo['gq_hostname']) ?></h1>
    </header>
    <main>
        <p>IP: <?= htmlspecialchars($serverInfo['gq_address']) ?></p>
        <p>Игроки: <?= $serverInfo['num_players'] ?? 'N/A' ?>/<?= $serverInfo['max_players'] ?? 'N/A' ?></p>
        <p>Карта: <?= htmlspecialchars($serverInfo['map'] ?? 'N/A') ?></p>
        <p>Миссия: <?= htmlspecialchars($serverInfo['gq_gametype'] ?? 'N/A') ?></p>
        <p>Пароль: <?= isset($serverInfo['gq_password']) ? ($serverInfo['gq_password'] ? 'Yes' : 'No') : 'N/A' ?></p>
        <p>Моды: <?= htmlspecialchars(implode(', ', $serverInfo['signatures'] ?? [])) ?></p>
        <h2>Игроки</h2>
        <table>
            <thead>
                <tr>
                    <th>Ник</th>
                    <th>Очки</th>
                    <th>Время</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($serverInfo['players'])): ?>
                    <?php foreach ($serverInfo['players'] as $player): ?>
                        <tr>
                            <td><?= htmlspecialchars($player['name'] ?? 'N/A') ?></td>
                            <td><?= $player['score'] ?? 'N/A' ?></td>
                            <td><?= gmdate("H:i:s",(int) $player['time']) ?? 'N/A' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Нет игроков онлайн.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
<?php }; ?>