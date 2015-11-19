<?php

namespace Iatstuti\XboxOneCompatibility;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Scrape the given url in order to cache a list
 * of Xbox One backwards compatible titles.
 *
 * @copyright  2015 Hostworks Ltd
 * @author     Michael Dyrynda <michaeld@hostworks.com.au>
 */
class XboxGamesScraper
{
    /**
     * DomCrawler instance.
     *
     * @var Crawler
     */
    protected $crawler;


    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->crawler = new Crawler;
    }


    /**
     * Scrape the given url.
     *
     * @param  string $url
     *
     * @return boolean
     */
    public function scrape($url)
    {
        $contents = @file_get_contents($url);

        if (! $contents) {
            return new ScraperException(sprintf(
                'Could not reach the URL - %s - to scrape. Try again later.',
                $url
            ));
        }

        $this->crawler->add($contents);

        return $this->fetchGames();
    }


    /**
     * Fetch the games from the scraped url.
     *
     * @return Games
     */
    private function fetchGames()
    {
        return $this->crawler->filter('ul.gamesList-wrapper li.game')->each(function ($game) {
            return $game->text();
        });
    }
}
