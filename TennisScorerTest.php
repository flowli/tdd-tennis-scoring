<?php
require_once 'TennisScorer.php';

use PHPUnit\Framework\TestCase;

class TennisScorerTest extends TestCase
{
    private $tennisScorer;
    
   
    public function testStartingScoreIsZeroZero()
    {
        $tennisScorer = new TennisScorer();
        $score = $tennisScorer->getScore();
        $this->assertEquals("love", $score->player1);
        $this->assertEquals("love", $score->player2);
    }
    
    public function testScoringPatternPlayer2LandslideWin() {
        $tennisScorer = new TennisScorer();
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("love", $score->player1, 'Player1 did not score yet');
        $this->assertEquals("fifteen", $score->player2, 'Player2 has a score of fifteen');
        
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("love", $score->player1, 'Player 1 still did not score yet');
        $this->assertEquals("thirty", $score->player2, 'Player two has a score of 30');

        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("love", $score->player1, 'Player 1 has zero points still');
        $this->assertEquals("fourty", $score->player2, 'Player two scored three times for a score of 40');

        $tennisScorer->playerTwoScoredAPoint();
        $this->assertEquals(true, $tennisScorer->hasTheGameEnded(), 'Player two won 4 points before player one has 3, the game ended.');
        $this->assertEquals(false, $tennisScorer->player1Won(), 'Player 1 lost the game.');
        $this->assertEquals(true, $tennisScorer->player2Won(), 'Player two won the game.');
    }

    public function testScoringPatternPlayer1Wins40To15() {
        $tennisScorer = new TennisScorer();
        
        // 15:0
        $tennisScorer->playerOneScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fifteen", $score->player1, 'Player1 has a score of fifteen');
        $this->assertEquals("love", $score->player2, 'Player2 did not score yet');
        
        // 15:15
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fifteen", $score->player1, 'Player 1 has a score of fifteen');
        $this->assertEquals("fifteen", $score->player2, 'Player two has a score of fifteen');

        // 30:15
        $tennisScorer->playerOneScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("thirty", $score->player1, 'Player 1 has a score of thirty');
        $this->assertEquals("fifteen", $score->player2, 'Player two has a score of fifteen');

        // 40:15
        $tennisScorer->playerOneScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fourty", $score->player1, 'Player 1 has a score of fourty');
        $this->assertEquals("fifteen", $score->player2, 'Player two has a score of fifteen');

        // win:15
        $tennisScorer->playerOneScoredAPoint();
        $score = $tennisScorer->getScore();
        
        // game ended for player 1
        $this->assertEquals(true, $tennisScorer->hasTheGameEnded(), 'Player one won 4 points before player two has 3, the game ended.');
        $this->assertEquals(true, $tennisScorer->player1Won(), 'Player 1 lost the game.');
        $this->assertEquals(false, $tennisScorer->player2Won(), 'Player two won the game.');
    }
    
    public function testGameGoesOverDeuce() {
        $tennisScorer = new TennisScorer();
        // 15:15
        $tennisScorer->playerOneScoredAPoint();
        $tennisScorer->playerTwoScoredAPoint();

        // 30:30
        $tennisScorer->playerOneScoredAPoint();
        $tennisScorer->playerTwoScoredAPoint();

        // 40:40
        $tennisScorer->playerOneScoredAPoint();
        $tennisScorer->playerTwoScoredAPoint();

        $this->assertEquals(false, $tennisScorer->hasTheGameEnded());
        
        // adv:40
        $tennisScorer->playerOneScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("advantage", $score->player1, 'Player 1 has advantage');
        $this->assertEquals("fourty", $score->player2, 'Player two has a score of fourty');  
        
        // 40:40
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fourty", $score->player1, 'Player 1 has 40');
        $this->assertEquals("fourty", $score->player2, 'Player 2 has 40');  

        // 40:adv
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fourty", $score->player1, 'Player 1 has 40');
        $this->assertEquals("advantage", $score->player2, 'Player 2 has adv');  
        
        // 40:40
        $tennisScorer->playerOneScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fourty", $score->player1, 'Player 1 has 40');
        $this->assertEquals("fourty", $score->player2, 'Player 2 has 40');  

        // 40:adv
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fourty", $score->player1, 'Player 1 has 40');
        $this->assertEquals("advantage", $score->player2, 'Player 2 has adv');  

        // 40:won
        $tennisScorer->playerTwoScoredAPoint();
        $score = $tennisScorer->getScore();
        $this->assertEquals("fourty", $score->player1, 'Player 1 has 40');
        $this->assertEquals("won", $score->player2, 'Player 2 has won');
        
        // player 2 won
        $this->assertEquals(true, $tennisScorer->hasTheGameEnded(), 'Player two won in the prologation.');
        $this->assertEquals(false, $tennisScorer->player1Won(), 'Player 1 lost the game.');
        $this->assertEquals(true, $tennisScorer->player2Won(), 'Player two won the game.');
    }
}
