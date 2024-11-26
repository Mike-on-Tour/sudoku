<?php
/**
*
* @package MoT Sudoku v0.11.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_11_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_9_0'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'mot_sudoku_fame' => [
					'julian_day'	=> ['UINT:10', 0, 'after' => 'month'],
				],
			],
		];
	}

	public function update_data()
	{
		// Get the current date
		$date_arr = getdate();
		$last_reward = ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday'];

		return [
			['config.add', ['mot_sudoku_reward_time', 2]],
			['config.add', ['mot_sudoku_week_start', 0]],
			['config.add', ['mot_sudoku_last_reward', $last_reward, true]],
			['config.add', ['mot_sudoku_classic_price', 1000]],
			['config.update', ['mot_sudoku_points_ratio', 0.1]],
			['config.remove', ['mot_sudoku_rank1_price']],
			['config.remove', ['mot_sudoku_rank2_price']],
			['config.remove', ['mot_sudoku_rank3_price']],
		];
	}

	public function revert_schema()
	{
		return [];
	}

	public function revert_data()
	{
		return [
			['config.remove', ['mot_sudoku_reward_time']],
			['config.remove', ['mot_sudoku_week_start']],
			['config.remove', ['mot_sudoku_last_reward']],
			['config.remove', ['mot_sudoku_classic_price']],
			['config.add', ['mot_sudoku_rank1_price', 1000]],
			['config.add', ['mot_sudoku_rank2_price', 500]],
			['config.add', ['mot_sudoku_rank3_price', 200]],
		];
	}
}
