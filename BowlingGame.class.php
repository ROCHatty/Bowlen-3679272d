<?php

include_once "Player.class.php";
include_once "ScoreBoard.class.php";
class BowlingGame
{
    private $scoreBoard;
    private $players;
    private $round;
    public function __construct()
    {
        echo "Welcome the the bowling game!" . PHP_EOL;
        $this -> askPlayerNames();
        $this -> playAllRounds();
        $this -> scoreBoard = new ScoreBoard($this -> players);
    }

    public function start()
    {
        $this -> round = 0;
        while ($this -> round < 10) {
            $this -> round++;
            echo "Round " . $this -> round . "!" . PHP_EOL;
            $this -> playRound();
        }
    }

    private function addPlayer($playerName)
    {
        $player = new Player($playerName);
        $notInserted = true;
        $playerCount = 0;
        while ($notInserted) {
            if (!isset($this -> players[$playerCount])) {
                $this -> players[$playerCount] = $player;
                $notInserted = false;
            }
            $playerCount++;
        }
    }

    private function askPlayerNames()
    {
        echo "What is your name?" . PHP_EOL;
        $this -> addPlayer(readline("> "));
        echo "Do you wish to add another player? (Yes/No, Y/N)" . PHP_EOL;
        $answer = readline("> ");
        while (strtolower($answer) == "y" || strtolower($answer) == "yes") {
            echo "What is your name?" . PHP_EOL;
            $this -> addPlayer(readline("> "));
            echo "Do you wish to add another player? (Yes/No, Y/N)" . PHP_EOL;
            $answer = readline("> ");
        }
    }

    private function playRound()
    {
        foreach ($this -> players as $player) {
            echo "It's your turn " . $player -> name . ": what is your first throw?" . PHP_EOL;
            $firstThrow = readline("> ");
            if ($firstThrow != 10) {
                echo "And what is your second throw?" . PHP_EOL;
                $secondThrow = readline("> ");
                $player -> throwPins($firstThrow, $secondThrow);
            } else {
                $player -> throwPins($firstThrow, null);
            }
        }
    }

    private function playLastRound()
    {
        foreach ($this -> players as $player) {
            echo "It's your turn " . $player -> name . ": what is your first throw?" . PHP_EOL;
            $firstThrow = readline("> ");
            $doThirdThrow = false;
            if ($firstThrow == 10) {
                $doThirdThrow = true;
            }
            echo "And what is your second throw?" . PHP_EOL;
            $secondThrow = readline("> ");
            if ($secondThrow + $firstThrow == 10) {
                $doThirdThrow = true;
            }
            $player -> throwPins($firstThrow, $secondThrow);
            if ($doThirdThrow) {
                echo "And what is your third throw?" . PHP_EOL;
                $thirdThrow = readline("> ");
                $player -> throwPins($thirdThrow);
            }
        }
    }

    private function playAllRounds()
    {
        $round = 1;
        while ($round <= 9) {
            $this -> playRound();
            $round++;
        }

        echo PHP_EOL . PHP_EOL . "LAST ROUND!!!!!!!" . PHP_EOL . PHP_EOL;
        $this -> playLastRound();
    }
}
