<?php

class TennisScorer {
    public $player1 = 0;
    public $player2 = 0;
    
    public function getScore() {
        $score = new stdClass;
        $score->player1 = $this->scoreNumberToWord($this->player1);
        $score->player2 = $this->scoreNumberToWord($this->player2);
        return $score;
    }

    public function hasTheGameEnded() {
        return $this->player1Won()
            || $this->player2Won();
    }
    
    public function player1Won() {
        return $this->player1 >= 4
            && $this->player1 - $this->player2 >= 2;
    }

    public function player2Won() {
        return $this->player2 >= 4
            && $this->player2 - $this->player1 >= 2;
    }
    
    public function scoreNumberToWord($score) {
        $scoreNames = [
            0 => 'love',
            1 => 'fifteen',
            2 => 'thirty',
            3 => 'fourty',
        ];
       if(isset($scoreNames[$score])) {
           return $scoreNames[$score];
       }

       // adv or won?
       if(!$this->hasTheGameEnded()) {
        return 'advantage';
       }

       return 'won';
    }

    public function playerOneScoredAPoint() {
        $this->player1++;
        $this->deucer();
    }


    public function playerTwoScoredAPoint() {
        $this->player2++;
        $this->deucer();
    }
    
    /**
     * nach 40-40 heißen alle Gleichstände 40:40 - deucer() prüft & korrigiert wenn nötig
     */
    public function deucer() {
        if($this->player1 >= 3 && $this->player2 >= 3 && $this->player1 === $this->player2) {
            $this->player1 = 3;
            $this->player2 = 3;
        }
    }
}
