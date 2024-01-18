<?php
/*
*
* @package MoT Sudoku v0.2.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\controller;

use phpbb\exception\exception_interface;
use phpbb\exception\version_check_exception;

class mot_sudoku_acp
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/** @var \phpbb\log\log $log */
	protected $log;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string mot.sudoku.tables.mot_sudoku_classic */
	protected $mot_sudoku_classic_table;

	/**
	 * {@inheritdoc
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language,
								\phpbb\log\log $log, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, $root_path, $mot_sudoku_classic_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->log = $log;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;

		$this->classic_sudoku_table = $mot_sudoku_classic_table;

		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/sudoku');
		$this->mot_sudoku_version = $this->md_manager->get_metadata('version');
	}


	public function settings()
	{
		$form_key = 'acp_mot_sudoku_settings';
		add_form_key($form_key);

		$action = $this->request->variable('action', '');
		switch ($action)
		{
			case 'submit':
				if (!check_form_key($form_key))
				{
					trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// save the settings to the phpbb_config table
				$this->config->set('mot_sudoku_enable', $this->request->variable('mot_sudoku_enable', 0));
				$this->config->set('mot_sudoku_version_checker', $this->request->variable('mot_sudoku_version_checker', 0));
				$this->config->set('mot_sudoku_cache_enable', $this->request->variable('mot_sudoku_cache_enable', 0));
				$this->config->set('mot_sudoku_title_enable', $this->request->variable('mot_sudoku_title_enable', 0));
				$this->config->set('mot_sudoku_cell_points', $this->request->variable('mot_sudoku_cell_points', 5));
				$this->config->set('mot_sudoku_cell_cost', $this->request->variable('mot_sudoku_cell_cost', 15));
				$this->config->set('mot_sudoku_number_cost', $this->request->variable('mot_sudoku_number_cost', 40));
				$this->config->set('mot_sudoku_reset_cost', $this->request->variable('mot_sudoku_reset_cost', 200));
				$this->config->set('mot_sudoku_level_cost', $this->request->variable('mot_sudoku_level_cost', 10));
				$this->config->set('mot_sudoku_helper_enable', $this->request->variable('mot_sudoku_helper_enable', 0));
				$this->config->set('mot_sudoku_helper_cost', $this->request->variable('mot_sudoku_helper_cost', 0));
				$this->config->set('mot_sudoku_helper_samurai_enable', $this->request->variable('mot_sudoku_helper_samurai_enable', 0));
				$this->config->set('mot_sudoku_helper_samurai_cost', $this->request->variable('mot_sudoku_helper_samurai_cost', 0));
				$this->config->set('mot_sudoku_helper_ninja_enable', $this->request->variable('mot_sudoku_helper_ninja_enable', 0));
				$this->config->set('mot_sudoku_helper_ninja_cost', $this->request->variable('mot_sudoku_helper_ninja_cost', 0));
				// The folowing settings handle Ultimate Points and bonuses
				$this->config->set('mot_sudoku_points_enable', $this->request->variable('mot_sudoku_points_enable', 0));
				$this->config->set('mot_sudoku_points_ratio', $this->request->variable('mot_sudoku_points_ratio', 1));
				$this->config->set('mot_sudoku_reward_enable', $this->request->variable('mot_sudoku_reward_enable', 0));
				$this->config->set('mot_sudoku_reward_gc', $this->request->variable('mot_sudoku_reward_gc', 3600));
				$this->config->set('mot_sudoku_rank1_price', $this->request->variable('mot_sudoku_rank1_price', 1000));
				$this->config->set('mot_sudoku_rank2_price', $this->request->variable('mot_sudoku_rank2_price', 500));
				$this->config->set('mot_sudoku_rank3_price', $this->request->variable('mot_sudoku_rank3_price', 200));
				$this->config->set('mot_sudoku_high_average', $this->request->variable('mot_sudoku_high_average', 1500));
				$this->config->set('mot_sudoku_most_games', $this->request->variable('mot_sudoku_most_games', 700));
				$this->config->set('mot_sudoku_samurai_price', $this->request->variable('mot_sudoku_samurai_price', 3500));
				$this->config->set('mot_sudoku_ninja_price', $this->request->variable('mot_sudoku_ninja_price', 5000));
				$this->config->set('mot_sudoku_pm_enable', $this->request->variable('mot_sudoku_pm_enable', 0));
				$this->config->set('mot_sudoku_admin_id', $this->request->variable('mot_sudoku_admin_id', 0));

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MOT_SUDOKU_LOG_SETTING_SAVED', false);
				trigger_error($this->language->lang('ACP_MOT_SUDOKU_SETTING_SAVED') . adm_back_link($this->u_action));

				break;

			case 'purge_cache':
				if (!check_form_key($form_key))
				{
					trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$this->purge_cache();
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MOT_SUDOKU_PURGE_CACHE_LOG', false);
				trigger_error($this->language->lang('ACP_MOT_SUDOKU_PURGE_CACHE_MSG')  . adm_back_link($this->u_action));

				break;

			case 'import_gamepack':
				$file_info = $this->request->file('acp_mot_sudoku_file');
				$filename = $file_info['name'];
				$temp_file = $file_info['tmp_name'];

				// Check for valid file extension
				$path_parts = pathinfo($filename);
				if (strtolower($path_parts['extension']) != 'xml' || !isset($path_parts['extension']))
				{
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_INVALID_FILE_EXT') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// load temp file (no need to store the file somewhere else since we only want the search terms and - if they exist - the category
				$xml = @simplexml_load_file($temp_file);
				if ($xml === false || $xml->getName() != 'mot_sudoku_pack')
				{
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_INVALID_FILE_CONTENT') . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					// Get all currently existing items by their game pack and game number from the Classic Sudoku table
					$sql = 'SELECT game_pack, game_number FROM ' . $this->classic_sudoku_table;
					$result = $this->db->sql_query($sql);
					$classic_existing = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$classic_sudoku = $samurai_sudoku = $ninja_sudoku = [];

					foreach ($xml->children() as $row)
					{
						switch ($row->getName())
						{
							case 'classic_sudoku':
								if (!in_array(['game_pack' => $row->game_pack, 'game_number' => $row->game_number], $classic_existing))
								{
									$classic_sudoku[] = [
										'game_pack'			=> (int) $row->game_pack,
										'game_number'		=> (int) $row->game_number,
										'game_level'		=> (int) $row->game_level,
										'game_name'			=> (string) $row->game_name,
										'creator_name'		=> (string) $row->creator_name,
										'puzzle_line'		=> (string) $row->puzzle_line,
										'solution_line'		=> (string) $row->solution_line,
									];
								}

								break;

							case 'samurai_sudoku':

								break;

							case 'ninja_sudoku':

								break;
						}
					}

					$message = [];
					if (!empty($classic_sudoku))
					{
						$this->db->sql_multi_insert($this->classic_sudoku_table, $classic_sudoku);
					}
					$message[] = $this->language->lang('ACP_MOT_SUDOKU_CLASSIC_IMPORTED', count($classic_sudoku));

					trigger_error(implode('<br>', $message) . adm_back_link($this->u_action));
				}

				break;

			case 'reset_game':
				if (confirm_box(true))
				{
//					$this->reset_game();
//					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MOT_SUDOKU_LOG_RESET_GAME', false);
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_RESET_SUCCESS') . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(false, $this->language->lang('ACP_MOT_SUDOKU_RESET_GAME_CONFIRM_MSG'), build_hidden_fields([
						'u_action'	=> $this->u_action . '&amp;action=reset_game',
					]));
				}

				break;
		}

		$this->template->assign_var('S_MOT_SUDOKU_VERSIONCHECK', true);
		if ($this->config['mot_sudoku_version_checker'])
		{
			try
			{
				$ext_data = $this->phpbb_extension_manager->version_check($this->md_manager, true);
			}
			catch (version_check_exception $e)
			{
				// continue
			}
			catch (exception_interface $e)
			{
				$this->template->assign_var('S_MOT_SUDOKU_VERSIONCHECK', false);
			}
		}

		$up_enabled = $this->phpbb_extension_manager->is_enabled('dmzx/ultimatepoints');

		//Build a list of users within admin and mod groups
		$sql_ary = [
			'SELECT'    => 'u.user_id, u.username, ug.group_id',
			'FROM'      => [USERS_TABLE  => 'u', USER_GROUP_TABLE  => 'ug', GROUPS_TABLE  => 'g',],
			'WHERE'     => "u.user_id = ug.user_id
					AND g.group_id = ug.group_id
					AND (UPPER(g.group_name) LIKE 'ADMINISTRATORS' OR UPPER(g.group_name) LIKE '%MODERATOR%')",
			'GROUP_BY'  => 'username',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$admins = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$admin_list = '';
		foreach ($admins as $row)
		{
			$selected  = ( $row['user_id'] == $this->config['mot_sudoku_admin_id'] ) ? ' selected' : '';
			$admin_list .= '<option value = "' . $row['user_id'] . '"' .  $selected  . '>' . $row['username'] . '</option>';
		}

		$this->template->assign_vars([
			'S_ACP_MOT_SUDOKU_VERSION_UP_TO_DATE'		=> !empty($ext_data) ? version_compare($ext_data['current'], $this->mot_sudoku_version, '<') : true,
			'ACP_MOT_SUDOKU_CURRENT_VERSION'			=> $this->mot_sudoku_version,
			'ACP_MOT_SUDOKU_LATEST_VERSION'				=> !empty($ext_data) ? $ext_data['current'] : '',
			'ACP_MOT_SUDOKU_VERSION_CHECKER'			=> $this->config['mot_sudoku_version_checker'],
			'ACP_MOT_SUDOKU_ENABLE'						=> $this->config['mot_sudoku_enable'],
			'ACP_MOT_SUDOKU_CACHE_ENABLE'				=> $this->config['mot_sudoku_cache_enable'],
			'ACP_MOT_SUDOKU_TITLE_ENABLE'				=> $this->config['mot_sudoku_title_enable'],
			'ACP_MOT_SUDOKU_CELL_POINTS'				=> $this->config['mot_sudoku_cell_points'],
			'ACP_MOT_SUDOKU_CELL_COST'					=> $this->config['mot_sudoku_cell_cost'],
			'ACP_MOT_SUDOKU_NUMBER_COST'				=> $this->config['mot_sudoku_number_cost'],
			'ACP_MOT_SUDOKU_RESET_COST'					=> $this->config['mot_sudoku_reset_cost'],
			'ACP_MOT_SUDOKU_LEVEL_COST'					=> $this->config['mot_sudoku_level_cost'],
			'ACP_MOT_SUDOKU_HELPER_ENABLE'				=> $this->config['mot_sudoku_helper_enable'],
			'ACP_MOT_SUDOKU_HELPER_COST'				=> $this->config['mot_sudoku_helper_cost'],
			'ACP_MOT_SUDOKU_HELPER_SAMURAI_ENABLE'		=> $this->config['mot_sudoku_helper_samurai_enable'],
			'ACP_MOT_SUDOKU_HELPER_SAMURAI_COST'		=> $this->config['mot_sudoku_helper_samurai_cost'],
			'ACP_MOT_SUDOKU_HELPER_NINJA_ENABLE'		=> $this->config['mot_sudoku_helper_ninja_enable'],
			'ACP_MOT_SUDOKU_HELPER_NINJA_COST'			=> $this->config['mot_sudoku_helper_ninja_cost'],
			'ACP_MOT_SUDOKU_UP_ENABLED'					=> $up_enabled,
			'ACP_MOT_SUDOKU_POINTS_ENABLE'				=> $this->config['mot_sudoku_points_enable'],
			'ACP_MOT_SUDOKU_POINTS_RATIO'				=> $this->config['mot_sudoku_points_ratio'],
			'ACP_MOT_SUDOKU_UP_POINTS_NAME'				=> $this->config['points_name'] ?? $this->language->lang('ACP_MOT_SUDOKU_HELPER_POINTS_NAME'),
			'ACP_MOT_SUDOKU_REWARD_ENABLE'				=> $this->config['mot_sudoku_reward_enable'],
			'ACP_MOT_SUDOKU_REWARD_GC'					=> $this->config['mot_sudoku_reward_gc'],
			'ACP_MOT_SUDOKU_REWARD_LAST_GC'				=> $this->config['mot_sudoku_reward_last_gc'] ? $this->user->format_date($this->config['mot_sudoku_reward_last_gc']) : '-',
			'ACP_MOT_SUDOKU_REWARD_NEXT_GC'				=> $this->config['mot_sudoku_reward_last_gc'] ? $this->user->format_date($this->config['mot_sudoku_reward_last_gc'] + $this->config['mot_sudoku_reward_gc']) : '-',
			'ACP_MOT_SUDOKU_RANK1_PRICE'				=> $this->config['mot_sudoku_rank1_price'],
			'ACP_MOT_SUDOKU_RANK2_PRICE'				=> $this->config['mot_sudoku_rank2_price'],
			'ACP_MOT_SUDOKU_RANK3_PRICE'				=> $this->config['mot_sudoku_rank3_price'],
			'ACP_MOT_SUDOKU_HIGH_AVERAGE'				=> $this->config['mot_sudoku_high_average'],
			'ACP_MOT_SUDOKU_MOST_GAMES'					=> $this->config['mot_sudoku_most_games'],
			'ACP_MOT_SUDOKU_SAMURAI_PRICE'				=> $this->config['mot_sudoku_samurai_price'],
			'ACP_MOT_SUDOKU_NINJA_PRICE'				=> $this->config['mot_sudoku_ninja_price'],
			'ACP_MOT_SUDOKU_PM_ENABLE'					=> $this->config['mot_sudoku_pm_enable'],
			'ACP_MOT_SUDOKU_ADMIN_LIST'					=> $admin_list,
			'U_ACTION'									=> $this->u_action . '&amp;action=submit',
			'U_ACTION_CACHE_PURGE'						=> $this->u_action . '&amp;action=purge_cache',
			'U_ACTION_IMPORT_GAME_PACK'					=> $this->u_action . '&amp;action=import_gamepack',
			'U_ACTION_RESET_GAME'						=> $this->u_action . '&amp;action=reset_game',

			'ACP_MOT_SUDOKU_VERSION_STRING'				=> $this->language->lang('ACP_MOT_SUDOKU_VERSION', $this->mot_sudoku_version, date('Y')),
		]);
	}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Set custom form action.
	 *
	 * @param	string		$u_action	Custom form action
	 * @return	acp		$this		This controller for chaining calls
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;

		return $this;
	}

	/**
	* Purge the Sudoku cache
	*
	* @param	none
	* @return	none
	*/
	private function purge_cache()
	{
		$current_dir = $this->root_path . 'cache';

		if ( $dirname = @opendir($current_dir) )
		{
			while ( false !== ($file = @readdir($dirname)) )
			{
				if ( !is_dir($current_dir . '/' . $file)&&$file != "." && $file != ".." )
				{
					if ( stristr($file, '_sudoku') || stristr($file, '_samurai') )
					{
						@unlink($current_dir . '/' . $file);
					}
				}
			}
			@closedir($dirname);
		}
		return;
	}

	/**
	* Delete all game data from the database
	*
	* @param	none
	* @return	none
	*/
	private function reset_game()
	{
		$tables_ary = [SUDOKU_USERS, SUDOKU_STATS, SUDOKU_SESSIONS];

		foreach ($tables_ary as $table)
		{
			// Correctly handle empty table
			switch ($this->db->get_sql_layer())
			{
				case 'sqlite3':
					$this->db->sql_query('DELETE FROM ' . $table);
				break;

				default:
					$this->db->sql_query('TRUNCATE TABLE ' . $table);
				break;
			}
		}
		return;
	}
}
