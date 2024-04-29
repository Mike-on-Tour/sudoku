<?php
/**
*
* @package MoT Sudoku v0.9.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_9_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_7_0'];
	}

	public function update_schema()
	{
		return [
			'change_columns'	=>	[
					$this->table_prefix . 'mot_sudoku_stats'		=> [
						'classic_points'	=> ['INT:4', 0],
						'samurai_points'	=> ['INT:4', 0],
						'ninja_points'		=> ['INT:4', 0],
					],
					$this->table_prefix . 'mot_sudoku_fame' 		=> [
						'total_points'		=> ['INT:4', 0],
					],
					$this->table_prefix . 'mot_sudoku_fame_month'	=> [
						'total_points'		=> ['INT:4', 0],
					],
					$this->table_prefix . 'mot_sudoku_fame_year' 	=> [
						'total_points'		=> ['INT:4', 0],
					],
			],

			'drop_columns'		=>	[
					$this->table_prefix . 'mot_sudoku_games' 		=> [
						'solved',
					],
			],
		];
	}

	public function revert_schema()
	{
		return [];		// Return empty array since we do not change something which needs changing back before the tables get deleted
	}
}
