<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

define('RPS_TESTING', true);
require_once __DIR__ . '/../rock_paper_scissors.php';

// Learned: class name should match file name!
class GameTest extends TestCase
{
    public function testRockBeatsScissors()
    {
        $this->assertSame('player', determineWinner('R', 'S'));
    }

    public function testScissorsLosesToRock()
    {
        $this->assertSame('computer', determineWinner('S', 'R'));
    }
    public function testTie()
    {
        $this->assertSame('tie', determineWinner('R', 'R'));
    }
    public function testGetPlayerInputValidity()
    {
        $this->assertSame('R', getPlayerInput('r'));
        $this->assertSame('P', getPlayerInput('p'));
        $this->assertSame('S', getPlayerInput('s'));
        $this->assertSame(null, getPlayerInput('X'));
        $this->assertSame(null, getPlayerInput('n'));
    }
    public function testGetComputerInputValidity()
    {
        $computerInput = getComputerInput();
        // Check if $computerInput is string
        $this->assertIsString($computerInput);
        // Check if $computerInput is one of the keys from const MOVES
        $this->assertArrayHasKey($computerInput, MOVES);
    }
    // Learned: functions with &$param (pass by reference) must be called with a real variable, not a literal.
    // The function modifies the caller's variable directly, so there has to be a variable there to modify
    // that's also why testing updateScore() means checking what a variable became after the call, not what the function returned.
    public function testUpdateScoreGivesPlayerAPoint()
    {
        $playerScore = 0;
        $computerScore = 0;

        updateScore('player', $playerScore, $computerScore);

        $this->assertSame(1, $playerScore);
        $this->assertSame(0, $computerScore);
    }
    public function testUpdateScoreGivesComputerAPoint()
    {
        $playerScore = 0;
        $computerScore = 0;

        updateScore('computer', $playerScore, $computerScore);

        $this->assertSame(0, $playerScore);
        $this->assertSame(1, $computerScore);
    }
    public function testUpdateScoreOnTieChangesNothing()
    {
        $playerScore = 3;
        $computerScore = 5;

        updateScore('tie', $playerScore, $computerScore);

        $this->assertSame(3, $playerScore);
        $this->assertSame(5, $computerScore);
    }
    public function testAskPlayerIfContinueAcceptsUppercaseY()
    {
        $this->assertTrue(wantsToPlayAgain('Y'));
    }
    public function testAskPlayerIfContinueAcceptsLowercaseY()
    {
        $this->assertTrue(wantsToPlayAgain('y'));
    }
    public function testAskPlayerIfContinueRejectsAnythingElse()
    {
        $this->assertFalse(wantsToPlayAgain('n'));
        $this->assertFalse(wantsToPlayAgain('x'));
    }
    public function testAskPlayerIfContinueTrimsWhitespace()
    {
        $this->assertTrue(wantsToPlayAgain('  y   '));
    }
}