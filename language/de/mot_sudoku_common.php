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
	'MOT_SUDOKU_TAB_CLASSIC'		=> 'Klassisches Sudoku',
	'MOT_SUDOKU_TAB_SAMURAI'		=> 'Samurai-Sudoku',
	'MOT_SUDOKU_TAB_NINJA'			=> 'Ninja-Sudoku',

	// General terms
	'MOT_SUDOKU_CONGRATULATIONS'	=> 'Gratulation',
	'MOT_SUDOKU_PUZZLE_SOLVED'		=> '<strong>Du hast das Rätsel korrekt gelöst!</strong><br>
										Deine erreichte Punktzahl in diesem Spiel beträgt: ',
	'MOT_SUDOKU_BACK_TO_START'		=> '<br>Durch Anklicken eines der Tabs kannst du nun z.B. ein neues Spiel starten.',
	'MOT_SUDOKU_INCORRECT_END'		=> 'Deine Lösung war leider nicht ganz korrekt. Die falsch eingetragenen Ziffern wurden entfernt und die Minuspunkte dafür von deiner Punktzahl
										abgezogen.<br>
										Du hast jetzt Gelegenheit, die korrekten Ziffern einzutragen.',

	// Classic Sudoku
	'MOT_SUDOKU_NO_PUZZLES'			=> 'Es existieren derzeit keine Classic-Sudoku-Rätsel, der Administrator muss erst ein Spielepaket importieren!',
	'MOT_SUDOKU_HISTORY_TITLE'		=> 'Geschichte des Spiels',
	'MOT_SUDOKU_HISTORY'			=> 'Die frühesten Vorläufer des Sudoku waren die lateinischen Quadrate des Schweizer Mathematikers Leonhard Euler, der solche bereits im 18.
										Jahrhundert verfasste.<br><br>Anders als die modernen Sudoku-Rätsel waren diese noch nicht in Blöcke (Unterquadrate) unterteilt. Der
										Neuseeländer Wayne Gould lernte Sudoku auf einer Japanreise kennen und brauchte sechs Jahre, um eine Software zu entwickeln, die neue
										Sudokus per Knopfdruck entwickeln konnte. Anschließend bot er seine Rätsel der Times in London an. Die Tageszeitung druckte die ersten
										Sudoku-Rätsel und trat auf diese Weise in der westlichen Welt eine Sudoku-Lawine los.',
	'MOT_SUDOKU_INSTRUCTIONS_TITLE'	=> 'Spielanleitung',
	'MOT_SUDOKU_INSTRUCTIONS'		=> 'Platziere eine Ziffer von 1-9 in jede leere Zelle so dass:<br><br>
										1. Jede Ziffer genau einmal pro Zeile auftaucht<br>
										2. Jede Ziffer genau einmal pro Spalte auftaucht<br>
										3. Jede Ziffer genau einmal in dem 3x3 Unterquadrat auftaucht.<br><br>
										Einige Startziffern wurden bereits gesetzt, um dir beim Einstieg zu helfen, sie werden <strong>fett</strong> angezeigt. Klicke einfach
										in eine leere Zelle, um eine Ziffer einzufügen. Wenn Du einen Fehler gemacht hast, einfach nochmal auf das Feld klicken, um eine neue
										Ziffer einzufügen.',
	'MOT_SUDOKU_GAME_INFO'			=> 'Spielepaket:&nbsp;<strong>%1$s</strong>&nbsp;||&nbsp;Spiel:&nbsp;<strong>%2$s</strong>&nbsp;||&nbsp;Schwierigkeitsgrad:&nbsp;<strong>%3$s</strong>',

	// Samurai Sudoku
	'MOT_SUDOKU_SAMURAI_TEXT'		=> 'Wem die klassischen Sudoku-Rätsel zu einfach sind, kann sich an dem deutlich komplexeren Samurai-Sudoku versuchen. Hier überschneiden sich
										5 klassische Rätsel jeweils an den Ecken. Du denkst, das ist das Gleiche wie 5 klassische Rätsel? Dann versuche es und zeige, dass du ein
										wahrer Samurai bist!',

	// Ninja Sudoku
	'MOT_SUDOKU_NINJA_TEXT'			=> 'Ninja-Sudoku sind eine echte Herausforderung, weil sie aus insgesamt 9 klassischen Rätseln bestehen, die sich natürlich öfter überschneiden,
										nämlich zwischen zwei- bis viermal. Sie sind damit äußerst schwierig, aber für einen echten Ninja sicher ein Klacks!',

	// Options box
	'MOT_SUDOKU_OPTIONS_TITLE'		=> 'Optionen',
	'MOT_SUDOKU_GAME_RESET'			=> 'Spiel zurücksetzen',
	'MOT_SUDOKU_GAME_RESET_TITLE'	=> 'Das Zurücksetzen des Spiels kostet %1$d Minuspunkte',
	'MOT_SUDOKU_BUY_NUMBER'			=> 'Ziffer kaufen',
	'MOT_SUDOKU_BUY_NUMBER_TITLE'	=> 'Der Kauf einer Ziffer kostet %1$d Minuspunkte',
	'MOT_SUDOKU_ENABLE_HELPER'		=> 'Helfer aktivieren',
	'MOT_SUDOKU_HELPER_TITLE'		=> 'Die Aktivierung des Helfers kostet einmalig %1$d Minuspunkte',
	'MOT_SUDOKU_HELPER_UPDATE'		=> 'Helfer aktualisieren',
	'MOT_SUDOKU_MASK_HELPER'		=> 'Helfer ausblenden',
	'MOT_SUDOKU_MASK_TITLE'			=> 'Blendet die Hilfe in den Zellen aus',
	'MOT_SUDOKU_HELPER_NOTE'		=> 'Die Helfer-Anzeige gilt nur für den aktuellen Spielstand, nach Veränderungen (z.B. Eingabe einer Ziffer) muss der Helfer aktualisiert werden.',
	'MOT_SUDOKU_MODAL_ABOVE'		=> 'Zifferneingabe oberhalb Spielfeld',
	'MOT_SUDOKU_MODAL_OVER'			=> 'Zifferneingabe über Mauszeiger',

	// Notes box
	'MOT_SUDOKU_NOTE_TITLE'			=> 'Hinweise',
	'MOT_SUDOKU_NOTE_TEXT'			=> 'Für jede neu gesetzte Ziffer erhältst du %1$d Punkte. Aber Vorsicht! Jedes Mal, wenn du eine Ziffer löschst oder änderst, werden dir direkt
										%2$d Punkte abgezogen!<br><br>
										Du kannst auch eine Ziffer für %3$d Punkte kaufen, wenn du absolut nicht weiter weißt; sie wird in eine zufällig gewählte freie Zelle gesetzt.<br>
										Wenn du das Spiel zurück setzt (neu beginnst), kostet dich das %4$d Punkte. Bereits gekaufte Ziffern bleiben dir erhalten.<br>
										Das Aktivieren des Helfers kostet dich für jedes Spiel %5$d Punkte, die Aktivierung gilt für die gesamte Dauer dieses Spieles.<br>
										Du kannst den Level für dieses Spiel vor dem ersten Eintragen einer Ziffer ändern, es werden dir dann je nach gewähltem Level zusätzliche
										Ziffern angezeigt. Allerdings verringert sich die mögliche Maximalpunktzahl für dieses Spiel dann um %6$d Punkte für jede Ziffer.',

	// Levels box
	'MOT_SUDOKU_LEVEL_TITLE'		=> 'Spiele-Level',
	'MOT_SUDOKU_SELECT_LEVEL'		=> 'Wähle deinen Level',
	'MOT_SUDOKU_LEVEL_NAME'			=> 'Level',
	'MOT_SUDOKU_LEVEL_DIGITS'		=> 'Zusätzliche Ziffern',
	'MOT_SUDOKU_LEVEL_DEDUCT'		=> 'Punktabzug',
	'MOT_SUDOKU_LEVEL_0'			=> 'Einstein',
	'MOT_SUDOKU_LEVEL_1'			=> 'Lasker',
	'MOT_SUDOKU_LEVEL_2'			=> 'Lomonosov',
	'MOT_SUDOKU_LEVEL_3'			=> 'Sun Tzu',
	'MOT_SUDOKU_LEVEL_4'			=> 'Napoleon',
	'MOT_SUDOKU_LEVEL_5'			=> 'Pythagoras',
	'MOT_SUDOKU_LEVEL_6'			=> 'Spartacus',

	// Results box
	'MOT_SUDOKU_YOUR_RESULT'		=> 'Deine Ergebnisse',
	'MOT_SUDOKU_TOTAL_GAMES'		=> 'Insgesamt gespielte Spiele',
	'MOT_SUDOKU_TOTAL_POINTS'		=> 'Insgesamt erzielte Punkte',
	'MOT_SUDOKU_MEAN_POINTS'		=> 'Durchschnittliche Punktzahl',
	'MOT_SUDOKU_GAINABLE_POINTS'	=> 'Erreichbare Punkte im aktuellen Spiel',
	'MOT_SUDOKU_CURRENT_POINTS'		=> 'Punkte im aktuellen Spiel',
	'MOT_SUDOKU_NEGATIVE_POINTS'	=> 'Aktuelle Minuspunkte',

	// Online list
	'MOT_SUDOKU_TOTAL_PLAYERS'		=> [
		0	=> 'Es gibt derzeit keine aktiven Sudoku-Spieler',
		1	=> 'Es gibt derzeit %1$d aktiven Sudoku-Spieler: ',
		2	=> 'Es gibt derzeit %1$d aktive Sudoku-Spieler: ',
	],

	// Errors
	'MOT_SUDOKU_ERROR_TITLE'		=> 'Fehler!',
	'MOT_SUDOKU_ERROR_RESET'		=> 'Du willst nicht wirklich ein Spiel zurücksetzen, in dem du noch keine Eintragung gemacht hast, oder?',
	'MOT_SUDOKU_ERROR_BUY_NOW'		=> 'Willst du wirklich schon eine Ziffer kaufen, bevor du es selbst versucht hast?',
	'MOT_SUDOKU_ERROR_HELPER'		=> 'Willst du wirklich schon den Helfer benutzen, bevor du es selbst versucht hast?',
	'MOT_SUDOKU_ERROR_LEVEL'		=> 'Du musst erst einen neuen Level auswählen!',
]);
