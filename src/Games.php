<?php

namespace Iatstuti\XboxOneCompatibility;

use Iatstuti\XboxOneCompatibility\GamesCache;

/**
 * Object to encapsulate a collection of games.
 *
 * @copyright  2015 Hostworks Ltd
 * @author     Michael Dyrynda <michaeld@hostworks.com.au>
 */
class Games
{
    protected $cache;
    protected $games = [];


    /**
     * Class constructor.
     *
     * @param GamesCache $cache Cache is used to save games for later.
     */
    public function __construct(GamesCache $cache)
    {
        $this->cache = $cache;
    }


    /**
     * Add a title, or array of titles to the collection.
     *
     * @param array|string $title Game title
     */
    public function add($title)
    {
        if (is_array($title)) {
            foreach ($title as $t) {
                $this->games[] = $t;
            }
        } else {
            $this->games[] = $title;
        }

        return $this;
    }


    /**
     * Return all the games in the current collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->games;
    }


    /**
     * Save the games to the cache.
     *
     * @return boolean
     */
    public function save()
    {
        return $this->cache->save($this);
    }
}
