<?php
declare(strict_types=1);

/*
--------------------------
Rock, Paper, Scissors game
--------------------------
Program flow
1. Show the rock paper scissors messages
2. Get player's input
    Log player input on what he played
3. Get computer's input
    Log computer's input on what he played
4. Check who won/lost or if tied
5. Add score to winner
6. Display scoreboard
7. Store current round's data into the array of match history
8. Ask if player if they want to play again
    (Y\n) for yes or no if player wants to continue, if yes loop back to the Step 2, else continue to Step 9.
9. Show the match summary of every round played.
10. Acknowledge player's exit
11. Exit out of the game

Backlog:
- refactor into OOP
    - unstaged draft: RockPaperScissorsGame.php
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

// 7. Push into $matchHistory to store current round's history
function setMatchHistory(array &$matchHistory, array $currentRoundData): void {
    $matchHistory[] = $currentRoundData;
}

// 8. Ask player if they still want to play
function getAskIfContinue(): string {
    return  DIVIDER .
            "Do you want to keep playing? Enter 'Y' to start another round: ";
}

// 8. Get player input if they still want to play
function wantsToPlayAgain(string $userInput): bool {
    return strtoupper(trim($userInput)) === 'Y';
}

// 9. Get the summary of every round from the whole match history
function getMatchHistorySummary(array &$matchHistory): string {
    $completeMatchHistory = '';
    foreach ($matchHistory as $round) {
        $completeMatchHistory .=    "Round {$round['roundNumber']}: P: " .
                                    MOVES[$round['playerMove']]['name'] .
                                    " | C: " .
                                    MOVES[$round['computerMove']]['name'] .
                                    " | " . getWinner($round['roundWinner']) .
                                    // "\t{$round['roundWinner']} wins! " .
                                    "Score: {$round['playerScore']} - {$round['computerScore']}" . PHP_EOL;
        
                                    // {MOVES[$round['playerMove']]['name']}
                                    // "Round {$round['roundNumber']}:
                                    // Player: {$round['playerMove']} | 
                                    // Computer: {$round['computerMove']}. 
                                    // {$round['roundWinner']} won!" .
                                    // PHP_EOL;
    }
    return $completeMatchHistory;
}

// 10. Goodbye message when they want to quit
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
    $currentRoundData = [];
    $matchHistory = [];

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
        $roundWinner = determineWinner($playerMove, $computerMove);
        echo getWinner($roundWinner);

        // 5.
        updateScore($roundWinner, $playerScore, $computerScore);

        // 6.
        echo getScoreboard($playerScore, $computerScore, $roundCount);

        // 7. Gather this round's data into one group of array rather than sending individual variables as parameter
        $currentRoundData = [
            'roundNumber'   => $roundCount,
            'playerScore'   => $playerScore,
            'computerScore' => $computerScore,
            'playerMove'    => $playerMove,
            'computerMove'  => $computerMove,
            'roundWinner'   => $roundWinner
        ];

        // 7. Setter function to send the current round data we just packed together to be appended to the match history
        setMatchHistory($matchHistory, $currentRoundData);
        // Setter drafts
        // $matchHistory[] += $currentRoundData;
        // $matchHistory += $currentRoundData;
        // $matchHistory[] = setMatchHistory($matchHistory[$roundCount-1]);
        // array_push($matchHistory[$roundCount-1], $currentRoundData);

        // 8.
        echo getAskIfContinue();
        $playAgain = wantsToPlayAgain(readline());

        $roundCount++;

    } while($playAgain);

    echo DIVIDER;
    // 9.
    echo getMatchHistorySummary($matchHistory);
    // 10.
    echo getGoodbyeMessage();
    // 11. End of the program
    /*
    $matchHistory = [0] =>  ['round' => $roundCount],
                            ['playerMove' => $playerMove],
                            ['computerMove' => $computerMove],
                            ['winner' => $winner]);
                    [1] =>  ['round' => $roundCount],
                            ['playerMove' => $playerMove],
                            ['computerMove' => $computerMove],
                            ['winner' => $winner]);
    Sample output:
    $matchHistory[0]['round'] = 1;
    $matchHistory[0]['playerMove'] = 'S';
    $matchHistory[0]['computerMove'] = 'P';
    $matchHistory[0]['winner'] = 'player';

    for getter example, preferably in a single line for each round played:
    Maybe \t tabs for clean and readable indentations
    echo "Round {$matchHistory[0]['round']}: Player $matchHistory[0]['playerMove'] | Computer: $matchHistory[0]['computerMove']. {$matchHistory[0]['winner'] wins!}" . PHP_EOL;
    echo "Round 1: Player: Scissors | Computer: Paper. Player won! Score: 1 - 0" . PHP_EOL;
    echo "Round 2: Player: Rock | Computer: Paper. Computer won!" . PHP_EOL;
    */
}