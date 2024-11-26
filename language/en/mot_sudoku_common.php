<?php
/**
*
* @package MoT Sudoku v0.11s.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if ( !defined('IN_PHPBB') )
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'MOT_SUDOKU_TITLE'				=> 'Sudoku',

	// Tabs
	'MOT_SUDOKU_TAB_CLASSIC'		=> 'Classic Sudoku',
	'MOT_SUDOKU_TAB_SAMURAI'		=> 'Samurai Sudoku',
	'MOT_SUDOKU_TAB_NINJA'			=> 'Ninja Sudoku',
	'MOT_SUDOKU_TAB_RANK'			=> 'Highscore',
	'MOT_SUDOKU_TAB_FAME'			=> 'Hall of Fame',

	// General terms
	'MOT_SUDOKU_EASY'				=> 'easy',
	'MOT_SUDOKU_MEDIUM'				=> 'medium',
	'MOT_SUDOKU_HARD'				=> 'hard',
	'MOT_SUDOKU_GAME_INFO'			=> 'Game pack:&nbsp;<strong>%1$s</strong>&nbsp;||&nbsp;Game:&nbsp;<strong>%2$s</strong>&nbsp;||&nbsp;Level:&nbsp;<strong>%3$s</strong>',
	'MOT_SUDOKU_CONGRATULATIONS'	=> 'Congratulations',
	'MOT_SUDOKU_PUZZLE_SOLVED'		=> '<strong>You solved this puzzle!</strong><br>
										Points you gained in this game: ',
	'MOT_SUDOKU_UP_POINTS'			=> '<br><br>UP points you gained: ',
	'MOT_SUDOKU_BACK_TO_START'		=> '<br><br>A new game will start automatically in a few seconds.',
	'MOT_SUDOKU_INCORRECT_END'		=> 'Unfortunately your solution was not entirely correct. Incorrect digits were deleted and the points for their deletion deducted from your
										points.<br>
										Please take the opportunity to enter the correct digits.',

	// Classic Sudoku
	'MOT_SUDOKU_NO_CLASSIC_PUZZLES'	=> 'Currently there are no Classic Sudoku puzzles avaiable, a game pack must be imported by the administrator!',
	'MOT_SUDOKU_HISTORY_TITLE'		=> 'History of this game',
	'MOT_SUDOKU_HISTORY'			=> 'The early ancestors of todays Sudoku were the Latin squares of Leonhard Euler, a Swiss mahtematician, who drafted these puzzles in
										the 18. century. Unlike our modern Sudoku puzzles they did not contain subgrids and contained double-digit numbers.<br><br>
										New Zealander Wayne Gould saw Sudoku on a voyage to Japan and over six years, he developed a computer program to produce unique puzzles
										rapidly. He offered his puzzles to the London Times and through publishing the first puzzles set off an Sudoku avalanche in the western
										world.',
	'MOT_SUDOKU_INSTRUCTIONS_TITLE'	=> 'Rules and instruction',
	'MOT_SUDOKU_INSTRUCTIONS'		=> 'Place a digit from 1 - 9 into each empty cell in manner that:<br><br>
										1. Every digit shows up exactly once in each line,<br>
										2. Every digit shows up exactly once in each column,<br>
										3. Every digit shows up exactly once in each 3 x 3 subgrid.<br><br>
										Some digits already have been laced in order to help you, they are dislayed in <strong>bold</strong> script. Just click
										into an empty cell to place a new digit. If you made a mistake just click into that cell again in order to delete that
										digit or just select another one.',

	// Samurai Sudoku
	'MOT_SUDOKU_NO_SAMURAI_PUZZLES'	=> 'Currently there are no Samurai Sudoku puzzles avaiable, a game pack must be imported by the administrator!',
	'MOT_SUDOKU_SAMURAI_TEXT'		=> 'If you find the Classic Sudoku puzzles easy you may want to try solving the more intricate Samurai Sudoku puzzles. These are 5 Classic
										Sudoku puzzles which overlap at their corners. You do think that this is the same as solving just five Classic Sudoku puzzles? Then try it
										and show us that you are a real Samurai!',

	// Ninja Sudoku
	'MOT_SUDOKU_NO_NINJA_PUZZLES'	=> 'Currently there are no Ninja Sudoku puzzles avaiable, a game pack must be imported by the administrator!',
	'MOT_SUDOKU_NINJA_TEXT'			=> 'Ninja Sudoku puzzles are a real challenge because they consist of  a total of 9 Classic Sudoku puzzles, which overlap between two and four
										times. This makes them highly difficult, but for a real Ninja they surely are just a piece of cake!',

	// Options box
	'MOT_SUDOKU_OPTIONS_TITLE'		=> 'Options',
	'MOT_SUDOKU_GAME_RESET'			=> 'Reset puzzle',
	'MOT_SUDOKU_GAME_RESET_TITLE'	=> 'Resetting the puzzle will cost you %1$d negative points',
	'MOT_SUDOKU_BUY_NUMBER'			=> 'Buy digit',
	'MOT_SUDOKU_BUY_NUMBER_TITLE'	=> 'Buying a digit will cost you %1$d negative points',
	'MOT_SUDOKU_ENABLE_HELPER'		=> 'Enable helper',
	'MOT_SUDOKU_HELPER_TITLE'		=> 'Usage of the helper will cost you %1$d negative points uniquely',
	'MOT_SUDOKU_HELPER_UPDATE'		=> 'Update helper',
	'MOT_SUDOKU_MASK_HELPER'		=> 'Remove helper',
	'MOT_SUDOKU_MASK_TITLE'			=> 'Removes the helper digits from the cells',
	'MOT_SUDOKU_HELPER_NOTE'		=> 'The digits displayed by the helper are only valid for the current state, the helper must be updated after each change, e.g. placing a digit.',
	'MOT_SUDOKU_GAME_QUIT'			=> 'Abort game',
	'MOT_SUDOKU_GAME_QUIT_TITLE'	=> 'If you are stuck with this puzzle you can abort here. This puzzle will be deleted from your stored puzzles and you can start a new one.',
	'MOT_SUDOKU_MODAL_ABOVE'		=> 'Digit input above puzzle',
	'MOT_SUDOKU_MODAL_OVER'			=> 'Digit input at mouse pointer',

	// Notes box
	'MOT_SUDOKU_NOTE_TITLE'			=> 'Notes',
	'MOT_SUDOKU_NOTE_TEXT'			=> 'For every digit you place you earn %1$d points. But be careful! Every time you delete or change a digit you will instantly get deducted
										%2$d points!<br><br>
										If you really happen to be at the end of one`s rope you can buy a digit at the cost of %3$d points, the (empty) cell it will be placed in
										is chosen by chance.<br>
										Resetting the puzzle (start from scratch) will cost you %4$d negative points. You will keep digits already bought.<br>
										Enabling the helper will cost you %5$d negative points per puzzle and is valid until the puzzle is solved.<br>
										Prior to starting the game by placing the first digit you may select an easier level, depending on this level you will get additional
										digits placed into the puzzle, however the optainable points will be reduced by %6$d for each digit.',

	// Levels box
	'MOT_SUDOKU_LEVEL_TITLE'		=> 'Game level',
	'MOT_SUDOKU_SELECT_LEVEL'		=> 'Choose a level',
	'MOT_SUDOKU_LEVEL_NAME'			=> 'Level',
	'MOT_SUDOKU_LEVEL_DIGITS'		=> 'Additional digits',
	'MOT_SUDOKU_LEVEL_DEDUCT'		=> 'Points to deduct',
	'MOT_SUDOKU_LEVEL_0'			=> 'Einstein',
	'MOT_SUDOKU_LEVEL_1'			=> 'Lasker',
	'MOT_SUDOKU_LEVEL_2'			=> 'Lomonosov',
	'MOT_SUDOKU_LEVEL_3'			=> 'Sun Tzu',
	'MOT_SUDOKU_LEVEL_4'			=> 'Napoleon',
	'MOT_SUDOKU_LEVEL_5'			=> 'Pythagoras',
	'MOT_SUDOKU_LEVEL_6'			=> 'Spartacus',

	// Results box
	'MOT_SUDOKU_YOUR_RESULT'		=> 'Your achievements',
	'MOT_SUDOKU_TOTAL_GAMES'		=> 'Totally solved puzzles',
	'MOT_SUDOKU_TOTAL_POINTS'		=> 'Totally obtained points',
	'MOT_SUDOKU_MEAN_POINTS'		=> 'Average points',
	'MOT_SUDOKU_GAINABLE_POINTS'	=> 'Optainable points in this game',
	'MOT_SUDOKU_CURRENT_POINTS'		=> 'Points in this game',
	'MOT_SUDOKU_NEGATIVE_POINTS'	=> 'Current negative points',

	// Highscore Tab
	'MOT_SUDOKU_SELECT_TYPE'		=> 'Choose Sudoku type',
	'MOT_SUDOKU_NO_ENTRIES'			=> 'No items',

	// Hall of Fame tab
	'MOT_SUDOKU_CURRENT_MONTH'		=> 'Current month',
	'MOT_SUDOKU_CURRENT_YEAR'		=> 'Current year',
	'MOT_SUDOKU_LAST_MONTHS'		=> [
		1	=> 'Last month',
		2	=> 'Last %1$d monthse',
	],
	'MOT_SUDOKU_LAST_YEARS'			=> [
		1	=> 'Last year',
		2	=> 'Last %1$d years',
	],

	// Online list
	'MOT_SUDOKU_TOTAL_PLAYERS'		=> [
		0	=> 'Currently there is no member playing Sudoku',
		1	=> 'Currently there is %1$d member playing Sudoku: ',
		2	=> 'Currently there are %1$d members playing Sudoku: ',
	],

	// Notes
	'MOT_SUDOKU_NOTES_TITLE'		=> 'Note',
	'MOT_SUDOKU_NOTES_QUIT'			=> 'The puzzle you have aborted has been deleted from the table holding your saved puzzles, you will be forwarded to a new puzzle in a few seconds.',
	'MOT_SUDOKU_QUIT_MSG_TITlE'		=> 'Confirmation',
	'MOT_SUDOKU_QUIT_MSG_TEXT'		=> 'Do you really want to abort this puzzle?',

	// Errors
	'MOT_SUDOKU_ERROR_TITLE'		=> 'Error!',
	'MOT_SUDOKU_ERROR_RESET'		=> 'Do you really want to reset this puzzle before trying for yourself?',
	'MOT_SUDOKU_ERROR_BUY_NOW'		=> 'Do you really want to buy a digit before trying for yourself?',
	'MOT_SUDOKU_BUY_LAST_DIGIT'		=> 'Do you really want to buy the last missing digit?',
	'MOT_SUDOKU_ERROR_HELPER'		=> 'Do you really want to use the helper before trying for yourself?',
	'MOT_SUDOKU_ERROR_QUIT'			=> 'Do you really want to abort this puzzle before trying for yourself?',
	'MOT_SUDOKU_ERROR_LEVEL'		=> 'Please select a new level first!',

	// PM texts
	'MOT_SUDOKU_WINNER_SUBJECT'		=> 'Reward for the best %1$s player!',
	'MOT_SUDOKU_WINNER_MESSAGE_0'	=> 'Hello %1$s,
you are yesterdays best %2$s player gaining %3$d points!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_WINNER_MESSAGE_1'	=> 'Hello %1$s,
you are last weeks best %2$s player gaining %3$d points!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_WINNER_MESSAGE_2'	=> 'Hello %1$s,
you are last months best %2$s player gaining %3$d points!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_WINNER_MESSAGE_3'	=> 'Hello %1$s,
you are last years best %2$s player gaining %3$d points!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',

	'MOT_SUDOKU_GAMES_SUBJECT'		=> 'Reward for the most solved puzzles in %1$s!',
	'MOT_SUDOKU_GAMES_MESSAGE_0'	=> 'Hello %1$s,
you solved the most %2$s puzzles (%3$d) yesterday!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_GAMES_MESSAGE_1'	=> 'Hello %1$s,
you solved the most %2$s puzzles (%3$d) last week!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_GAMES_MESSAGE_2'	=> 'Hello %1$s,
you solved the most %2$s puzzles (%3$d) last month!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_GAMES_MESSAGE_3'	=> 'Hello %1$s,
you solved the most %2$s puzzles (%3$d) last year!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',

	'MOT_SUDOKU_AVERAGE_SUBJECT'	=> 'Reward for the best average in %1$s!',
	'MOT_SUDOKU_AVERAGE_MESSAGE_0'	=> 'Hello %1$s,
you gained the highest average (%3$d) yesterday playing %2$s!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_AVERAGE_MESSAGE_1'	=> 'Hello %1$s,
you gained the highest average (%3$d) last week playing %2$s!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_AVERAGE_MESSAGE_2'	=> 'Hello %1$s,
you gained the highest average (%3$d) last month playing %2$s!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',
	'MOT_SUDOKU_AVERAGE_MESSAGE_3'	=> 'Hello %1$s,
you gained the highest average (%3$d) last year playing %2$s!
You were credited %4$s UP points for this achievement.

Congratulations
%5$s',

	'MOT_SUDOKU_ADMIN_SUBJECT_0'	=> 'Notification about daily Sudoku rewards',
	'MOT_SUDOKU_ADMIN_SUBJECT_1'	=> 'Notification about weekly Sudoku rewards',
	'MOT_SUDOKU_ADMIN_SUBJECT_2'	=> 'Notification about monthly Sudoku rewards',
	'MOT_SUDOKU_ADMIN_SUBJECT_3'	=> 'Notification about yearly Sudoku rewards',
	'MOT_SUDOKU_ADMIN_MESSAGE'		=> 'The rewards playing %1$s are going to
- the best player: %2$s gaining %3$d points (%4$s UP points)
- the most solved puzzles: %5$s solving %6$d puzzles (%7$s UP points)
- the highest average: %8$s gaining %9$d Points (%10$s UP points)

',

]);
