<?php
/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\migrations;

class v_0_1_0 extends \phpbb\db\migration\migration
{

	/**
	* If our config variable already exists in the db
	* skip this migration.
	*/
	public function effectively_installed()
	{
		return isset($this->config['mot_sudoku_enable']);
	}

	public function update_data()
	{
		return [
			// Add the config variable we want to be able to set
			['config.add', ['mot_sudoku_enable', true]],
			['config.add', ['mot_sudoku_version_checker', true]],
			['config.add', ['mot_sudoku_title_enable', true]],
			['config.add', ['mot_sudoku_helper_enable', true]],
			['config.add', ['mot_sudoku_helper_cost', 50]],
			['config.add', ['mot_sudoku_helper_samurai_enable', true]],
			['config.add', ['mot_sudoku_helper_samurai_cost', 500]],
			['config.add', ['mot_sudoku_helper_ninja_enable', true]],
			['config.add', ['mot_sudoku_helper_ninja_cost', 900]],
			['config.add', ['mot_sudoku_level_cost', 10]],
			['config.add', ['mot_sudoku_points_enable', false]],
			['config.add', ['mot_sudoku_points_ratio', 100]],
			['config.add', ['mot_sudoku_reward_enable', false]],
			['config.add', ['mot_sudoku_reward_gc', 3600]],
			['config.add', ['mot_sudoku_reward_last_gc', 0, true]],
			['config.add', ['mot_sudoku_rank1_price', 1000]],
			['config.add', ['mot_sudoku_rank2_price', 500]],
			['config.add', ['mot_sudoku_rank3_price', 200]],
			['config.add', ['mot_sudoku_high_average', 1500]],
			['config.add', ['mot_sudoku_most_games', 700]],
			['config.add', ['mot_sudoku_samurai_price', 3500]],
			['config.add', ['mot_sudoku_ninja_price', 5000]],
			['config.add', ['mot_sudoku_pm_enable', false]],
			['config.add', ['mot_sudoku_admin_id', 0]],

			// set the permission values
			['permission.add', ['a_manage_mot_sudoku']],
			['permission.add', ['u_play_mot_sudoku']],

			// Set (at least some) role permissions (the indroduction of 'role_exists' in 3.3.1 makes it necessary to set the minor version to phpBB 3.3.1)
			['if', [
				['permission.role_exists', ['ROLE_ADMIN_FULL']],
				['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_manage_mot_sudoku']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_FULL']],
				['permission.permission_set', ['ROLE_USER_FULL', 'u_play_mot_sudoku']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_STANDARD']],
				['permission.permission_set', ['ROLE_USER_STANDARD', 'u_play_mot_sudoku']],
			]],

			// Add a parent module (ACP_MOT_SUDOKU) to the Extensions tab (ACP_CAT_DOT_MODS)
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MOT_SUDOKU'
			]],

			// Add our settings_module to the parent module (ACP_MOT_SUDOKU)
			['module.add', [
				'acp',
				'ACP_MOT_SUDOKU',
				[
					'module_basename'	=> '\mot\sudoku\acp\mot_sudoku_acp_module',
					'module_langname'	=> 'ACP_MOT_SUDOKU_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'ext_mot/sudoku && acl_a_manage_mot_sudoku',
				],
			]],
		];
	}
}
