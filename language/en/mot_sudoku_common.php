<?php
/**
*
* @package MoT Sudoku v0.3.0
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

	// General terms
	'MOT_SUDOKU_CONGRATULATIONS'	=> 'Congratulations',
	'MOT_SUDOKU_PUZZLE_SOLVED'		=> '<strong>You solved this puzzle!</strong><br>
										Points you gained in this game: ',
	'MOT_SUDOKU_BACK_TO_START'		=> '<br>By clicking one of the above tabs you can e.g. start a new game.',
	'MOT_SUDOKU_INCORRECT_END'		=> 'Unfortunately your solution was not entirely correct. Incorrect digits were deleted and the points for their deletion deducted from your
										points.<br>
										Please take the opportunity to enter the correct digits.',

	// Classic Sudoku
	'MOT_SUDOKU_NO_PUZZLES'			=> 'Currently there are no Classic Sudoku puzzles avaiable, a game pack must be imported by the administrator!',
	'MOT_SUDOKU_HISTORY_TITLE'		=> 'History of this game',
	'MOT_SUDOKU_HISTORY'			=> 'Die frühesten Vorläufer des Sudoku waren die lateinischen Quadrate des Schweizer Mathematikers Leonhard Euler, der solche bereits im 18.
										Jahrhundert verfasste.<br><br>Anders als die modernen Sudoku-Rätsel waren diese noch nicht in Blöcke (Unterquadrate) unterteilt. Der
										Neuseeländer Wayne Gould lernte Sudoku auf einer Japanreise kennen und brauchte sechs Jahre, um eine Software zu entwickeln, die neue
										Sudokus per Knopfdruck entwickeln konnte. Anschließend bot er seine Rätsel der Times in London an. Die Tageszeitung druckte die ersten
										Sudoku-Rätsel und trat auf diese Weise in der westlichen Welt eine Sudoku-Lawine los.',
	'MOT_SUDOKU_INSTRUCTIONS_TITLE'	=> 'Rules and instruction',
	'MOT_SUDOKU_INSTRUCTIONS'		=> 'Platziere eine Ziffer von 1-9 in jede leere Zelle so dass:<br><br>
										1. Jede Ziffer genau einmal pro Zeile auftaucht<br>
										2. Jede Ziffer genau einmal pro Spalte auftaucht<br>
										3. Jede Ziffer genau einmal in dem 3x3 Unterquadrat auftaucht.<br><br>
										Einige Startziffern wurden bereits gesetzt, um dir beim Einstieg zu helfen, sie werden <strong>fett</strong> angezeigt. Klicke einfach
										in eine leere Zelle, um eine Ziffer einzufügen. Wenn Du einen Fehler gemacht hast, einfach nochmal auf das Feld klicken, um eine neue
										Ziffer einzufügen.',
	'MOT_SUDOKU_GAME_INFO'			=> 'Game pack:<strong>%1$s</strong>&nbsp;||&nbsp;Game:<strong>%2$s</strong>&nbsp;||&nbsp;Level:<strong>%3$s</strong>',

	// Samurai Sudoku
	'MOT_SUDOKU_SAMURAI_TEXT'		=> 'Wem die klassischen Sudoku-Rätsel zu einfach sind, kann sich an dem deutlich komplexeren Samurai-Sudoku versuchen. Hier überschneiden sich
										5 klassische Rätsel jeweils an den Ecken. Du denkst, das ist das Gleiche wie 5 klassische Rätsel? Dann versuche es und zeige, dass du ein
										wahrer Samurai bist!',

	// Ninja Sudoku
	'MOT_SUDOKU_NINJA_TEXT'			=> 'Ninja-Sudoku sind eine echte Herausforderung, weil sie aus insgesamt 9 klassischen Rätseln bestehen, die sich natürlich öfter überschneiden,
										nämlich zwischen zwei- bis viermal. Sie sind damit äußerst schwierig, aber für einen echten Ninja sicher ein Klacks!',

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
	'MOT_SUDOKU_MODAL_ABOVE'		=> 'Digit input above puzzle',
	'MOT_SUDOKU_MODAL_OVER'			=> 'Digit input at mouse pointer',

	// Notes box
	'MOT_SUDOKU_NOTE_TITLE'			=> 'Notes',
	'MOT_SUDOKU_NOTE_TEXT'			=> 'For every digit you place you earn %1$d points. But be careful! Every time you delete or change a digit you will instantly get deducted
										%2$d points!<br><br>
										If you really happen to be at the end of one`s rope you can buy a digit at the cost of %3$d points, the (empty) cell it will be placed in
										is chosen by chance.<br>
										Resetting the puzzel (start from scratch) will cost you %4$d negative points. You will keep digits already bought.<br>
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

	// Online list
	'MOT_SUDOKU_TOTAL_PLAYERS'		=> [
		0	=> 'Currently there is no member playing Sudoku',
		1	=> 'Currently there is %1$d member playing Sudoku: ',
		2	=> 'Currently there are %1$d members playing Sudoku: ',
	],

	// Errors
	'MOT_SUDOKU_ERROR_TITLE'		=> 'Error!',
	'MOT_SUDOKU_ERROR_RESET'		=> 'Do you really want to reset this game before trying for yourself?',
	'MOT_SUDOKU_ERROR_BUY_NOW'		=> 'Do you really want to buy a digit before trying for yourself?',
	'MOT_SUDOKU_ERROR_HELPER'		=> 'Do you really want to use the helper before trying for yourself?',
	'MOT_SUDOKU_ERROR_LEVEL'		=> 'Please select a new level first!',
]);
