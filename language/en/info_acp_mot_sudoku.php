<?php
/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
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

	'ACP_MOT_SUDOKU_VERSION'				=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2023 - %2$d by Mike-on-Tour',
	'SUPPORT_MOT_SUDOKU'					=> 'If you want to donate to Sudoku´s development please use this link:<br>',

	'ACP_MOT_SUDOKU_CONFIGURATION'			=> 'Sudoku Administration',
	'ACP_MOT_SUDOKU_GENERAL'				=> 'General settings',
	'ACP_MOT_SUDOKU_GENERAL_EXPL'			=> 'Here you can edit Sudoku´s general settings',

	'ACP_MOT_SUDOKU_VERSION_CHECK'			=> 'Sudoku Version Check',
	'ACP_MOT_SUDOKU_VERSION_CHECK_EXPL'		=> 'Checks if a new version of Sudoku is availavble',
	'ACP_MOT_SUDOKU_VERSION_UP_TO_DATE'		=> 'Your version of Sudoku is up-to-date.',
	'ACP_MOT_SUDOKU_VERSION_OUTDATED'		=> 'Your version of Sudoku is outdatet, an update is available.' ,
	'ACP_MOT_SUDOKU_CURRENT_VERSION'		=> 'Version currently installed',
	'ACP_MOT_SUDOKU_LATEST_VERSION'			=> 'Latest version available',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_ON'		=> 'Automatic version check',
	'ACP_MOT_SUDOKU_VERSION_CHECKER_EXPL'	=> 'If enabled it will be checked every time you call this page whether a newer version is available; the result will be displayed in
												in a coloured box above `General settings`.',

	'ACP_MOT_SUDOKU_ENABLE'					=> 'Activate Sudoku',
	'ACP_MOT_SUDOKU_ENABLE_EXPL'			=> 'Enable/disable for authorised members, displays the link in the navigation bar depending on status.',

	'ACP_MOT_SUDOKU_CACHE_ENABLE'			=> 'Enable database query cache',
	'ACP_MOT_SUDOKU_CACHE_ENABLE_EXPL'		=> 'Query cache decreases database server load.',
	'ACP_MOT_SUDOKU_PURGE_CACHE'			=> 'Purge the Sudoku cache',
	'ACP_MOT_SUDOKU_PURGE_CACHE_MSG'		=> 'Sudoku cache successfully purged',
	'ACP_MOT_SUDOKU_PURGE_CACHE_LOG'		=> '<strong>Purged the Sudoku cache</strong>',

	'ACP_MOT_SUDOKU_PUZZLE_TITLE'			=> 'Display puzzle title',
	'ACP_MOT_SUDOKU_PUZZLE_TITLE_EXPL'		=> 'Enables display of the current game`s title.',

	'ACP_MOT_SUDOKU_HELPER_ENABLE'			=> 'Enable Sudoku Helper',
	'ACP_MOT_SUDOKU_HELPER_ENABLE_EXPL'		=> 'Allow players to use helper popup window with all available numbers for each empty cell.',
	'ACP_MOT_SUDOKU_HELPER_COST'			=> 'Deduction for helper',
	'ACP_MOT_SUDOKU_HELPER_POINTS_NAME'		=> 'Points',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_ENABLE'	=> 'Enable Samurai Helper',
	'ACP_MOT_SUDOKU_HELPER_SAMURAI_COST'	=> 'Deduction for Samurai helper',
	'ACP_MOT_SUDOKU_HELPER_NINJA_ENABLE'	=> 'Enable Ninja Helper',
	'ACP_MOT_SUDOKU_HELPER_NINJA_COST'		=> 'Deduction for Ninja helper',

	'ACP_MOT_SUDOKU_LEVEL_COST'				=> 'Deduction for selected level',
	'ACP_MOT_SUDOKU_LEVEL_COST_EXPL'		=> 'Number of points deducted for each selected level of difficulty',

	'ACP_MOT_SUDOKU_POINTS_ENABLE'			=> 'Enable points system',
	'ACP_MOT_SUDOKU_POINTS_ENABLE_EXPL'		=> 'If a points system (e.g. ´Ultimate Points´) is active on your board, Sudoku game points will be added to or subtracted from
												this points account of a Sudoku player.<br>
												After enabling this setting more settings related to it will be displayed.',

	'ACP_MOT_SUDOKU_POINTS_RATIO' 			=> 'Ratio Sudoku points to points system points',
	'ACP_MOT_SUDOKU_POINTS_RATIO_EXPL' 		=> 'Define the amount of points system points to be credited per 100 Sudoku points.',

	'ACP_MOT_SUDOKU_REWARD_ON'				=> 'Enable Sudoku rewards',
	'ACP_MOT_SUDOKU_REWARD_ON_EXPL'			=> 'Periodic calculation of the game score and reward payments',

	'ACP_MOT_SUDOKU_RESET_GAME'				=> 'Delete all game data',
	'ACP_MOT_SUDOKU_RESET_GAME_EXPL'		=> '<font color=red>After clicking the `Delete` button <strong>ALL</strong> statistics, results and intermediate results will be
												deleted and reset to their original state.</font>',
	'ACP_MOT_SUDOKU_RESET_GAME_CONFIRM_MSG'	=> 'Do you really want to delete the data of all Sudoku players?',
	'ACP_MOT_SUDOKU_RESET_SUCCESS'			=> 'All game data of Sudoku successfully deleted',
	'ACP_MOT_SUDOKU_LOG_RESET_GAME'			=> '<strong>Deleted Sudoku game data</strong>',

	'ACP_MOT_SUDOKU_REWARD_GC'				=> 'Time interval between two reward calculations (in seconds)',
	'ACP_MOT_SUDOKU_REWARD_GC_EXPL' 		=> 'The period between two cron jobs calculating the reward points in seconds.',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC' 		=> 'Time of the last cron job run',
	'ACP_MOT_SUDOKU_REWARD_LAST_GC_EXPL' 	=> 'The time of the last cron job run to calculate the winners`s rewards.',
	'ACP_MOT_SUDOKU_REWARD_NEXT_GC' 		=> 'Time of next cron job run',
	'ACP_MOT_SUDOKU_REWARD_NEXT_GC_EXPL' 	=> 'The estimated time of the next cron job run<br>
												(Estimated because the board has to be actively used at that time, if nobody uses it the cron job will run as soon as somebody
												logs in to it).',
	'ACP_MOT_SUDOKU_RANK1'					=> '1. rank bonus points',
	'ACP_MOT_SUDOKU_RANK1_EXPL' 			=> 'Bonus points for the top scorer of the current period.',
	'ACP_MOT_SUDOKU_RANK2'					=> '2. rank bonus points',
	'ACP_MOT_SUDOKU_RANK2_EXPL' 			=> 'Bonus points for the second rank of the current period.',
	'ACP_MOT_SUDOKU_RANK3'					=> '3. rank bonus points',
	'ACP_MOT_SUDOKU_RANK3_EXPL' 			=> 'Bonus points for the third rank of the current period.',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE'			=> 'Bonus for highest average',
	'ACP_MOT_SUDOKU_HIGH_AVERAGE_EXPL' 		=> 'Bonus points for the top average of the current period.',
	'ACP_MOT_SUDOKU_MOST_GAMES'				=> 'Bonus points for the most games',
	'ACP_MOT_SUDOKU_MOST_GAMES_EXPL' 		=> 'Bonus points for the player who played the most games in the current period.',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE'			=> 'Best Samurai player bonus',
	'ACP_MOT_SUDOKU_SAMURAI_PRICE_EXPL'		=> 'Bonus points for the top Samurai player of the current period.',
	'ACP_MOT_SUDOKU_NINJA_PRICE'			=> 'Best Ninja player bonus',
	'ACP_MOT_SUDOKU_NINJA_PRICE_EXPL'		=> 'Bonus points for the top Ninja player of the current period.',
	'ACP_MOT_SUDOKU_PM_ENABLE'				=> 'Enable PMs',
	'ACP_MOT_SUDOKU_PM_ENABLE_EXPL'			=> 'If enabled bonus winners will be notified by PM.',
	'ACP_MOT_SUDOKU_ADMIN_LIST' 			=> 'Sudoku reward system administrator',
	'ACP_MOT_SUDOKU_ADMIN_LIST_EXPL' 		=> 'A board administrator or moderator who will receive the report of periodic results and who will be the sender of PMs to the winners.',

	'ACP_MOT_SUDOKU_SETTING_SAVED'			=> 'Settings for the Sudoku game successfully saved.',
	'ACP_MOT_SUDOKU_LOG_SETTING_SAVED'		=> '<strong>Changed Sudoku settings</strong>',
]);
