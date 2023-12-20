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
	// Admin permissions
	'ACL_A_MOT_SUDOKU_MANAGE'	=> 'Kann das Sudoku-Spiel administrieren',

	// User permissions
	'ACL_U_MOT_SUDOKU_PLAY'		=> 'Kann Sudoku spielen',
]);
