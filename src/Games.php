<?php

namespace Iatstuti\XboxOneCompatibility;

use Iatstuti\XboxOneCompatibility\GamesCache;

class Games
{
    protected $cache;
    protected $games = [];

    public function __construct(GamesCache $cache)
    {
        $this->cache = $cache;
    }


    public function add($title)
    {
        foreach ($title as $t) {
            $this->games[] = $t;
        }

        return $this;
    }


    public function all()
    {
        return $this->games;
    }


    public function save()
    {
        return $this->cache->save($this);
    }
}
