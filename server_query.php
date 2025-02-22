<?php
require __DIR__ . '/vendor/austinb/gameq/src/GameQ/Autoloader.php';

use GameQ\GameQ;

function getServerInfo($ip, $port) {
    $GameQ = new GameQ();

    $GameQ->addServer([
        'type' => 'arma3',
        'host' => $ip . ':' . $port,
    ]);

    $GameQ->setOption('timeout', 5);

    $results = $GameQ->process();

    return $results;
}
?>