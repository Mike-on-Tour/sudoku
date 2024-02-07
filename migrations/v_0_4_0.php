<?php
/**
*
* @package MoT Sudoku v0.4.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_4_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_3_0'];
	}

	public function update_data()
	{
		return [
			// Add our gamepacks_module to the parent module (ACP_MOT_SUDOKU)
			['module.add', [
				'acp',
				'ACP_MOT_SUDOKU',
				[
					'module_basename'	=> '\mot\sudoku\acp\mot_sudoku_acp_module',
					'module_langname'	=> 'ACP_MOT_SUDOKU_GAMEPACKS',
					'module_mode'		=> 'gamepacks',
					'module_auth'		=> 'ext_mot/sudoku && acl_a_manage_mot_sudoku',
				],
			]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mot_sudoku_samurai'	=> [
					'COLUMNS'	=> [
						'samurai_id'		=> ['UINT:10', null, 'auto_increment'],
						'game_pack'			=> ['UINT:2', 0],
						'game_number'		=> ['UINT:1', 0],
						'game_level'		=> ['UINT:1', 0],
						'game_name'			=> ['VCHAR:40', ''],
						'creator_name'		=> ['VCHAR:40', ''],
						'puzzle_line'		=> ['VCHAR:1000', ''],
						'solution_line'		=> ['VCHAR:1000', ''],
					],
					'PRIMARY_KEY'	=> 'samurai_id',
				],
				$this->table_prefix . 'mot_sudoku_gamepacks'	=> [
					'COLUMNS'	=> [
						'pack_id'			=> ['UINT:10', null, 'auto_increment'],
						'game_pack'			=> ['UINT:2', 0],
						'game_type'			=> ['VCHAR:20', ''],
						'classic_count'		=> ['UINT:1', 0],
						'samurai_count'		=> ['UINT:1', 0],
						'ninja_count'		=> ['UINT:1', 0],
						'install_date'		=> ['UINT:11', 0],
					],
					'PRIMARY_KEY'	=> 'pack_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_sudoku_samurai',
				$this->table_prefix . 'mot_sudoku_gamepacks',
			],
		];
	}
}
