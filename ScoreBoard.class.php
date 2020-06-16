<?php

class ScoreBoard
{
    private $scores;
    private $players;

    public function __construct($players)
    {
        $this -> players = $players;
        $this -> calculateAllScores();
        $this -> displayScores();
        $this -> displayWinner();
    }

    private function calculatePlayerScore($key, $player)
    {
        $this -> scores[$key] = 0;
        for ($i = 0; $i < count($player -> pinsThrown) - 1; $i++) {
            $currentThrow = $player -> pinsThrown[$i];
            if ($i % 2 == 0) {
                if ($currentThrow == 10) {
                    $this -> scores[$key] += 10;
                    try {
                        $this -> scores[$key] += $player -> pinsThrown[$i + 1];
                        $this -> scores[$key] += $player -> pinsThrown[$i + 2];
                    } catch (Exception $e) {
                        $this -> scores[$key] += 0;
                    }
                    array_splice($player -> pinsThrown, $i + 1, 0, 0);
                    $i++;
                }
            } elseif ($i % 2 == 1) {
                if ($currentThrow + $player -> pinsThrown[$i - 1] == 10) {
                    $this -> scores[$key] += 10;
                    try {
                        $this -> scores[$key] += $player -> pinsThrown[$i + 1];
                    } catch (Exception $e) {
                        $this -> scores[$key] += 0;
                    }
                } elseif (!isset($player -> pinsThrown[$i + 1])) {
                    $this -> scores[$key] += $currentThrow;
                } else {
                    $this -> scores[$key] += $currentThrow + $player -> pinsThrown[$i - 1];
                }
            }
        }
    }

    public function calculateAllScores()
    {
        foreach ($this -> players as $key => $player) {
            $this -> calculatePlayerScore($key, $player);
        }
    }

    public function displayScores()
    {
        $actualScores = array();
        foreach ($this -> scores as $key => $score) {
            $actualScores[] = ["score" => $score, "player" => $this -> players[$key] -> name];
        }

        function sortByOrder($a, $b)
        {
            return $a['score'] - $b['score'];
        }

        usort($actualScores, 'sortByOrder');
        foreach (array_reverse($actualScores) as $score) {
            echo $score['player'] . "            " . $score['score'] . " points" . PHP_EOL;
        }
        echo PHP_EOL;
        $this -> scores = array_reverse($actualScores);
    }

    public function displayWinner()
    {
        echo PHP_EOL . PHP_EOL . PHP_EOL;
        echo "And the winner is:" . PHP_EOL . PHP_EOL . $this -> scores[0]['player'] . " with " . $this -> scores[0]['score'] . " points!";
    }
}
