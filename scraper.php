<?php

use Iatstuti\XboxOneCompatibility\Games;
use Iatstuti\XboxOneCompatibility\GamesCache;
use Iatstuti\XboxOneCompatibility\XboxGamesScraper;

/**
 * Scrape the Xbox website endpoint and store them in local cache.
 *
 * @copyright  2015 Hostworks Ltd
 * @author     Michael Dyrynda <michaeld@hostworks.com.au>
 */

require dirname(__FILE__) . '/bootstrap.php';

try {
    $cache   = new GamesCache(getenv('XBOX_BC_GAME_CACHE'));
    $games   = new Games($cache);
    $scraper = new XboxGamesScraper;

    if ($titles = $scraper->scrape(getenv('XBOX_SITE_ENDPOINT'))) {
        $games->add($titles)->save();

        if ($recent = $cache->recent()) {
            printf('Successfully scraped endpoint for %d new games%s', count($recent), PHP_EOL);
        }
    } else {
        printf('Could not scrape endpoint for new games%s', PHP_EOL);
    }
} catch (Iatstuti\XboxOneCompatibility\ScraperException $e) {
    printf('%s%s', $e->getMessage(), PHP_EOL);
    exit(1);
}
