<?php
/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'MOT_SUDOKU_EXT_NAME'						=> 'Sudoku',
	'MOT_SUDOKU_ERROR_EXTENSION_NOT_ENABLE'		=> 'Die Erweiterung „%1$s“ kann nicht aktiviert werden. Prüfen Sie die Voraussetzungen, die für die Erweiterung notwendig sind.',
	'MOT_SUDOKU_ERROR_MESSAGE_PHPBB_VERSION'	=> 'Minimum ist phpBB %1$s, aber kleiner als „%2$s“',
	'MOT_SUDOKU_PHP_VERSION_ERROR'				=> 'Minimum PHP-Version ist „%1$s“, aber kleiner als „%2$s“',
]);
