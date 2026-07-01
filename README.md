# Rock, Paper, Scissors (PHP CLI)
![CI Status](https://github.com/toushimaa/rock-paper-scissors-php/actions/workflows/tests.yml/badge.svg)


A command-line Rock, Paper, Scissors game built in PHP, playable against the
computer.

## Requirements 
- PHP 8.0+

## Installation
```bash
composer install
```

## Testing
To run the test suite:
```bash
composer test
```
To run PHPUnit directly:
```bash
vendor/bin/phpunit tests
```

## How to play

```bash
php rock_paper_scissors.php
```

- Enter `R` for Rock, `P` for Paper, or `S` for Scissors when prompted.
- The computer picks randomly.
- Winner of each round gets a point; scores are tracked across rounds.
- After each round, choose whether to keep playing.
- Enter 'Y' or 'y' to play another round. Enter any other key to quit.

## What this learning project covers

- Control flow, functions, and loops in PHP
- Pass-by-reference for mutable score tracking across loop iterations
- Basic input validation and game-loop structure
- Unit testing with PHPUnit

## Notes

This was built to practice translating a plan into working code — the
`// 1.` `// 2.` comments throughout map directly onto a program flow written
out before any functions were coded.