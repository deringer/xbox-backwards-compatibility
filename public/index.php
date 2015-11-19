<?php

use Iatstuti\XboxOneCompatibility\GamesCache;

require dirname(__FILE__) . '/../bootstrap.php';

$cache = new GamesCache(getenv('XBOX_BC_GAME_CACHE'));

$lastUpdated       = $cache->lastUpdated()->setTimezone(new \DateTimeZone(getenv('DEFAULT_TIMEZONE')));
$recentLastUpdated = $cache->recentLastUpdated()->setTimezone(new \DateTimeZone(getenv('DEFAULT_TIMEZONE')));

print '<!doctype html><html lang="en"><meta charset="utf-8">';

printf(
    '<h1>Xbox One Backwards Compatibility titles <small>Last updated %s</small></h1>',
    $lastUpdated ? $lastUpdated->format('d/m/Y H:i:s') : 'never'
);

print '<table>';
foreach (array_chunk($cache->games(), 3) as $chunk) {
    print '<tr>';
    foreach ($chunk as $game) {
        printf('<td%s>%s</td>', $cache->isRecent($game) ? ' style="background-color: #a7d490;"' : null, $game);
    }
    print '</tr>';
}
print '</table>';
printf('<em style="background-color: #a7d490;">Recent titles last updated %s</em>', $recentLastUpdated->format('d/m/Y H:i:s'));
print '</html>';
