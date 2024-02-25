<?php
/**
*
* @package MoT Sudoku v0.6.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_6_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_5_0'];
	}

	public function update_data()
	{
		$date_arr = getdate();
		return [
			// Add the config variable we want to be able to set
			['config.add', ['mot_sudoku_enable_rank', true]],
			['config.add', ['mot_sudoku_enable_fame', true]],
			['config.add', ['mot_sudoku_fame_limit', 3]],
			['config.add', ['mot_sudoku_current_month', ($date_arr['year'] * 100 + $date_arr['mon']), true]],
			['config.add', ['mot_sudoku_current_year', $date_arr['year'], true]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mot_sudoku_fame' => [
					'COLUMNS'	=> [
						'fame_id'			=> ['UINT:10', null, 'auto_increment'],
						'year'				=> ['UINT:2', 0],
						'month'				=> ['UINT:1', 0],
						'user_id'			=> ['UINT:10', 0],
						'game_type'			=> ['VCHAR:1', ''],
						'games_played'		=> ['UINT:3', 0],
						'total_points'		=> ['UINT:3', 0],
					],
					'PRIMARY_KEY'	=> 'fame_id',
				],
				$this->table_prefix . 'mot_sudoku_fame_month' => [
					'COLUMNS'	=> [
						'month_id'			=> ['UINT:10', null, 'auto_increment'],
						'year'				=> ['UINT:2', 0],
						'month'				=> ['UINT:1', 0],
						'user_id'			=> ['UINT:10', 0],
						'game_type'			=> ['VCHAR:1', ''],
						'games_played'		=> ['UINT:3', 0],
						'total_points'		=> ['UINT:3', 0],
					],
					'PRIMARY_KEY'	=> 'month_id',
				],
				$this->table_prefix . 'mot_sudoku_fame_year' => [
					'COLUMNS'	=> [
						'year_id'			=> ['UINT:10', null, 'auto_increment'],
						'year'				=> ['UINT:2', 0],
						'user_id'			=> ['UINT:10', 0],
						'game_type'			=> ['VCHAR:1', ''],
						'games_played'		=> ['UINT:3', 0],
						'total_points'		=> ['UINT:3', 0],
					],
					'PRIMARY_KEY'	=> 'year_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_sudoku_fame',
				$this->table_prefix . 'mot_sudoku_fame_month',
				$this->table_prefix . 'mot_sudoku_fame_year',
			],
		];
	}
}
