<?php
/**
*
* @package MoT Sudoku v0.7.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_7_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\sudoku\migrations\v_0_6_0'];
	}

	public function update_data()
	{
		return [
			// Add the config variable we want to be able to set
			['config.add', ['mot_sudoku_rows_per_page', 25]],
		];
	}
}
