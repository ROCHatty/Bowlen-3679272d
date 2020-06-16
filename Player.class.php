<?php

class Player {
    public $name;
    public $pinsThrown;

    public function __construct($name)
    {
        $this -> name = ucfirst($name);
        $this -> pinsThrown = [];
    }

    public function throwPins($throw1, $throw2 = 0)
    {
        if ($throw2 != null) {
            array_push($this -> pinsThrown, $throw1, $throw2);
        } else {
            array_push($this -> pinsThrown, $throw1);
        }
    }
}