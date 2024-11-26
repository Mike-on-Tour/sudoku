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
	'ACP_MOT_SUDOKU_SETTINGS'				=> 'Settings',
	'ACP_MOT_SUDOKU_GAMEPACKS'				=> 'Sudoku packs',

	'ACP_MOT_SUDOKU_VERSION'				=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic"><br>&copy; 2023 - %2$d by Mike-on-Tour',
	'SUPPORT_MOT_SUDOKU'					=> 'If you want to donate to Sudoku´s development please use this link:<br>',

	// Settings tab
	'ACP_MOT_SUDOKU_GENERAL'				=> 'General settings',
	'ACP_MOT_SUDOKU_GENERAL_EXPL'			=> 'Here you can edit Sudoku´s general settings',

	'ACP_MOT_SUDOKU_GENERAL_SETTINGS'		=> 'General settings',
	'ACP_MOT_SUDOKU_ENABLE'					=> 'Enable Sudoku',
	'ACP_MOT_SUDOKU_ENABLE_EXPL'			=> 'Enable/disable Sudoku for authorised members, displays the link in the navigation bar depending on status.<br>
												This settong does not affect founders, they always can see Sudoku.',
	'ACP_MOT_SUDOKU_VERSION_CHECK'			=> 'Sudoku Version Check',
	'ACP_MOT_SUDOKU_VERSION_CHECK_EXPL'		=> 'Checks if a new version of Sudoku is availavble',
	'ACP_MOT_SUDOKU_VERSION_UP_TO_DATE'		=> 'Your version of Sudoku is up-to-date.',
	'ACP_MOT_SUDOKU_VERSION_OUTDATED'		=> 'Your version of Sudoku is outdatet, an update is available.' ,
	'ACP_MOT_SUDOKU_CURRENT_VERSION'		=> 'Version currently installed',
	'ACP_MOT_SUDOKU_LATEST_VERSION'			=> 'Latest version available',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_ON'		=> 'Automatic version check',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_EXPL'	=> 'If enabled it will be checked every time you call this page whether a newer version is available; the result will be displayed in
												in a coloured box above `General settings`.',
	'ACP_MOT_SUDOKU_ENABLE_RANK'			=> 'Display highscore',
	'ACP_MOT_SUDOKU_ENABLE_RANK_EXPL'		=> 'This setting enables or disables the highscore tab.',
	'ACP_MOT_SUDOKU_ENABLE_FAME'			=> 'Display Hall of Fame',
	'ACP_MOT_SUDOKU_ENABLE_FAME_EXPL'		=> 'This setting enables or disables the Hall of Fame tab.<br>
												If enabled another setting will be displayed where you can choose the number of players to be displayed.',
	'ACP_MOT_SUDOKU_FAME_LIMIT'				=> 'Number of players to be displayed in the »Hall of Fame«',
	'ACP_MOT_SUDOKU_FAME_LIMIT_EXP'			=> 'You can select the number of players to be displayed in the tables of the »Hall of Fame«.',
	'ACP_MOT_SUDOKU_PUZZLE_TITLE'			=> 'Display puzzle title',
	'ACP_MOT_SUDOKU_PUZZLE_TITLE_EXPL'		=> 'Enables display of the current game`s title.',
	'ACP_MOT_SUDOKU_ROWS_PER_PAGE'			=> 'Rows per table page for Sudoku packs',
	'ACP_MOT_SUDOKU_ROWS_PER_PAGE_EXP'		=> 'Choose the number of rows to be displayed per table page when displaying the Sudoku packs.',

	'ACP_MOT_SUDOKU_POINTS_SETTINGS'		=> 'Points settings',
	'ACP_MOT_SUDOKU_CELL_POINTS'			=> 'Input points',
	'ACP_MOT_SUDOKU_CELL_POINTS_EXPL'		=> 'Number of points earned for writing a number into a cell.',
	'ACP_MOT_SUDOKU_CELL_COST'				=> 'Delete points',
	'ACP_MOT_SUDOKU_CELL_COST_EXPL'			=> 'Number of points deducted for deleting or overwriting an existing number in a cell.',
	'ACP_MOT_SUDOKU_NUMBER_COST'			=> 'Deduction for buying a number',
	'ACP_MOT_SUDOKU_NUMBER_COST_EXPL'		=> 'Number of points deducted for buying a number to make the puzzle easier.',
	'ACP_MOT_SUDOKU_RESET_COST'				=> 'Deduction for reset',
	'ACP_MOT_SUDOKU_RESET_COST_EXPL'		=> 'Number of points deducted for resetting the current game.',
	'ACP_MOT_SUDOKU_LEVEL_COST'				=> 'Deduction for selected lower level',
	'ACP_MOT_SUDOKU_LEVEL_COST_EXPL'		=> 'Number of points deducted for each selected lower level of difficulty',

	'ACP_MOT_SUDOKU_HELPER_SETTINGS'		=> 'Helper settings',
	'ACP_MOT_SUDOKU_HELPER_ENABLE'			=> 'Enable Sudoku Helper',
	'ACP_MOT_SUDOKU_HELPER_ENABLE_EXPL'		=> 'Allow players to use helper popup window with all available numbers for each empty cell.',
	'ACP_MOT_SUDOKU_HELPER_COST'			=> 'Deduction for helper',
	'ACP_MOT_SUDOKU_HELPER_POINTS_NAME'		=> 'Points',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_ENABLE'	=> 'Enable Samurai Helper',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_COST'	=> 'Deduction for Samurai helper',
	'ACP_MOT_SUDOKU_HELPER_NINJA_ENABLE'	=> 'Enable Ninja Helper',
	'ACP_MOT_SUDOKU_HELPER_NINJA_COST'		=> 'Deduction for Ninja helper',

	'ACP_MOT_SUDOKU_UP_SETTINGS'			=> 'Points system settings',
	'ACP_MOT_SUDOKU_POINTS_ENABLE'			=> 'Enable points system',
	'ACP_MOT_SUDOKU_POINTS_ENABLE_EXPL'		=> 'If a points system (e.g. ´Ultimate Points´) is active on your board, Sudoku game points will be added to or subtracted from
												this points account of a Sudoku player.<br>
												After enabling this setting more settings related to it will be displayed.',
	'ACP_MOT_SUDOKU_POINTS_RATIO' 			=> 'Ratio Sudoku points to points system points',
	'ACP_MOT_SUDOKU_POINTS_RATIO_EXPL' 		=> 'Defines the amount of points system points to be credited per %1$d Sudoku points.',

	'ACP_MOT_SUDOKU_REWARD_SETTINGS'		=> 'Rewards settings',
	'ACP_MOT_SUDOKU_REWARD_ON'				=> 'Enable Sudoku rewards',
	'ACP_MOT_SUDOKU_REWARD_ON_EXPL'			=> 'Enable the periodic calculation of the reward payments',
	'ACP_MOT_SUDOKU_REWARD_TIME' 			=> 'Time period between two reward calculation runs',
	'ACP_MOT_SUDOKU_REWARD_TIME_EXPL'	 	=> 'The time period between two runs to calculate the winners`s rewards.',
	'ACP_MOT_SUDOKU_DAILY'					=> 'Daily',
	'ACP_MOT_SUDOKU_WEEKLY'					=> 'Weekly',
	'ACP_MOT_SUDOKU_MONTHLY'				=> 'Monthly',
	'ACP_MOT_SUDOKU_YEARLY'					=> 'Yearly',
	'ACP_MOT_SUDOKU_WEEK_START'				=> 'Select the day of the week for weekly calculation of rewards',
	'ACP_MOT_SUDOKU_WEEK_START_EXPL'		=> 'For the weekly calculation of the rewards please choose here the day of the week for the calculation.',
	'ACP_MOT_SUDOKU_SUNDAY'					=> 'Sunday',
	'ACP_MOT_SUDOKU_MONDAY'					=> 'Monday',
	'ACP_MOT_SUDOKU_TUESDAY'				=> 'Tuesday',
	'ACP_MOT_SUDOKU_WEDNESDAY'				=> 'Wednesday',
	'ACP_MOT_SUDOKU_THURSDAY'				=> 'Thursday',
	'ACP_MOT_SUDOKU_FRIDAY'					=> 'Fryday',
	'ACP_MOT_SUDOKU_SATURDAY'				=> 'Saturday',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC' 		=> 'Time of the last cron job run',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC_EXPL' 	=> 'The time of the last cron job run to calculate the rewards. This just indicates the time of the last cron job run and does not
												state anything about the last calculation of the rewards.',
	'ACP_MOT_SUDOKU_CLASSIC_PRICE'			=> 'Best Classic player bonus',
	'ACP_MOT_SUDOKU_CLASSIC_PRICE_EXPL'		=> 'Bonus points for the top Classic player of the current period.',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE'			=> 'Best Samurai player bonus',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE_EXPL'		=> 'Bonus points for the top Samurai player of the current period.',
	'ACP_MOT_SUDOKU_NINJA_PRICE'			=> 'Best Ninja player bonus',
	'ACP_MOT_SUDOKU_NINJA_PRICE_EXPL'		=> 'Bonus points for the top Ninja player of the current period.',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE'			=> 'Bonus for highest average',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE_EXPL' 		=> 'Bonus points for the top average of the current period. This bonus will be awarded for all puzzle types.',
	'ACP_MOT_SUDOKU_MOST_GAMES'				=> 'Bonus points for the most games',
	'ACP_MOT_SUDOKU_MOST_GAMES_EXPL' 		=> 'Bonus points for the player who played the most games in the current period. This bonus will be awarded for all puzzle types.',
	'ACP_MOT_SUDOKU_PM_ENABLE'				=> 'Enable PMs',
	'ACP_MOT_SUDOKU_PM_ENABLE_EXPL'			=> 'If enabled bonus winners will be notified by PM.',
	'ACP_MOT_SUDOKU_ADMIN_LIST' 			=> 'Sudoku reward system administrator',
	'ACP_MOT_SUDOKU_ADMIN_LIST_EXPL' 		=> 'A board administrator or moderator who will receive the report of periodic results and who will be the sender of PMs to the winners.',

	'ACP_MOT_SUDOKU_RESET_GAME'				=> 'Delete all game data',
	'ACP_MOT_SUDOKU_RESET_GAME_EXPL'		=> '<font color=red>After clicking the `Delete` button <strong>ALL</strong> statistics, results and intermediate results will be
												deleted and reset to their original state.</font>',
	'ACP_MOT_SUDOKU_RESET_GAME_CONFIRM_MSG'	=> 'Do you really want to delete the data of all Sudoku players?',
	'ACP_MOT_SUDOKU_RESET_SUCCESS'			=> 'All game data of Sudoku successfully deleted',
	'ACP_MOT_SUDOKU_LOG_RESET_GAME'			=> '<strong>Deleted Sudoku game data</strong>',

	'ACP_MOT_SUDOKU_SETTING_SAVED'			=> 'Settings for the Sudoku game successfully saved.',
	'ACP_MOT_SUDOKU_LOG_SETTING_SAVED'		=> '<strong>Changed Sudoku settings</strong>',

	// Gamepacks tab
	'ACP_MOT_SUDOKU_GAMEPACKS_EXPL'			=> 'The table on this tab displays all the Sudoku packs and the number of puzzles contained which are currently installed.<br>
												If you delete a pack all puzzles it is containing are removed, too. Puzzles currently in use will be kept for the player working
												on it (and only for this player) until it is solved.',
	'ACP_MOT_SUDOKU_SELECT_TYPE'			=> 'Select pack type',
	'ACP_MOT_SUDOKU_ALL'					=> 'All',
	'ACP_MOT_SUDOKU_GAME_PACK_NUMBER'		=> 'Pack #',
	'ACP_MOT_SUDOKU_GAME_PACK_TYPE'			=> 'Pack type',
	'ACP_MOT_SUDOKU_GAME_COUNT'				=> 'Puzzle count',
	'ACP_MOT_SUDOKU_PACK_INSTALL_DATE'		=> 'Installation date',
	'ACP_MOT_SUDOKU_PACKS_NOENTRY'			=> 'No Sudoku packs installed',

	'ACP_MOT_SUDOKU_MIXED_PACK'				=> 'Mixed pack',
	'ACP_MOT_SUDOKU_CLASSIC'				=> 'Classic pack',
	'ACP_MOT_SUDOKU_SAMURAI'				=> 'Samurai pack',
	'ACP_MOT_SUDOKU_NINJA'					=> 'Ninja pack',

	'ACP_MOT_SUDOKU_DEL_MARKED'				=> 'Delete marked',
	'ACP_MOT_SUDOKU_NO_PACK_SELECTED'		=> 'You have not selected any packs for this action, please mark at least one pack.',
	'ACP_MOT_SUDOKU_PACK_DELETE'			=> [
		1	=> 'Do you really want to remove the Sudoku pack with the number <strong>%2$s</strong> and all its puzzles from the database?<br>
				This is a permanent action and can not be undone!',
		2	=> 'Do you really want to remove the %1$d Sudoku packs with the numbers <strong>%2$s</strong> and all their puzzles from the database?<br>
				This is a permanent action and can not be undone!',
	],
	'ACP_MOT_SUDOKU_DELETED_PACK'			=> [
		1	=> 'The Sudoku pack with the number <strong>%2$s</strong> and all its puzzles were removed from the database.',
		2	=> 'The %1$d Sudoku packs with the numbers <strong>%2$s</strong> and all their puzzles were removed from the database.',
	],

	'ACP_MOT_SUDOKU_UPLOAD_TITLE'			=> 'Import Sudoku packs',
	'ACP_MOT_SUDOKU_UPLOAD_XML'				=> 'Import locally stored Sudoku packs (xml file)',
	'ACP_MOT_SUDOKU_UPLOAD_XML_EXP'			=> 'Here you can import into the database up to %1$d Sudoku packs stored locally on your PC in order to provide your players with
												new puzzles.<br>Please note that you can import only such packs which adhere to the file schema defined on mike-on-tour.com!<br>
												To prevent puzzles already in the database from being imported a second time the import function checks the numbers of the game
												pack and the games against those already in the database.',
	'ACP_MOT_SUDOKU_UPLOAD'					=> 'Import',
	'ACP_MOT_SUDOKU_UPLOAD_DISABLED'		=> 'File upload is disabled by a configuration setting in ´php.ini´, please set <strong>file_uploads</strong> to ´On´.',
	'ACP_MOT_SUDOKU_NO_FILE'				=> 'No file selected.',
	'ACP_MOT_SUDOKU_INVALID_FILE_EXT'		=> 'The file <strong>%1$s</strong> has an invalid file extension.',
	'ACP_MOT_SUDOKU_INVALID_FILE_CONTENT'	=> 'File <strong>%1$s</strong> is corrupted, import aborted.',
	'ACP_MOT_SUDOKU_IMPORT_FILES'			=> 'The following puzzles were imported from the file(s) <strong>%1$s</strong>:',
	'ACP_MOT_SUDOKU_CLASSIC_IMPORTED'		=> [
		1	=> '%1$d Classic Sudoku puzzle.',
		2	=> '%1$d Classic Sudoku puzzles',
	],
	'ACP_MOT_SUDOKU_SAMURAI_IMPORTED'		=> [
		1	=> '%1$d Samurai Sudoku puzzle',
		2	=> '%1$d Samurai Sudoku puzzles',
	],
	'ACP_MOT_SUDOKU_NINJA_IMPORTED'		=> [
		1	=> '%1$d Ninja Sudoku puzzle',
		2	=> '%1$d Ninja Sudoku puzzles',
	],
	'MOT_SUDOKU_NO_IMPORT'				=> 'No puzzles imported from the file <strong>%1$s</strong> because the number of the Sudoku pack is already in use!',
]);
