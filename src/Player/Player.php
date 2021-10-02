<?php

namespace Player;

class Player
{
    private $name;
    private $attempt;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getScore()
    {
        return $this->attempt;
    }

    public function setScore($attempt)
    {
        $this->attempt = $attempt;
    }

}