<?php
/**
*
* @package MoT Sudoku v0.11.0
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
	'ACP_MOT_SUDOKU_GAMEPACKS'				=> 'Spielepakete',

	'ACP_MOT_SUDOKU_VERSION'				=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic"><br>&copy; 2023 - %2$d by Mike-on-Tour',
	'SUPPORT_MOT_SUDOKU'					=> 'Wenn Sie die Entwicklung des Sudoku-Spiels unterstützen möchten, können Sie das hier tun:<br>',

	// Settings tab
	'ACP_MOT_SUDOKU_GENERAL'				=> 'Allgemeine Einstellungen',
	'ACP_MOT_SUDOKU_GENERAL_EXPL'			=> 'Hier werden die allgemeinen Einstellungen vorgenommen',

	'ACP_MOT_SUDOKU_GENERAL_SETTINGS'		=> 'Allgemeine Einstellungen',
	'ACP_MOT_SUDOKU_ENABLE'					=> 'Sudoku aktivieren',
	'ACP_MOT_SUDOKU_ENABLE_EXPL'			=> 'Sudoku für die berechtigten Mitglieder ein- bzw. ausschalten, zeigt je nach Einstellung den Link in der Navigationsleiste an.<br>
												Diese Einstellung gilt nicht für Gründer, diese können Sudoku immer sehen.',
	'ACP_MOT_SUDOKU_VERSION_CHECK'			=> 'Sudoku Versionsprüfung',
	'ACP_MOT_SUDOKU_VERSION_CHECK_EXPL'		=> 'Überprüft, ob eine neuere Version von Sudoku verfügbar ist',
	'ACP_MOT_SUDOKU_VERSION_UP_TO_DATE'		=> 'Ihre Version von Sudoku ist auf dem neuesten Stand.',
	'ACP_MOT_SUDOKU_VERSION_OUTDATED'		=> 'Ihre Version von Sudoku ist veraltet, ein Update ist verfügbar.',
	'ACP_MOT_SUDOKU_CURRENT_VERSION'		=> 'Installierte Version',
	'ACP_MOT_SUDOKU_LATEST_VERSION'			=> 'Verfügbare neueste Version',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_ON'		=> 'Automatische Versionsüberprüfung',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_EXPL'	=> 'Bei Aktivierung dieser Option wird bei jedem Aufruf dieser Seite geprüft, ob eine neuere Version verfügbar ist; das Ergebnis wird
												in einer farbigen Box oberhalb von `Allgemeine Einstellungen` angezeigt.',
	'ACP_MOT_SUDOKU_ENABLE_RANK'			=> 'Anzeige der Rangliste',
	'ACP_MOT_SUDOKU_ENABLE_RANK_EXPL'		=> 'Diese Einstellung schaltet die Anzeige der Rangliste ein oder aus.',
	'ACP_MOT_SUDOKU_ENABLE_FAME'			=> 'Anzeige der Ruhmeshalle',
	'ACP_MOT_SUDOKU_ENABLE_FAME_EXPL'		=> 'Diese Einstellung schaltet die Anzeige der Ruhmeshalle ein oder aus.<br>
												Wenn aktiviert, wird ein weiteres Eingabefeld angezeigt, mit dem die Anzahl der anzuzeigenden Spieler ausgewählt wird',
	'ACP_MOT_SUDOKU_FAME_LIMIT'				=> 'Anzahl der anzuzeigenden Spieler pro Tabelle der Ruhmeshalle',
	'ACP_MOT_SUDOKU_FAME_LIMIT_EXP'			=> 'Hier können Sie auswählen wie viele Spieler in den Tabellen der Ruhmeshalle angezeigt werden sollen.',
	'ACP_MOT_SUDOKU_PUZZLE_TITLE'			=> 'Zeige Puzzle Titel',
	'ACP_MOT_SUDOKU_PUZZLE_TITLE_EXPL'		=> 'Zeigt den Titel des aktuellen Spiels an.',
	'ACP_MOT_SUDOKU_ROWS_PER_PAGE'			=> 'Zeilen pro Tabellenseite für Spielepakete',
	'ACP_MOT_SUDOKU_ROWS_PER_PAGE_EXP'		=> 'Wähle hier die Anzahl der Zeilen, die bei der Anzeige der Spielepakete pro Tabellenseite angezeigt werden soll.',

	'ACP_MOT_SUDOKU_POINTS_SETTINGS'		=> 'Einstellungen für Punktevergabe',
	'ACP_MOT_SUDOKU_CELL_POINTS'			=> 'Punkte für Eingabe',
	'ACP_MOT_SUDOKU_CELL_POINTS_EXPL'		=> 'Die Anzahl der Punkte, die einem Spieler bei der Eingabe einer Ziffer in eine Zelle des Rätsels gutgeschrieben werden.',
	'ACP_MOT_SUDOKU_CELL_COST'				=> 'Punktabzug für Löschen',
	'ACP_MOT_SUDOKU_CELL_COST_EXPL'			=> 'Anzahl der Punkte, die einem Spieler abgezogen werden, wenn er eine bereits existierende Ziffer in einer Zelle entweder löscht
												oder mit einer anderen Ziffer überschreibt.',
	'ACP_MOT_SUDOKU_NUMBER_COST'			=> 'Punktabzug für Kauf einer Ziffer',
	'ACP_MOT_SUDOKU_NUMBER_COST_EXPL'		=> 'Anzahl der Punkte, die einem Spieler für den Kauf einer Ziffer abgezogen werden.',
	'ACP_MOT_SUDOKU_RESET_COST'				=> 'Punktabzug für Neustart des Spiels',
	'ACP_MOT_SUDOKU_RESET_COST_EXPL'		=> 'Anzahl der Punkte, die einem Spieler abgezogen werden, wenn er das aktuelle Spiel neu startet.',
	'ACP_MOT_SUDOKU_LEVEL_COST'				=> 'Punktabzug für niedrigeren Schwierigkeitsgrad',
	'ACP_MOT_SUDOKU_LEVEL_COST_EXPL'		=> 'Anzahl der Punkte, die pro gewähltem niedrigerem Schwierigkeitsgrad abgezogen werden.',

	'ACP_MOT_SUDOKU_HELPER_SETTINGS'		=> 'Hilfe-Einstellungen',
	'ACP_MOT_SUDOKU_HELPER_ENABLE'			=> 'Sudoku Helfer aktivieren',
	'ACP_MOT_SUDOKU_HELPER_ENABLE_EXPL'		=> 'Erlaubt es den Spielern, ein Hilfefenster mit Lösungsvorschlägen für die einzelnen Felder zu benutzen',
	'ACP_MOT_SUDOKU_HELPER_COST'			=> 'Punkte, die für das Aktivieren des Helfers abgezogen werden',
	'ACP_MOT_SUDOKU_HELPER_POINTS_NAME'		=> 'Punkte',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_ENABLE'	=> 'Samurai Helfer aktivieren',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_COST'	=> 'Punkte, die für das Aktivieren des Samurai Helfers abgezogen werden',
	'ACP_MOT_SUDOKU_HELPER_NINJA_ENABLE'	=> 'Ninja Helfer aktivieren',
	'ACP_MOT_SUDOKU_HELPER_NINJA_COST'		=> 'Punkte, die für das Aktivieren des Ninja Helfers abgezogen werden',

	'ACP_MOT_SUDOKU_UP_SETTINGS'			=> 'Einstellungen Punkte-System',
	'ACP_MOT_SUDOKU_POINTS_ENABLE'			=> 'Punkte-System aktivieren',
	'ACP_MOT_SUDOKU_POINTS_ENABLE_EXPL'		=> 'Wenn ein Punkte-System (z.B. ´Ultimate Points´) auf Ihrem Board installiert ist, werden die Punkte vom Sudoku dem Spielekonto
												hinzugefügt bzw. von dort auch abgezogen.<br>
												Nach Aktivierung werden dafür weitere Einstellmöglichkeiten angezeigt.',
	'ACP_MOT_SUDOKU_POINTS_RATIO' 			=> 'Verhältnis Punkte Sudoku zu Punkte-System',
	'ACP_MOT_SUDOKU_POINTS_RATIO_EXPL' 		=> 'Legt fest, wieviele Punkte dem Benutzerkonto des Punkte-Systems pro %1$d Sudoku-Punkte gutgeschrieben werden sollen.',

	'ACP_MOT_SUDOKU_REWARD_SETTINGS'		=> 'Einstellungen für Bonussystem',
	'ACP_MOT_SUDOKU_REWARD_ON'				=> 'Sudoku Bonussystem aktivieren',
	'ACP_MOT_SUDOKU_REWARD_ON_EXPL'			=> 'Periodische Kalkulation der Bonuszahlungen aktivieren.',
	'ACP_MOT_SUDOKU_REWARD_TIME'			=> 'Zeitintervall zwischen zwei Bonusberechnungen',
	'ACP_MOT_SUDOKU_REWARD_TIME_EXPL'		=> 'Der Abstand zwischen zwei Berechnungen zum Ermitteln der Gewinner für die Bonuszahlung.',
	'ACP_MOT_SUDOKU_DAILY'					=> 'Täglich',
	'ACP_MOT_SUDOKU_WEEKLY'					=> 'Wöchentlich',
	'ACP_MOT_SUDOKU_MONTHLY'				=> 'Monatlich',
	'ACP_MOT_SUDOKU_YEARLY'					=> 'Jährlich',
	'ACP_MOT_SUDOKU_WEEK_START'				=> 'Auswahl Wochentag für wöchentliche Berechnung',
	'ACP_MOT_SUDOKU_WEEK_START_EXPL'		=> 'Wählen Sie hier bei wöchentlicher Berechnung der Bonuszahlung den Wochentag aus, an dem die Berechnung erfolgen soll.',
	'ACP_MOT_SUDOKU_SUNDAY'					=> 'Sonntag',
	'ACP_MOT_SUDOKU_MONDAY'					=> 'Montag',
	'ACP_MOT_SUDOKU_TUESDAY'				=> 'Dienstag',
	'ACP_MOT_SUDOKU_WEDNESDAY'				=> 'Mittwoch',
	'ACP_MOT_SUDOKU_THURSDAY'				=> 'Donnerstag',
	'ACP_MOT_SUDOKU_FRIDAY'					=> 'Freitag',
	'ACP_MOT_SUDOKU_SATURDAY'				=> 'Samstag',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC'			=> 'Zeitpunkt der letzten Laufes des Cron-Tasks',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC_EXPL'	=> 'Zeitpunkt des letzten Laufes des Cron-Tasks zur Berechnung der Bonuszahlungen. Diese Angabe bezieht sich nur auf die Ausführung
												des Cron-Tasks und sagt nichts über den Zeitpunkt der letzten Berechnung bzw. Gutschrift aus.',
	'ACP_MOT_SUDOKU_CLASSIC_PRICE'			=> 'Bonus für besten Klassik Spieler',
	'ACP_MOT_SUDOKU_CLASSIC_PRICE_EXPL'		=> 'Bonus für den besten Klassik Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE'			=> 'Bonus für den besten Samurai Spieler',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE_EXPL'		=> 'Bonus für den besten Samurai Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_NINJA_PRICE'			=> 'Bonus für den besten Ninja Spieler',
	'ACP_MOT_SUDOKU_NINJA_PRICE_EXPL'		=> 'Bonus für den besten Ninja Spieler in der laufenden Periode.',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE'			=> 'Bonus für besten Durchschnitt',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE_EXPL'		=> 'Bonus für den Spieler mit dem höchsten Durchschnitt in der laufenden Periode. Dieser Preis wird für alle Rätseltypen vergeben.',
	'ACP_MOT_SUDOKU_MOST_GAMES'				=> 'Bonus für die meisten Spiele',
	'ACP_MOT_SUDOKU_MOST_GAMES_EXPL'		=> 'Bonus für den Spieler mit der höchsten Anzahl an Spielen in der laufenden Periode. Dieser Preis wird für alle Rätseltypen vergeben.',
	'ACP_MOT_SUDOKU_PM_ENABLE'				=> 'Persönliche Nachricht aktivieren',
	'ACP_MOT_SUDOKU_PM_ENABLE_EXPL'			=> 'Die Gewinner werden per PN über ihren Gewinn informiert.',
	'ACP_MOT_SUDOKU_ADMIN_LIST'				=> 'Administrator für das Sudoku Bonussystem',
	'ACP_MOT_SUDOKU_ADMIN_LIST_EXPL'		=> 'Ein Board Administrator oder Moderator, der die regelmäßigen Reports erhält und dessen Name als Absender in der PN für die Gewinner erscheint',

	'ACP_MOT_SUDOKU_RESET_GAME'				=> 'Alle Spieledaten löschen',
	'ACP_MOT_SUDOKU_RESET_GAME_EXPL'		=> '<font color=red>Nach Anklicken des `Löschen`-Buttons werden <strong>ALLE</strong> Statistiken, Ergebnisse und Zwischenergebnisse
												gelöscht und auf den Anfangszustand zurückgesetzt.</font><br>
												Die Daten der Ruhmeshalle bleiben erhalten.',
	'ACP_MOT_SUDOKU_RESET_GAME_CONFIRM_MSG'	=> 'Wollen Sie wirklich alle Spieledaten löschen?',
	'ACP_MOT_SUDOKU_RESET_SUCCESS'			=> 'Es wurden sämtliche Daten gelöscht',
	'ACP_MOT_SUDOKU_LOG_RESET_GAME'			=> '<strong>Sudoku Spieledaten gelöscht</strong>',

	'ACP_MOT_SUDOKU_SETTING_SAVED'			=> 'Die Einstellungen für das Sudoku-Spiel wurden erfolgreich gesichert.',
	'ACP_MOT_SUDOKU_LOG_SETTING_SAVED'		=> '<strong>Einstellungen für das Sudoku-Spiel geändert</strong>',

	// Gamepacks tab
	'ACP_MOT_SUDOKU_GAMEPACKS_EXPL'			=> 'Hier werden tabellarisch alle derzeit installierten Spiele-Pakete und die Anzahl der in ihnen enthaltenen Rätsel aufgelistet.<br>
												Wird ein Paket gelöscht, werden auch die in ihm enthaltenen Rätsel gelöscht. Bereits in Nutzung befindliche Rätsel bleiben dem
												jeweiligen Spieler (und nur diesem) bis zu deren Lösung erhalten.',
	'ACP_MOT_SUDOKU_SELECT_TYPE'			=> 'Auswahl Spiele-Paket-Typ',
	'ACP_MOT_SUDOKU_ALL'					=> 'Alle',
	'ACP_MOT_SUDOKU_GAME_PACK_NUMBER'		=> 'Paket-Nr.',
	'ACP_MOT_SUDOKU_GAME_PACK_TYPE'			=> 'Paket-Typ',
	'ACP_MOT_SUDOKU_GAME_COUNT'				=> 'Anzahl Rätsel',
	'ACP_MOT_SUDOKU_PACK_INSTALL_DATE'		=> 'Installations-Datum',
	'ACP_MOT_SUDOKU_PACKS_NOENTRY'			=> 'Keine Spiele-Pakete installiert',

	'ACP_MOT_SUDOKU_MIXED_PACK'				=> 'gemischtes Paket',
	'ACP_MOT_SUDOKU_CLASSIC'				=> 'Klassik-Rätsel',
	'ACP_MOT_SUDOKU_SAMURAI'				=> 'Samurai-Rätsel',
	'ACP_MOT_SUDOKU_NINJA'					=> 'Ninja-Rätsel',

	'ACP_MOT_SUDOKU_DEL_MARKED'				=> 'Markierte löschen',
	'ACP_MOT_SUDOKU_NO_PACK_SELECTED'		=> 'Sie müssen erst mindestens ein Paket zum Löschen auswählen.',
	'ACP_MOT_SUDOKU_PACK_DELETE'			=> [
		1	=> 'Wollen Sie wirklich das Spiele-Paket mit der Nr. <strong>%2$s</strong> und die dazugehörigen Rätsel aus der Datenbank löschen?<br>
				Dieser Vorgang kann nicht rückgängig gemacht werden!',
		2	=> 'Wollen Sie wirklich die %1$d Spiele-Pakete mit den Nr. <strong>%2$s</strong> und die dazugehörigen Rätsel aus der Datenbank löschen?<br>
				Dieser Vorgang kann nicht rückgängig gemacht werden!',
	],
	'ACP_MOT_SUDOKU_DELETED_PACK'			=> [
		1	=> 'Das Spiele-Paket mit der Nr. <strong>%2$s</strong> und die dazugehörigen Rätsel wurden aus der Datenbank gelöscht.',
		2	=> 'Die %1$d Spiele-Pakete mit den Nr. <strong>%2$s</strong> und die dazugehörigen Rätsel wurden aus der Datenbank gelöscht.',
	],

	'ACP_MOT_SUDOKU_UPLOAD_TITLE'			=> 'Sudoku-Packs importieren',
	'ACP_MOT_SUDOKU_UPLOAD_XML'				=> 'Lokale Sudoku-Packs (xml-Datei) importieren',
	'ACP_MOT_SUDOKU_UPLOAD_XML_EXP'			=> 'Hier können Sie bis zu %1$s auf Ihrem PC gespeicherte Sudoku-Packs in die Datenbank importieren und neue Sudoku-Rätsel
												zum Spielen bereit stellen.<br>Bitte beachten Sie, dass nur Spiele-Packs importiert werden können, die dem auf mike-on-tour.com
												definierten Schema entsprechen!<br>
												Um doppelte Spiele zu vermeiden, werden die Nummern des Spiele-Packs und der darin enthaltenen Spiele vor dem Import mit der
												Datenbank abgeglichen.',
	'ACP_MOT_SUDOKU_UPLOAD'					=> 'Importieren',
	'ACP_MOT_SUDOKU_UPLOAD_DISABLED'		=> 'Das Hochladen von Dateien ist in den Einstellungen abgeschaltet, in der ´php.ini´ muss <strong>file_uploads</strong> auf ´On´ gesetzt sein.',
	'ACP_MOT_SUDOKU_NO_FILE'				=> 'Keine Datei ausgewählt.',
	'ACP_MOT_SUDOKU_INVALID_FILE_EXT'		=> 'Die Datei <strong>%1$s</strong> hat eine ungültige Datei-Erweiterung.',
	'ACP_MOT_SUDOKU_INVALID_FILE_CONTENT'	=> 'Datei <strong>%1$s</strong> ist fehlerhaft, Laden abgebrochen.',
	'ACP_MOT_SUDOKU_IMPORT_FILES'			=> 'Aus der Datei/den Dateien <strong>%1$s</strong> wurden folgende Rätsel importiert:',
	'ACP_MOT_SUDOKU_CLASSIC_IMPORTED'		=> [
		1	=> '%1$d Classic-Sudoku-Rätsel',
		2	=> '%1$d Classic-Sudoku-Rätsel',
	],
	'ACP_MOT_SUDOKU_SAMURAI_IMPORTED'		=> [
		1	=> '%1$d Samurai-Sudoku-Rätsel',
		2	=> '%1$d Samurai-Sudoku-Rätsel',
	],
	'ACP_MOT_SUDOKU_NINJA_IMPORTED'		=> [
		1	=> '%1$d Ninja-Sudoku-Rätsel',
		2	=> '%1$d Ninja-Sudoku-Rätsel',
	],
	'MOT_SUDOKU_NO_IMPORT'				=> 'Es wurden aus der Datei <strong>%1$s</strong> keine Rätsel importiert, da die Nummer des Spiele-Packs bereits vergeben ist!',
]);
