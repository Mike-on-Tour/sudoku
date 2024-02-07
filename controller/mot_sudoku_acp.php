<?php
/*
*
* @package MoT Sudoku v0.4.0
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

	/** @var \phpbb\pagination  */
	protected $pagination;

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

	/** @var string mot.sudoku.tables.mot_sudoku_gamepacks */
	protected $mot_sudoku_gamepacks_table;

	/** @var string mot.sudoku.tables.mot_sudoku_samurai */
	protected $mot_sudoku_samurai_table;

	/** @var string mot.sudoku.tables.mot_sudoku_stats */
	protected $mot_sudoku_stats_table;

	/**
	 * {@inheritdoc
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language, \phpbb\log\log $log,
								\phpbb\pagination $pagination, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, $root_path, $mot_sudoku_classic_table, $mot_sudoku_gamepacks_table,
								$mot_sudoku_samurai_table, $mot_sudoku_stats_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->log = $log;
		$this->pagination = $pagination;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;

		$this->classic_sudoku_table = $mot_sudoku_classic_table;
		$this->sudoku_gamepacks_table = $mot_sudoku_gamepacks_table;
		$this->samurai_sudoku_table = $mot_sudoku_samurai_table;
		$this->sudoku_stats_table = $mot_sudoku_stats_table;

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

			case 'reset_game':
				if (confirm_box(true))
				{
					$this->reset_game();
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MOT_SUDOKU_LOG_RESET_GAME', false);
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
			'U_ACTION_RESET_GAME'						=> $this->u_action . '&amp;action=reset_game',

			'ACP_MOT_SUDOKU_VERSION_STRING'				=> $this->language->lang('ACP_MOT_SUDOKU_VERSION', $this->mot_sudoku_version, date('Y')),
		]);
	}

	public function gamepacks()
	{
		$form_key = 'acp_mot_sudoku_gamepacks';
		add_form_key($form_key);

		// set parameters for pagination
		$start = $this->request->variable('start', 0);
		$limit = (int) $this->config['posts_per_page'];

		$game_types = [
			'c'			=> $this->language->lang('MOT_SUDOKU_TAB_CLASSIC'),
			's'			=> $this->language->lang('MOT_SUDOKU_TAB_SAMURAI'),
			'n'			=> $this->language->lang('MOT_SUDOKU_TAB_NINJA'),
		];

		$selected_type = $this->request->variable('acp_mot_sudoku_select_type', 'all');

		$action = $this->request->variable('action', '');
		switch ($action)
		{
			case 'delete_gamepack':
				$pack_id = $this->request->variable('pack_id', 0);
				$pack_number = $this->request->variable('pack_number', 0);
				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . $this->sudoku_gamepacks_table . '
							WHERE pack_id=' . (int) $pack_id;
					$this->db->sql_query($sql);
					foreach ([$this->classic_sudoku_table, $this->samurai_sudoku_table
/*,$this->ninja_sudoku_table*/] as $table)
					{
						$sql = 'DELETE FROM ' . $table . ' WHERE game_pack = ' . (int) $pack_number;
						$this->db->sql_query($sql);
					}
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_DELETED_PACK', $pack_number) . adm_back_link($this->u_action . '&amp;acp_mot_sudoku_select_type=' . $selected_type), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>' . $this->language->lang('ACP_MOT_SUDOKU_PACK_DELETE', $pack_number) . '</p>', build_hidden_fields([
						'u_action'						=> $this->u_action . '&amp;action=delete_gamepack',
						'pack_id'						=> $pack_id,
						'pack_number'					=> $pack_number,
						'acp_mot_sudoku_select_type'	=> $selected_type,
					]));
				}
				break;

			case 'import_gamepack':
				$file_info = $this->request->file('acp_mot_sudoku_file');
				$filename = $file_info['name'];
				$temp_file = $file_info['tmp_name'];

				// Check for valid file extension
				$path_parts = pathinfo($filename);

				if ($path_parts['basename'] == '')
				{
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_NO_FILE') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (strtolower($path_parts['extension']) != 'xml' || !isset($path_parts['extension']))
				{
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_INVALID_FILE_EXT') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// load temp file (no need to store the file somewhere else since we only want the puzzles
				$xml = @simplexml_load_file($temp_file);
				if ($xml === false || $xml->getName() != 'mot_sudoku_pack')
				{
					trigger_error($this->language->lang('ACP_MOT_SUDOKU_INVALID_FILE_CONTENT') . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					// Get all currently existing items by their game pack number from the GAMEPACKS_TABLE
					$sql = 'SELECT game_pack FROM ' . $this->sudoku_gamepacks_table;
					$result = $this->db->sql_query($sql);
					$existing_packs = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$classic_sudoku = $samurai_sudoku = $ninja_sudoku = [];
					$game_type = [];

					foreach ($xml->children() as $row)
					{
						switch ($row->getName())
						{
							case 'classic_sudoku':
								if (!in_array(['game_pack' => $row->game_pack], $existing_packs))
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
								if (!in_array(['game_pack' => $row->game_pack], $existing_packs))
								{
									$samurai_sudoku[] = [
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

							case 'ninja_sudoku':

								break;
						}
					}

					$message = [];
					$classic_games = count($classic_sudoku);
					if (!empty($classic_sudoku))
					{
						$this->db->sql_multi_insert($this->classic_sudoku_table, $classic_sudoku);
						$message[] .= $this->language->lang('ACP_MOT_SUDOKU_CLASSIC_IMPORTED', $classic_games);
						$game_type[] = 'c';
					}

					$samurai_games = count($samurai_sudoku);
					if (!empty($samurai_sudoku))
					{
						$this->db->sql_multi_insert($this->samurai_sudoku_table, $samurai_sudoku);
						$message[] .= $this->language->lang('ACP_MOT_SUDOKU_SAMURAI_IMPORTED', $samurai_games);
						$game_type[] = 's';
					}

					$ninja_games = count($ninja_sudoku);
					if (!empty($ninja_sudoku))
					{
//						$this->db->sql_multi_insert($this->ninja_sudoku_table, $ninja_sudoku);
						$message[] .= $this->language->lang('ACP_MOT_SUDOKU_SAMURAI_IMPORTED', $ninja_games);
						$game_type[] = 'n';
					}

					if ($classic_games == 0 && $samurai_games == 0 && $ninja_games == 0)
					{
						trigger_error($this->language->lang('MOT_SUDOKU_NO_IMPORT') . adm_back_link($this->u_action) , E_USER_WARNING);
					}
					else
					{
						$sql_ary = [
							'game_pack'			=> $row->game_pack,
							'game_type'			=> implode(',', $game_type),
							'classic_count'		=> $classic_games,
							'samurai_count'		=> $samurai_games,
							'ninja_count'		=> $ninja_games,
							'install_date'		=> time(),
						];
						$sql = 'INSERT INTO ' . $this->sudoku_gamepacks_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						$this->db->sql_query($sql);
						trigger_error(implode('<br>', $message) . adm_back_link($this->u_action));
					}
				}

				break;
		}

		// Get gamepack data
		$sql = 'SELECT DISTINCT game_type FROM ' . $this->sudoku_gamepacks_table;
		$result = $this->db->sql_query($sql);
		$types = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		// Set the first select element
		$this->template->assign_block_vars('type_selections', [
			'VALUE'		=> 'all',
			'NAME'		=> $this->language->lang('ACP_MOT_SUDOKU_ALL'),
		]);
		$mixed = false;
		// Get the single type items
		foreach ($types as $arr)
		{
			if (in_array($arr['game_type'], ['c', 's', 'n']))
			{
				$this->template->assign_block_vars('type_selections', [
					'VALUE'		=> $arr['game_type'],
					'NAME'		=> $game_types[$arr['game_type']],
				]);
			}
			else
			{
				$mixed = true;
			}
		}
		// Check whether we have at least one mixed pack and if we do, add the respective variables
		if (!empty($mixed))
		{
				$this->template->assign_block_vars('type_selections', [
					'VALUE'		=> 'mix',
					'NAME'		=> $this->language->lang('ACP_MOT_SUDOKU_MIXED_PACK'),
				]);
		}

		// Prepare the 'WHERE' condition depending on the selected gamepack type
		$where = '';
		if (in_array($selected_type, ['c', 's', 'n']))
		{
			$where = " WHERE game_type = '" . (string) $selected_type . "'";
		}
		if ($selected_type == 'mix')
		{
			$where = " WHERE game_type NOT IN ('c','s','n')";
		}

		// get the total number of gamepacks
		$count_query = "SELECT COUNT(pack_id) AS 'pack_count' FROM " . $this->sudoku_gamepacks_table . $where;
		$result = $this->db->sql_query($count_query);
		$row = $this->db->sql_fetchrow($result);
		$pack_count = $row['pack_count'];
		$this->db->sql_freeresult($result);

		$sql = 'SELECT * FROM ' . $this->sudoku_gamepacks_table . $where;
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$game_packs = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		//base url for pagination
		$base_url = $this->u_action;

		// Load pagination
		$start = $this->pagination->validate_start($start, $limit, $pack_count);
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $pack_count, $limit, $start);

		foreach ($game_packs as $row)
		{
			$game_type_name = strlen($row['game_type']) == 1 ? $game_types[$row['game_type']] : $this->language->lang('ACP_MOT_SUDOKU_MIXED_PACK');

			switch (strlen($row['game_type']))
			{
				case 1:
					$game_count = $row['classic_count'] + $row['samurai_count'] + $row['ninja_count'];
					break;

				case 3:
				case 5:
					$game_count_ary = [];
					if ($row['classic_count'] > 0)
					{
						$game_count_ary[] = $row['classic_count'] . ' ' . $this->language->lang('ACP_MOT_SUDOKU_CLASSIC');
					}
					if ($row['samurai_count'] > 0)
					{
						$game_count_ary[] = $row['samurai_count'] . ' ' . $this->language->lang('ACP_MOT_SUDOKU_SAMURAI');
					}
					if ($row['ninja_count'] > 0)
					{
						$game_count_ary[] = $row['ninja_count'] . ' ' . $this->language->lang('ACP_MOT_SUDOKU_NINJA');
					}
					$game_count = implode('<br>', $game_count_ary);
					break;
			}

			$this->template->assign_block_vars('gamepacks', [
				'PACK_NUMBER'		=> $row['game_pack'],
				'PACK_TYPE'			=> $game_type_name,
				'GAME_COUNT'		=> $game_count,
				'INSTALL_DATE'		=> $this->user->format_date($row['install_date']),
				'U_DELETE'			=> $this->u_action . '&amp;action=delete_gamepack&amp;pack_id=' . $row['pack_id'] . '&amp;pack_number=' . $row['game_pack'] .
										'&amp;acp_mot_sudoku_select_type=' . $selected_type,
			]);
		}

		$this->template->assign_vars([
			'U_ACP_MS_SELECT_ACTION'				=> $this->u_action . '&amp;action=select_type',
			'U_ACTION_IMPORT_GAME_PACK'				=> $this->u_action . '&amp;action=import_gamepack',
			'ACP_MOT_SUDOKU_SELECT_TYPE'			=> $selected_type,

			'ACP_MOT_SUDOKU_VERSION_STRING'			=> $this->language->lang('ACP_MOT_SUDOKU_VERSION', $this->mot_sudoku_version, date('Y')),
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
	* Delete all game data from the database
	*
	* @param	none
	* @return	none
	*/
	private function reset_game()
	{
		$sql_ary = [
			'classic_played'	=> 0,
			'classic_points'	=> 0,
			'classic_ids'		=> '',
			'samurai_played'	=> 0,
			'samurai_points'	=> 0,
			'samurai_ids'		=> '',
			'ninja_played'	=> 0,
			'ninja_points'	=> 0,
			'ninja_ids'		=> '',
		];

		$sql = 'UPDATE ' . $this->sudoku_stats_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary);
		$this->db->sql_query($sql);

		return;
	}
}
