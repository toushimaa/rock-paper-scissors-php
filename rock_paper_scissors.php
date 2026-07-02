<?php
declare(strict_types=1);

/*
--------------------------
Rock, Paper, Scissors game
--------------------------
Program flow
1. Show the rock paper scissors messages
2. Get user's input
    Log user input on what he played
3. Get computer's input
    Log computer's input on what he played
4. Check who won/lost or if tied
5. Add score to winner
6. Display scoreboard
7. Ask if user wants to play again
    (Y\n) for yes or no if user wants to continue, if yes loop back to the start, else close the program.

Backlog:
- refactor into OOP
- feat: match history
*/

// Constants
const DIVIDER = "-------------------------------------------------------------------------" . PHP_EOL;
const MOVES = [
    'R' => ['name' => 'Rock',       'beats' => 'S'],
    'P' => ['name' => 'Paper',      'beats' => 'R'],
    'S' => ['name' => 'Scissors',   'beats' => 'P']
];

// 1. Get the welcome message for Rock, Paper, Scissors
function getWelcomeMessage(): string {
    return  DIVIDER .
            "Play rock, paper, scissors with the computer." . PHP_EOL .
            "The computer will randomly pick between rock, paper and scissors." . PHP_EOL .
            "Input 'R' to play Rock, 'P' for Paper, 'S' for scissors, without the quotes." . PHP_EOL .
            DIVIDER;
}

// 2. Getting the Player's move
function getPlayerInput(string $playerInput): ?string {
    $playerInput = strtoupper(trim($playerInput));
    return isset(MOVES[$playerInput]) ? $playerInput : null;
}

// 3. Getting the Computer's move
function getComputerInput(): string {
    return array_rand(MOVES);
}

// 2 and 3 Printing the entity's move
function getEntityMoveMessage(string $entity, string $move): string {
    return "{$entity} played " . MOVES[$move]['name'] . "!" . PHP_EOL;
}

// 4. Game result
function determineWinner(string $playerMove, string $computerMove): string {
    if ($playerMove === $computerMove) return 'tie';
    return (MOVES[$playerMove]['beats'] === $computerMove) ? 'player' : 'computer';
}

// 4. Show game result
function getWinner(string $gameResult): string {
    return match ($gameResult) {
        'tie'       => "It's a tie!" . PHP_EOL,
        'player'    => "Player wins the round!" . PHP_EOL,
        'computer'  => "Computer wins the round!" . PHP_EOL
    };
}

// 5. Adding score to whoever won
function updateScore(string $winner, int &$playerScore, int &$computerScore): void {
    if ($winner === 'player') $playerScore++;
    if ($winner === 'computer') $computerScore++;
}

// 6. Score tally
function getScoreboard(int $playerScore, int $computerScore, int $roundCount): string {
    return  DIVIDER .
            "--- Round {$roundCount} ---" . PHP_EOL .
            "Player score: {$playerScore}" . PHP_EOL .
            "Computer score: {$computerScore}" . PHP_EOL;
}

// 7. Ask player if they still want to play
function getAskIfContinue(): string {
    return  DIVIDER .
            "Do you want to keep playing? Enter 'Y' to start another round: ";
}

// 7. Ask player if they still want to play
function wantsToPlayAgain(string $userInput): bool {
    return strtoupper(trim($userInput)) === 'Y';
}

// 8. Goodbye message when they want to quit
function getGoodbyeMessage(): string {
    return  DIVIDER .
            "Thanks for playing!" . PHP_EOL;
}

if (!defined('RPS_TESTING')) {
    // Starting variables (New game)
    $playerScore = 0;
    $computerScore = 0;
    $roundCount = 1;
    $playAgain = true;

    // Game loop
    // 1.
    echo getWelcomeMessage();

    do{
        // 2.
        echo "Round: {$roundCount}" . PHP_EOL;
        echo "Enter your move (R/P/S): ";

        $playerMove = getPlayerInput(readline());
        if ($playerMove === null) {
            echo "Invalid input! Please try again." . PHP_EOL;
            continue;
        }
        echo getEntityMoveMessage("Player", $playerMove);

        // 3.
        $computerMove = getComputerInput();
        echo getEntityMoveMessage("Computer", $computerMove);

        // 4.
        $winner = determineWinner($playerMove, $computerMove);
        echo getWinner($winner);

        // 5.
        updateScore($winner, $playerScore, $computerScore);

        // 6.
        echo getScoreboard($playerScore, $computerScore, $roundCount);

        // 7.
        echo getAskIfContinue();
        $playAgain = wantsToPlayAgain(readline());
        $roundCount++;

    } while($playAgain);

    echo getGoodbyeMessage();
}