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
*/

// Constants
const DIVIDER = "-------------------------------------------------------------------------" . PHP_EOL;
const MOVE_MAP = [
                1 => 'R',
                2 => 'P',
                3 => 'S',
                ];
const VALID_MOVES = ['R', 'P', 'S'];
const MOVE_NAMES = [
                'R' => 'Rock',
                'P' => 'Paper',
                'S' => 'Scissors',
                ];
const WIN_CONDITION = [     // Defining what is the win condition for each moves
                'R' => 'S', // Rock needs Scissors to win over
                'P' => 'R', // Paper beats Rock to win
                'S' => 'P', // Scissors beats Paper
                ];

// Variables
$playerScore = 0;
$computerScore = 0;
$roundCount = 1;
$playAgain = true;

// 1. Print the welcome message for Rock, Paper, Scissors
function printWelcomeMessage(): void {
    echo DIVIDER;
    echo "Play rock, paper, scissors with the computer." . PHP_EOL;
    echo "The computer will randomly pick between rock, paper and scissors." . PHP_EOL;
    echo "Input 'R' to play Rock, 'P' for Paper, 'S' for scissors, without the quotes." . PHP_EOL;
    echo DIVIDER;
}

// 2 and 3. Getting an entity's move
function getMove(int|string $entityInput): ?string {
    if (is_int($entityInput)) {
        // For translating computer's moves
        return MOVE_MAP[$entityInput] ?? null;
    }

    $entityInput = strtoupper(trim($entityInput));
    return in_array($entityInput, VALID_MOVES, true) ? $entityInput : null;
}

// 2 and 3 Printing the entity's move
function printMove(string $entity, string $move): string {
    return "{$entity} played " . MOVE_NAMES[$move] . "!" . PHP_EOL;
}

// 4. Game result
function determineWinner(string $playerMove, string $computerMove): string {
    if ($playerMove === $computerMove) {
        return 'tie';
    }

    else if (WIN_CONDITION[$playerMove] === $computerMove) {
        return 'player';
    }
    
    else {
        return 'computer';
    }
}

// 4. Show game result
function showWinner(string $gameResult): string {
    return match (true) {
        $gameResult === 'tie'       => "It's a tie!" . PHP_EOL,
        $gameResult === 'player'    => "Player wins the round!" . PHP_EOL,
        $gameResult === 'computer'  => "Computer wins the round!" . PHP_EOL
    };
}

// 5. Adding score to whoever won
function updateScore(string $winner, int &$playerScore, int &$computerScore): void {
    if ($winner === 'tie') return;
    if ($winner === 'player') {
        ++$playerScore;
    } else {
        ++$computerScore;
    }
}

// 6. Score tally
function showScoreboard(int $playerScore, int $computerScore, int $roundCount): void {
    echo DIVIDER;
    echo "--- Round {$roundCount} ---" . PHP_EOL;
    echo "Player score: {$playerScore}" . PHP_EOL;
    echo "Computer score: {$computerScore}" . PHP_EOL;
}

// 7. Ask player if they still want to play
function askPlayerIfContinue(string $userInput): bool {
    return strtoupper(trim($userInput)) === 'Y';
}

// 8. Goodbye message when they want to quit
function printGoodbyeMessage(): void{
    echo DIVIDER;
    echo "Thanks for playing!" . PHP_EOL;
}

// Game loop
// 1.
printWelcomeMessage();

do{
    // 2.
    echo "Round: {$roundCount}" . PHP_EOL;
    echo "Enter your move (R/P/S): ";
    $playerMove = getMove(readline());
    if ($playerMove === null) {
        echo "Invalid input! Restarting this round." . PHP_EOL;
        continue;
    }
    echo printMove("Player", $playerMove);

    // 3.
    $computerMove = getMove(mt_rand(1, 3));
    echo printMove("Computer", $computerMove);

    // 4.
    $winner = determineWinner($playerMove, $computerMove);
    echo showWinner($winner);

    // 5.
    updateScore($winner, $playerScore, $computerScore);

    // 6.
    showScoreboard($playerScore, $computerScore, $roundCount);

    // 7.
    echo DIVIDER;
    echo "Do you want to keep playing? Enter 'Y' to start another round: ";
    $playAgain = askPlayerIfContinue(readline());
    $roundCount++;

} while($playAgain);

printGoodbyeMessage();