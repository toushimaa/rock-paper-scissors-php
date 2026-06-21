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
- refactor: getMove() as one function to handle both Player and Computer input
- refactor: printMove() to display their move 'Player/Computer has played Rock/Paper/Scissors!'
- feat: round counter
feature request: Displaying the played moves "Player wins by using Rock|Paper|Scissors over Computer's Rock|Paper|Scissors|"
*/

// Constants
const DIVIDER = "-------------------------------------------------------------------------" . PHP_EOL;

// Variables
$playerScore = 0;
$computerScore = 0;
$playAgain = true;

// Print the welcome message for Rock, Paper, Scissors
function printWelcomeMessage(): void {
    echo DIVIDER;
    echo "Play rock, paper, scissors with the computer." . PHP_EOL;
    echo "The computer will randomly pick between rock, paper and scissors." . PHP_EOL;
    echo "Input 'R' to play Rock, 'P' for Paper, 'S' for scissors, without the quotes." . PHP_EOL;
    echo DIVIDER;
}

// Player's turn
function getPlayerMove(string $input): ?string {
    $input = strtoupper(trim($input));
    switch ($input) {
        case 'R':
            echo "You have played Rock!". PHP_EOL;
            break;
        case 'P':
            echo "You have played Paper!". PHP_EOL;
            break;
        case 'S':
            echo "You have played Scissors!". PHP_EOL;
            break;
        default:
            echo "Invalid input! Skipping this round." . PHP_EOL;
            return null;
    }
    return $input;
}

// Computer's turn
function getComputerMove(int $input): string {
    switch ($input) {
        case 1:
            echo "Computer played Rock!" . PHP_EOL;
            return 'R';
        case 2:
            echo "Computer played Paper!" . PHP_EOL;
            return 'P';
        case 3:
            echo "Computer played Scissors!" . PHP_EOL;
            return 'S';
        default:
            throw new Exception("Error: Computer unexpectedly didn't play anything :("); // For debugging
    }
}

// 4. Game result
function determineWinner(string $playerInput, string $computerInput): string {

    // Defining what is the win condition for each moves
    $winningMoves = [
        'R' => 'S', // Rock needs Scissors to win over
        'P' => 'R', // Paper beats Rock to win
        'S' => 'P', // Scissors beats Paper
    ];

    if ($playerInput === $computerInput) {
        echo "It's a tie!" . PHP_EOL;
        return 'tie';
    }

    else if ($winningMoves[$playerInput] === $computerInput) {
        echo "Player wins the round!" . PHP_EOL;
        return 'player';
    }
    
    else {
        echo "Computer wins the round!" . PHP_EOL;
        return 'computer';
    }
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
function showScoreboard(int $playerScore, int $computerScore): void {
    echo DIVIDER;
    echo "Player score: {$playerScore}" . PHP_EOL;
    echo "Computer score: {$computerScore}" . PHP_EOL;
}

// 7. Ask player if they still want to play
function askPlayerIfContinue(): bool {
    echo DIVIDER;
    echo "Do you want to keep playing? (Y/n): ";
    $userInput = strtoupper(trim(readline()));
    return $userInput === 'Y';
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
    echo "Enter your move (R/P/S): ";
    $playerInput = getPlayerMove(readline());
    if ($playerInput === null) continue;

    // 3.
    $computerInput = getComputerMove(mt_rand(1, 3));

    // 4.
    $winner = determineWinner($playerInput, $computerInput);

    // 5.
    updateScore($winner, $playerScore, $computerScore);

    // 6.
    showScoreboard($playerScore, $computerScore);

    // 7.
    $playAgain = askPlayerIfContinue();
    
} while($playAgain);

printGoodbyeMessage();