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
        if (is_array($title)) {
            foreach ($title as $t) {
                $this->games[] = $t;
            }
        } else {
            $this->games[] = $title;
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
