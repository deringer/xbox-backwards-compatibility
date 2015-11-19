<?php

namespace Iatstuti\XboxOneCompatibility;

/**
 * Work with a cache of backwards compatible game titles.
 *
 * @copyright  2015 Hostworks Ltd
 * @author     Michael Dyrynda <michaeld@hostworks.com.au>
 */
class GamesCache
{
    /**
     * Array of games.
     *
     * @var array
     */
    protected $games;


    /**
     * Array of recently added games.
     *
     * @var array
     */
    protected $recent;

    /**
     * Cache file path.
     *
     * @var string
     */
    protected $cacheFile;


    /**
     * Class constructor.
     *
     * @param string $cacheFile Full path to cache file, including filename.
     */
    public function __construct($cacheFile)
    {
        $this->cacheFile = $cacheFile;

        if (! $this->cacheFileExists()) {
            $this->createCacheFile();
        }

        $this->loadCacheFile();
    }


    /**
     * Determine if the given game exists in our cache.
     *
     * @param  string $title Title to check
     *
     * @return boolean
     */
    public function gameExists($title)
    {
        return in_array($title, $this->games);
    }


    /**
     * Save the games instance to the cache.
     *
     * @param  Games  $games Games instance to save
     *
     * @return boolean
     */
    public function save(Games $games)
    {
        foreach ($games->all() as $title) {
            if (! $this->gameExists($title)) {
                $this->games[]  = $title;
                $this->recent[] = $title;
            }
        }

        // Merge the cached games with our list of games
        $games = array_merge($this->games(), $this->games);

        sort($this->games);

        $cache = new \stdClass;
        $cache->updated           = time();
        $cache->games             = $this->games;
        $cache->recent            = new \stdClass;
        $cache->recent->timestamp = ( count($this->recent) > 0 ) ? time() : $this->cache->recent->timestamp;
        $cache->recent->games     = ( count($this->recent) > 0 ) ? $this->recent : $this->cache->recent->games;

        return @file_put_contents($this->cacheFile, json_encode($cache));
    }


    /**
     * Get the array of games from the cache.
     *
     * @return array
     */
    public function games()
    {
        return isset($this->cache->games) ? $this->cache->games : [];
    }


    /**
     * Get the array of recently added games from the cache.
     *
     * @return array
     */
    public function recent()
    {
        return $this->recent;
    }


    /**
     * Determine if the cache file exists.
     *
     * @return boolean
     */
    private function cacheFileExists()
    {
        return file_exists($this->cacheFile);
    }


    /**
     * Load data from the cache file.
     *
     * @return boolean
     */
    private function loadCacheFile()
    {
        $this->cache = json_decode(file_get_contents($this->cacheFile));
        $this->games = $this->games();

        return true;
    }


    /**
     * Create a blank cache file (touch)
     *
     * @return boolean
     */
    private function createCacheFile()
    {
        return touch($this->cacheFile);
    }
}
