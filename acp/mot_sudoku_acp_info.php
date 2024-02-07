<?php
/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\acp;

class mot_sudoku_acp_info
{
	public function module()
	{
		return [
			'filename'	=> '\mot\sudoku\acp\mot_sudoku_acp_module',
			'title'		=> 'ACP_MOT_SUDOKU',
			'modes'		=> [
				'settings'			=> [
					'title'	=> 'ACP_MOT_SUDOKU_SETTINGS',
					'auth'	=> 'ext_mot/sudoku && acl_a_manage_mot_sudoku',
					'cat'	=> ['ACP_MOT_SUDOKU'],
				],
				'gamepacks'			=> [
					'title'	=> 'ACP_MOT_SUDOKU_GAMEPACKS',
					'auth'	=> 'ext_mot/sudoku && acl_a_manage_mot_sudoku',
					'cat'	=> ['ACP_MOT_SUDOKU'],
				],
			],
		];
	}
}
