<?php
/**
*
* @package MoT Sudoku v0.2.0
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
	'MOT_SUDOKU_TAB_CLASSIC'		=> 'Klassisches Sudoku',
	'MOT_SUDOKU_TAB_SAMURAI'		=> 'Samurai-Sudoku',
	'MOT_SUDOKU_TAB_NINJA'			=> 'Ninja-Sudoku',

	// Classic Sudoku
	'MOT_SUDOKU_HISTORY_TITLE'		=> 'Geschichte des Spiels',
	'MOT_SUDOKU_HISTORY'			=> 'Die frühesten Vorläufer des Sudoku waren die lateinischen Quadrate des Schweizer Mathematikers Leonhard Euler, der solche bereits im 18.
										Jahrhundert verfasste.<br><br>Anders als die modernen Sudoku-Rätsel waren diese noch nicht in Blöcke (Unterquadrate) unterteilt. Der
										Neuseeländer Wayne Gould lernte Sudoku auf einer Japanreise kennen und brauchte sechs Jahre, um eine Software zu entwickeln, die neue
										Sudokus per Knopfdruck entwickeln konnte. Anschließend bot er seine Rätsel der Times in London an. Die Tageszeitung druckte die ersten
										Sudoku-Rätsel und trat auf diese Weise in der westlichen Welt eine Sudoku-Lawine los.',
	'MOT_SUDOKU_INSTRUCTIONS_TITLE'	=> 'Spielanleitung',
	'MOT_SUDOKU_INSTRUCTIONS'		=> 'Platzieren Sie eine Ziffer von 1-9 in jede leere Zelle so dass:<br><br>
										1. Jede Ziffer genau einmal pro Zeile auftaucht<br>
										2. Jede Ziffer genau einmal pro Spalte auftaucht<br>
										3. Jede Ziffer genau einmal in dem 3x3 Unterquadrat auftaucht.<br><br>
										Einige Startziffern wurden bereits gesetzt, um Ihnen beim Einstieg zu helfen, sie werden <strong>fett</strong> angezeigt. Klicken Sie einfach
										in eine leere Zelle, um eine Ziffer einzufügen. Wenn Sie einen Fehler gemacht haben, einfach nochmal auf das Feld klicken, um eine neue
										Ziffer einzufügen.',
	'MOT_SUDOKU_GAME_INFO'			=> 'Spielepaket:<strong>%1$s</strong>&nbsp;||&nbsp;Spiel:<strong>%2$s</strong>&nbsp;||&nbsp;Level:<strong>%3$s</strong>',
]);
