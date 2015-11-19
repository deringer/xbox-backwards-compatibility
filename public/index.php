<?php

use Iatstuti\XboxOneCompatibility\GamesCache;

require dirname(__FILE__) . '/../bootstrap.php';

$cache = new GamesCache(getenv('XBOX_BC_GAME_CACHE'));

$lastUpdated       = $cache->lastUpdated()->setTimezone(new \DateTimeZone(getenv('DEFAULT_TIMEZONE')));
$recentLastUpdated = $cache->recentLastUpdated()->setTimezone(new \DateTimeZone(getenv('DEFAULT_TIMEZONE')));

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Xbox One Backwards Compatibility</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Xbox One Backwards Compatibility titles <small>Last updated <?= $lastUpdated ? $lastUpdated->format('d/m/Y H:i:s') : 'never' ?></small></h1>

        <table class="table table-bordered">
        <col style="width: 25%;" />
        <col style="width: 25%;" />
        <col style="width: 25%;" />
        <col style="width: 25%;" />
        <?php foreach (array_chunk($cache->games(), 4) as $chunk): ?>
            <tr>
                <?php foreach ($chunk as $game): ?>
                    <td <?= $cache->isRecent($game) ? 'class="success"' : null ?>><?= $game ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td class="success" colspan="4">
                Recent titles last updated <?= $recentLastUpdated ? $recentLastUpdated->format('d/m/Y H:i:s') : 'never' ?>
            </td>
        </tr>
        </table>
    </div>
</html>
