<?php
/**
*
* @package MoT Sudoku v0.3.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_3_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_2_0'];
	}

	public function update_data()
	{
		return [
			// Add the config variable we want to be able to set
			['config.add', ['mot_sudoku_cell_points', 10]],
			['config.add', ['mot_sudoku_cell_cost', 15]],
			['config.add', ['mot_sudoku_number_cost', 40]],
			['config.add', ['mot_sudoku_reset_cost', 200]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mot_sudoku_games'	=> [
					'COLUMNS'	=> [
						'entry_id'			=> ['UINT:10', null, 'auto_increment'],
						'user_id'			=> ['UINT:10', 0],
						'game_type'			=> ['VCHAR:1', ''],
						'game_id'			=> ['UINT:10', 0],
						'reset'				=> ['UINT:1', 0],
						'buy_digit'			=> ['UINT:1', 0],
						'helper'			=> ['TINT:1', 0],
						'level'				=> ['UINT:1', 0],
						'points'			=> ['INT:4', 0],
						'solved'			=> ['UINT:1', 0],
						'player_line'		=> ['VCHAR:2000', ''],
						'puzzle_line'		=> ['VCHAR:2000', ''],
						'solution_line'		=> ['VCHAR:2000', ''],
					],
					'PRIMARY_KEY'	=> 'entry_id',
				],
				$this->table_prefix . 'mot_sudoku_stats'	=> [
					'COLUMNS'	=> [
						'user_id'			=> ['UINT:10', 0],
						'modal_position'	=> ['UINT:1', 0],
						'classic_played'	=> ['UINT:3', 0],
						'classic_points'	=> ['UINT:3', 0],
						'classic_ids'		=> ['TEXT', ''],
						'samurai_played'	=> ['UINT:3', 0],
						'samurai_points'	=> ['UINT:3', 0],
						'samurai_ids'		=> ['TEXT', ''],
						'ninja_played'		=> ['UINT:3', 0],
						'ninja_points'		=> ['UINT:3', 0],
						'ninja_ids'			=> ['TEXT', ''],
					],
					'PRIMARY_KEY'	=> 'user_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_sudoku_games',
				$this->table_prefix . 'mot_sudoku_stats',
			],
		];
	}
}
