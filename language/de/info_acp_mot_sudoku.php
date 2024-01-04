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
	'ACP_MOT_SUDOKU'						=> 'Sudoku',
	'ACP_MOT_SUDOKU_SETTINGS'				=> 'Einstellungen',

	'ACP_MOT_SUDOKU_VERSION'				=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic"><br>&copy; 2023 - %2$d by Mike-on-Tour',
	'SUPPORT_MOT_SUDOKU'					=> 'Wenn du die Entwicklung des Sudoku-Spiels unterstützen möchtest, kannst du das hier tun:<br>',

	'ACP_MOT_SUDOKU_CONFIGURATION'			=> 'Sudoku Administration',
	'ACP_MOT_SUDOKU_GENERAL'				=> 'Allgemeine Einstellungen',
	'ACP_MOT_SUDOKU_GENERAL_EXPL'			=> 'Hier werden die allgemeinen Einstellungen vorgenommen',

	'ACP_MOT_SUDOKU_VERSION_CHECK'			=> 'Sudoku Versionsprüfung',
	'ACP_MOT_SUDOKU_VERSION_CHECK_EXPL'		=> 'Überprüft, ob eine neuere Version von Sudoku verfügbar ist',
	'ACP_MOT_SUDOKU_VERSION_UP_TO_DATE'		=> 'Deine Version von Sudoku ist auf dem neuesten Stand.',
	'ACP_MOT_SUDOKU_VERSION_OUTDATED'		=> 'Deine Version von Sudoku ist veraltet, ein Update ist verfügbar.',
	'ACP_MOT_SUDOKU_CURRENT_VERSION'		=> 'Installierte Version',
	'ACP_MOT_SUDOKU_LATEST_VERSION'			=> 'Verfügbare neueste Version',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_ON'		=> 'Automatische Versionsüberprüfung',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_EXPL'	=> 'Bei Aktivierung dieser Option wird bei jedem Aufruf dieser Seite geprüft, ob eine neuere Version verfügbar ist; das Ergebnis wird
												in einer farbigen Box oberhalb von `Allgemeine Einstellungen` angezeigt.',

	'ACP_MOT_SUDOKU_ENABLE'					=> 'Sudoku aktivieren',
	'ACP_MOT_SUDOKU_ENABLE_EXPL'			=> 'Sudoku für die berechtigten Mitglieder ein- bzw. ausschalten, zeigt je nach Einstellung den Link in der Navigationsleiste an.',

	'ACP_MOT_SUDOKU_CACHE_ENABLE'			=> 'Cache aktivieren',
	'ACP_MOT_SUDOKU_CACHE_ENABLE_EXPL'		=> 'Der Cache reduziert die Abfragen auf dem Datenbank-Server',
	'ACP_MOT_SUDOKU_PURGE_CACHE'			=> 'Sudoku-Cache leeren',
	'ACP_MOT_SUDOKU_PURGE_CACHE_MSG'		=> 'Sudoku-Cache wurde geleert',
	'ACP_MOT_SUDOKU_PURGE_CACHE_LOG'		=> '<strong>Sudoku-Cache geleert</strong>',

	'ACP_MOT_SUDOKU_PUZZLE_TITLE'			=> 'Zeige Puzzle Titel',
	'ACP_MOT_SUDOKU_PUZZLE_TITLE_EXPL'		=> 'Zeigt den Titel des aktuellen Spiels an.',

	'ACP_MOT_SUDOKU_HELPER_ENABLE'			=> 'Sudoku Helfer aktivieren',
	'ACP_MOT_SUDOKU_HELPER_ENABLE_EXPL'		=> 'Erlaubt es den Spielern, ein Hilfefenster mit Lösungsvorschlägen für die einzelnen Felder zu benutzen',
	'ACP_MOT_SUDOKU_HELPER_COST'			=> 'Punkte, die für das Aktivieren des Helfers abgezogen werden',
	'ACP_MOT_SUDOKU_HELPER_POINTS_NAME'		=> 'Punkte',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_ENABLE'	=> 'Samurai Helfer aktivieren',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_COST'	=> 'Punkte, die für das Aktivieren des Samurai Helfers abgezogen werden',
	'ACP_MOT_SUDOKU_HELPER_NINJA_ENABLE'	=> 'Ninja Helfer aktivieren',
	'ACP_MOT_SUDOKU_HELPER_NINJA_COST'		=> 'Punkte, die für das Aktivieren des Ninja Helfers abgezogen werden',

	'ACP_MOT_SUDOKU_LEVEL_COST'				=> 'Punktabzug für Schwierigkeitsgrad',
	'ACP_MOT_SUDOKU_LEVEL_COST_EXPL'		=> 'Anzahl der Punkte, die pro gewähltem Schwierigkeitsgrad abgezogen werden.',

	'ACP_MOT_SUDOKU_POINTS_ENABLE'			=> 'Aktivere das Punkte-System',
	'ACP_MOT_SUDOKU_POINTS_ENABLE_EXPL'		=> 'Wenn ein Punkte-System (z.B. ´Ultimate Points´) auf deinem Board installiert ist, werden die Punkte vom Sudoku dem Spielekonto
												hinzugefügt bzw. von dort auch abgezogen.<br>
												Nach Aktivierung werden dafür weitere Einstellmöglichkeiten angezeigt.',

	'ACP_MOT_SUDOKU_POINTS_RATIO' 			=> 'Verhältnis Punkte Sudoku zu Punkte-System',
	'ACP_MOT_SUDOKU_POINTS_RATIO_EXPL' 		=> 'Lege fest, wieviele Punkte dem Benutzerkonto pro 100 Sudoku Punkte gutgeschrieben werden sollen.',

	'ACP_MOT_SUDOKU_REWARD_ON'				=> 'Sudoku Bonussystem aktivieren',
	'ACP_MOT_SUDOKU_REWARD_ON_EXPL'			=> 'Periodische Kalkulation der Spielergebnisse und die Bonuszahlungen.',

	'ACP_MOT_SUDOKU_REWARD_GC'				=> 'Zeitintervall zwischen zwei Bonusberechnungen (in Sekunden)',
	'ACP_MOT_SUDOKU_REWARD_GC_EXPL'			=> 'Der Abstand zwischen zwei Cronjobs zum Ermitteln der Gewinner für die Bonuszahlung in Sekunden.',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC'			=> 'Zeitpunkt der letzten Berechnung',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC_EXPL'	=> 'Zeitpunkt der letzten Berechnung der Bonuszahlungen.',
	'ACP_MOT_SUDOKU_REWARD_NEXT_GC'			=> 'Zeitpunkt der nächsten Berechnung',
	'ACP_MOT_SUDOKU_REWARD_NEXT_GC_EXPL'	=> 'Voraussichtlicher Zeitpunkt der nächsten Bonuskalkulation und Auszahlung<br>
												(voraussichtlich, weil das Forum zu diesem Zeitpunkt aktiv genutzt werden muss, ist niemand eingeloggt, erfolgt die
												Berechnung sobald jemand das Forum aufruft).',
	'ACP_MOT_SUDOKU_RANK1'					=> 'Bonus für 1. Platz',
	'ACP_MOT_SUDOKU_RANK1_EXPL'				=> 'Bonus für den erstplatzierten Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_RANK2'					=> 'Bonus für 2. Platz',
	'ACP_MOT_SUDOKU_RANK2_EXPL'				=> 'Bonus für den zweitplatzierten Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_RANK3'					=> 'Bonus für 3. Platz',
	'ACP_MOT_SUDOKU_RANK3_EXPL'				=> 'Bonus für den drittplatzierten Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE'			=> 'Bonus für besten Durchschnitt',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE_EXPL'		=> 'Bonus für den Spieler mit dem höchsten Durchnitt in der laufenden Periode.',
	'ACP_MOT_SUDOKU_MOST_GAMES'				=> 'Bonus für die meisten Spiele',
	'ACP_MOT_SUDOKU_MOST_GAMES_EXPL'		=> 'Bonus für den Spieler mit der höchsten Anzahl an Spielen in der laufenden Periode.',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE'			=> 'Bonus für den besten Samurai Spieler',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE_EXPL'		=> 'Bonus für den besten Samurai Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_NINJA_PRICE'			=> 'Bonus für den besten Ninja Spieler',
	'ACP_MOT_SUDOKU_NINJA_PRICE_EXPL'		=> 'Bonus für den besten Ninja Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_PM_ENABLE'				=> 'Persönliche Nachricht aktivieren',
	'ACP_MOT_SUDOKU_PM_ENABLE_EXPL'			=> 'Die Gewinner werden per PN über ihren Gewinn informiert.',
	'ACP_MOT_SUDOKU_ADMIN_LIST'				=> 'Administrator für das Sudoko Bonussystem',
	'ACP_MOT_SUDOKU_ADMIN_LIST_EXPL'		=> 'Ein Board Administrator oder Moderator, der die regelmäßigen Reports erhält und dessen Name als Absender in der PN für die Gewinner erscheint',

	'ACP_MOT_SUDOKU_UPLOAD_XML'				=> 'Lokales Sudoku-Pack (xml-Datei) importieren',
	'ACP_MOT_SUDOKU_UPLOAD_XML_EXP'			=> 'Hier kannst du ein auf deinem PC gespeichertes Sudoku-Pack in die Datenbank importieren und neue Sudoku-Rätsel zum Spielen bereit
												stellen.<br>Bitte beachte, dass nur Spiele-Packs importiert werden können, die dem auf mike-on-tour.com definierten Schema
												entsprechen!<br>
												Um doppelte Spiele zu vermeiden, werden die Nummern des Spiele-Packs und der darin enthaltenen Spiele vor dem Import mit der
												Datenbank abgeglichen.',
	'ACP_MOT_SUDOKU_UPLOAD'					=> 'Sudoku-Pack importieren',
	'ACP_MOT_SUDOKU_INVALID_FILE_EXT'		=> 'Ungültige Datei-Erweiterung.',
	'ACP_MOT_SUDOKU_INVALID_FILE_CONTENT'	=> 'Datei ist fehlerhaft, Laden abgebrochen.',
	'ACP_MOT_SUDOKU_CLASSIC_IMPORTED'		=> [
		0	=> 'Es wurden keine Classic-Sudoku-Rätsel importiert.',
		1	=> 'Es wurde %1$d Classic-Sudoku-Rätsel importiert.',
		2	=> 'Es wurden %1$d Classic-Sudoku-Rätsel importiert.',
	],
	'ACP_MOT_SUDOKU_SAMURAI_IMPORTED'		=> [
		0	=> 'Es wurden keine Samurai-Sudoku-Rätsel importiert.',
		1	=> 'Es wurde %1$d Samurai-Sudoku-Rätsel importiert.',
		2	=> 'Es wurden %1$d Samurai-Sudoku-Rätsel importiert.',
	],
	'ACP_MOT_SUDOKU_NINJA_IMPORTED'		=> [
		0	=> 'Es wurden keine Ninja-Sudoku-Rätsel importiert.',
		1	=> 'Es wurde %1$d Ninja-Sudoku-Rätsel importiert.',
		2	=> 'Es wurden %1$d Ninja-Sudoku-Rätsel importiert.',
	],

	'ACP_MOT_SUDOKU_RESET_GAME'				=> 'Alle Spieledaten löschen',
	'ACP_MOT_SUDOKU_RESET_GAME_EXPL'		=> '<font color=red>Nach Anklicken des `Löschen`-Buttons werden <strong>ALLE</strong> Statistiken, Ergebnisse und Zwischenergebnisse
												gelöscht und auf den Anfangszustand zurückgesetzt.</font>',
	'ACP_MOT_SUDOKU_RESET_GAME_CONFIRM_MSG'	=> 'Willst du wirklich alle Spieledaten löschen?',
	'ACP_MOT_SUDOKU_RESET_SUCCESS'			=> 'Es wurden sämtliche Daten gelöscht',
	'ACP_MOT_SUDOKU_LOG_RESET_GAME'			=> '<strong>Sudoku Spieledaten gelöscht</strong>',

	'ACP_MOT_SUDOKU_SETTING_SAVED'			=> 'Die Einstellungen für das Sudoku-Spiel wurden erfolgreich gesichert.',
	'ACP_MOT_SUDOKU_LOG_SETTING_SAVED'		=> '<strong>Einstellungen für das Sudoku-Spiel geändert</strong>',
]);
