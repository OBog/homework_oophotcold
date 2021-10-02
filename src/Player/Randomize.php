<?php

namespace Player;

class Randomize
{
    private $min = 0;
    private $max;
    public function __construct($min,$max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function rand ()
    {
        return rand($this->min, $this->max);
    }
}