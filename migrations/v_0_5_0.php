<?php
/**
*
* @package MoT Sudoku v0.5.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_5_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_4_0'];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mot_sudoku_ninja'	=> [
					'COLUMNS'	=> [
						'ninja_id'		=> ['UINT:10', null, 'auto_increment'],
						'game_pack'			=> ['UINT:2', 0],
						'game_number'		=> ['UINT:1', 0],
						'game_level'		=> ['UINT:1', 0],
						'game_name'			=> ['VCHAR:40', ''],
						'creator_name'		=> ['VCHAR:40', ''],
						'puzzle_line'		=> ['VCHAR:2000', ''],
						'solution_line'		=> ['VCHAR:2000', ''],
					],
					'PRIMARY_KEY'	=> 'ninja_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_sudoku_ninja',
			],
		];
	}
}
