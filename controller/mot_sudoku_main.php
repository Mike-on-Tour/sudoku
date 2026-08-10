<?php
/**
*
* @package MoT Sudoku v0.13.1
* @copyright (c) 2023 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\controller;

class mot_sudoku_main
{
	public function __construct(protected \phpbb\auth\auth $auth, protected \phpbb\config\config $config, protected \phpbb\db\driver\driver_interface $db, protected \phpbb\controller\helper $helper,
								protected \phpbb\language\language $language, protected \phpbb\pagination $pagination, protected \phpbb\extension\manager $phpbb_extension_manager,
								protected $phpbb_container, protected \phpbb\request\request_interface $request, protected \phpbb\template\template $template, protected \phpbb\user $user,
								protected $root_path, protected $classic_sudoku_table, protected $sudoku_fame_table, protected $sudoku_fame_month_table, protected $sudoku_fame_year_table,
								protected $sudoku_games_table, protected $ninja_sudoku_table, protected $samurai_sudoku_table, protected $sudoku_stats_table, protected $sudoku_saved_games_table)
	{
		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/sudoku');
		$this->ext_data = $this->md_manager->get_metadata();

		$this->level_array = [
			''			=> 1,
			'classic'	=> 1,
			'samurai'	=> 5,
			'ninja'		=> 9,
			'c'			=> 1,
			's'			=> 5,
			'n'			=> 9,
		];

		$this->classic_array = [
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0],
		];

		$this->samurai_array = [
			$this->classic_array, $this->classic_array,
			[
				[-1,-1,-1,0,0,0,-2,-2,-2],
				[-1,-1,-1,0,0,0,-2,-2,-2],
				[-1,-1,-1,0,0,0,-2,-2,-2],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[-4,-4,-4,0,0,0,-5,-5,-5],
				[-4,-4,-4,0,0,0,-5,-5,-5],
				[-4,-4,-4,0,0,0,-5,-5,-5],
			],
			$this->classic_array, $this->classic_array,
		];

		$this->ninja_array = [
			$this->classic_array, $this->classic_array,
			[
				[-19,-19,-19,0,0,0,-27,-27,-27],
				[-19,-19,-19,0,0,0,-27,-27,-27],
				[-19,-19,-19,0,0,0,-27,-27,-27],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[-43,-43,-43,0,0,0,-51,-51,-51],
				[-43,-43,-43,0,0,0,-51,-51,-51],
				[-43,-43,-43,0,0,0,-51,-51,-51],
			],
			$this->classic_array, $this->classic_array,
			[
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[-13,-13,-13,0,0,0,-21,-21,-21],
				[-13,-13,-13,0,0,0,-21,-21,-21],
				[-13,-13,-13,0,0,0,-21,-21,-21],
			],
			[
				[0,0,0,0,0,0,-17,-17,-17],
				[0,0,0,0,0,0,-17,-17,-17],
				[0,0,0,0,0,0,-17,-17,-17],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,-41,-41,-41],
				[0,0,0,0,0,0,-41,-41,-41],
				[0,0,0,0,0,0,-41,-41,-41],
			],
			[
				[-29,-29,-29,0,0,0,0,0,0],
				[-29,-29,-29,0,0,0,0,0,0],
				[-29,-29,-29,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[-53,-53,-53,0,0,0,0,0,0],
				[-53,-53,-53,0,0,0,0,0,0],
				[-53,-53,-53,0,0,0,0,0,0],
			],
			[
				[-49,-49,-49,0,0,0,-57,-57,-57],
				[-49,-49,-49,0,0,0,-57,-57,-57],
				[-49,-49,-49,0,0,0,-57,-57,-57],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0],
			],
		];

		$this->game_name_arr = [
			'c'		=> 'classic_',
			's'		=> 'samurai_',
			'n'		=> 'ninja_',
		];
	}

	public function handle()
	{
		if ($this->config['mot_sudoku_enable'] || $this->user->data['user_type'] == USER_FOUNDER)
		{
			//If user is a bot.... redirect to the index.
			if ($this->user->data['is_bot'])
			{
				redirect(append_sid("{$this->root_path}index." . $this->php_ext));
			}

			// Check if the user is logged in.
			if (!$this->user->data['is_registered'])
			{
				// Not logged in ? Redirect to the loginbox.
				login_box('', $this->language->lang('NO_AUTH_OPERATION'));
			}

			// Check permission
			if (!$this->auth->acl_get('u_play_mot_sudoku'))
			{
				trigger_error($this->language->lang('NO_AUTH_OPERATION'));
			}

			$this->load_action = $this->helper->route('mot_sudoku_main', ['tab' => 'load']);
			$this->classic_action = $this->helper->route('mot_sudoku_main', ['tab' => 'classic']);
			$this->samurai_action = $this->helper->route('mot_sudoku_main', ['tab' => 'samurai']);
			$this->ninja_action = $this->helper->route('mot_sudoku_main', ['tab' => 'ninja']);
			$this->rank_action = $this->helper->route('mot_sudoku_main', ['tab' => 'rank']);
			$this->fame_action = $this->helper->route('mot_sudoku_main', ['tab' => 'fame']);

			$this->difficulty = ['', $this->language->lang('MOT_SUDOKU_EASY'), $this->language->lang('MOT_SUDOKU_MEDIUM'), $this->language->lang('MOT_SUDOKU_HARD')];

			// Define the array holding the loadable games and get them from the DB if this feature is enabled
			$games_to_load = [];
			if ((bool) $this->config['mot_sudoku_enable_game_save'])
			{
				$sql_arr = [
					'SELECT'	=> "sg.*,
							CASE
								WHEN sg.game_type = 'c' THEN cs.game_name
								WHEN sg.game_type = 's' THEN ss.game_name
								WHEN sg.game_type = 'n' THEN ns.game_name
							END
							AS game_name
					",

					'FROM'		=> [
							$this->sudoku_saved_games_table		=> 'sg',
					],

					'LEFT_JOIN'	=> [
							[
									'FROM'	=> [$this->classic_sudoku_table	=> 'cs'],
									'ON'	=> "sg.game_type = 'c' AND cs.classic_id = sg.game_id",
							],
							[
									'FROM'	=> [$this->samurai_sudoku_table	=> 'ss'],
									'ON'	=> "sg.game_type = 's' AND ss.samurai_id = sg.game_id",
							],
							[
									'FROM'	=> [$this->ninja_sudoku_table	=> 'ns'],
									'ON'	=> "sg.game_type = 'n' AND ns.ninja_id = sg.game_id",
							],
					],

					'WHERE'		=> 'sg.user_id = ' . (int) $this->user->data['user_id'],

					'ORDER_BY'	=> 'sg.item_id ASC',
				];
				$sql = $this->db->sql_build_query('SELECT', $sql_arr);
				$result = $this->db->sql_query($sql);
				$games_to_load = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);
			}

			// Check whether saving games is enabled AND there are any stored games for this user
			$load_game_enabled = $this->config['mot_sudoku_enable_game_save'] && count($games_to_load);

			// Select the current tab
			$tab = $this->request->variable('tab', 'load');
			$tab = (($tab == 'load' && !$load_game_enabled) ||
					($tab == 'rank' && !$this->config['mot_sudoku_enable_rank']) ||
					($tab == 'fame' && !$this->config['mot_sudoku_enable_fame'])
					) ? 'classic' : $tab;

			// First check whether this user is already in the SUDOKU_STATS_TABLE
			$sql = 'SELECT * FROM ' . $this->sudoku_stats_table . '
					WHERE user_id = ' . (int) $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			$user_stats = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!$user_stats)
			{
				// No entry for this user, we have to store a new entry
				// Check user_id to prevent guest account to register into this table
				if ($this->user->data['is_registered'] && !$this->user->data['is_bot'])
				{
					$sql_arr = [
						'user_id'		=> $this->user->data['user_id'],
						'classic_ids'	=> json_encode([]),
						'samurai_ids'	=> json_encode([]),
						'ninja_ids'		=> json_encode([]),
					];
					$sql = 'INSERT INTO ' . $this->sudoku_stats_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
					$this->db->sql_query($sql);
				}
				else
				{
					// Not logged in? Redirect to the loginbox.
					login_box('', $this->language->lang('NO_AUTH_OPERATION'));
				}
			}

			switch ($tab)
			{
				case 'load':
					$action = $this->request->variable('action', '');
					$id = $this->request->variable('id', 0);

					switch ($action)
					{
						case 'load':
							$puzzle_to_load = $this->get_subarray($games_to_load, $id);

							$sql = "SELECT entry_id FROM " . $this->sudoku_games_table . "
									WHERE user_id = " . (int) $this->user->data['user_id'] . "
									AND game_type = '" . (string) $puzzle_to_load['game_type'] . "'";
							$result = $this->db->sql_query($sql);
							$active_id = $this->db->sql_fetchfield('entry_id');
							$this->db->sql_freeresult($result);

							if (confirm_box(true))
							{
								$table_arr = [
									'c'	=> $this->classic_sudoku_table,
									's'	=> $this->samurai_sudoku_table,
									'n'	=> $this->ninja_sudoku_table,
								];

								$action_arr = [
									'c'	=> $this->classic_action,
									's'	=> $this->samurai_action,
									'n'	=> $this->ninja_action,
								];

								if ($active_id)
								{
									// With an active game aborted we have to compute penalty points if they apply and delete it from the SUDOKU_GAMES_TABLE
									$up_points = $this->save_game_points($puzzle_to_load['user_id'], $puzzle_to_load['game_type'], 0, (-1 * (int) $this->config['mot_sudoku_abort_cost']), $active_id);
								}

								// Delete this puzzle from the SUDOKU_SAVED_GAMES_TABLE
								$sql = 'DELETE FROM ' . $this->sudoku_saved_games_table . '
										WHERE item_id = ' . (int) $id;
								$this->db->sql_query($sql);

								// Get the missing puzzle data from the respective puzzle table
								$sql = 'SELECT puzzle_line, solution_line FROM ' . $table_arr[$puzzle_to_load['game_type']] . '
										WHERE ' . $this->game_name_arr[$puzzle_to_load['game_type']] . 'id = ' . (int) $puzzle_to_load['game_id'];
								$result = $this->db->sql_query($sql);
								$lines = $this->db->sql_fetchrow($result);
								$this->db->sql_freeresult($result);
								$puzzle_to_load = array_merge($puzzle_to_load, $lines);

								// Delete unnecassery data from the array
								unset($puzzle_to_load['item_id'], $puzzle_to_load['game_name']);

								// Store the loaded puzzle to the SUDOKU_GAMES_TABLE
								$sql = 'INSERT INTO ' . $this->sudoku_games_table . ' ' . $this->db->sql_build_array('INSERT', $puzzle_to_load);
								$this->db->sql_query($sql);

								// Re-route to the approbriate game tab
								redirect($action_arr[$puzzle_to_load['game_type']]);
							}
							else
							{
								$msg = $this->language->lang('MOT_SUDOKU_LOAD_CONFIRM', $puzzle_to_load['game_name']);
								$msg .= $active_id ? $this->language->lang('MOT_SUDOKU_LOAD_ACTIVE_CONF') : '';
								$msg .= $active_id && (bool) $this->config['mot_sudoku_abort_cost'] ? $this->language->lang('MOT_SUDOKU_LOAD_PENALTY', $this->config['mot_sudoku_abort_cost']) : '';
								confirm_box(false, $msg, build_hidden_fields([
									$this->load_action,
									'action=load',
									'id=' . $id,
								]));
							}
							break;

						case 'delete':
							$puzzle_to_delete = $this->get_subarray($games_to_load, $id);

							if (confirm_box(true))
							{
								$sql = 'DELETE FROM ' . $this->sudoku_saved_games_table . '
										WHERE item_id = ' . (int) $id;
								$this->db->sql_query($sql);

								if ($this->config['mot_sudoku_abort_cost'])
								{
									$up_points = $this->save_game_points($puzzle_to_delete['user_id'], $puzzle_to_delete['game_type'], 0, (-1 * (int) $this->config['mot_sudoku_abort_cost']));
								}
								else
								{
									$up_points = false;
								}

								$msg = $this->language->lang('MOT_SUDOKU_DELETED_GAME', $puzzle_to_delete['game_name']);
								$msg .= (bool) $this->config['mot_sudoku_abort_cost'] ? $this->language->lang('MOT_SUDOKU_DELETED_POINTS', $this->config['mot_sudoku_abort_cost']) : '';
								$msg .= $up_points !== false ? $this->language->lang('MOT_SUDOKU_DELETED_UPPOINTS', (-1.00 * $up_points)) : '';
								$msg .= '<br><br><a href="' . $this->load_action . '">' . $this->language->lang('BACK_TO_PREV') . '</a>';

								trigger_error($msg);
							}
							else
							{
								confirm_box(false, $this->language->lang('MOT_SUDOKU_DELETE_CONFIRM', $puzzle_to_delete['game_name']), build_hidden_fields([
									$this->load_action,
									'action=delete',
									'id=' . $id,
								]));
							}
							break;
					}

					$this->template->assign_vars([
						'MOT_SUDOKU_GAMES_TO_LOAD'	=> $games_to_load,
						'ICON_LOAD'					=> '<i class="icon acp-icon acp-icon-load fa-folder-open fa-fw" title="' . $this->language->lang('MOT_SUDOKU_PUZZLE_LOAD') . '"></i>',
						'ICON_DELETE'				=> '<i class="icon acp-icon acp-icon-delete fa-times-circle fa-fw" title="' . $this->language->lang('MOT_SUDOKU_PUZZLE_DELETE') . '"></i>',
					]);
					break;

				case 'classic':
					if ($user_stats)
					{
						$modal_position = $user_stats['modal_position'];
						$games_solved = $user_stats['classic_played'];
						$total_points = $user_stats['classic_points'];
						$classic_ids = json_decode($user_stats['classic_ids']) ?? [];
					}
					else
					{
						$modal_position = 0;
						$games_solved = 0;
						$total_points = 0;
						$classic_ids = [];
					}

					$puzzle_exists = true;
					// Then check whether there is an unsolved puzzle for this user
					$sql = "SELECT * FROM " . $this->sudoku_games_table . "
							WHERE game_type = 'c'
							AND user_id = " . (int) $this->user->data['user_id'];
					$result = $this->db->sql_query($sql);
					$classic_puzzle = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if (empty($classic_puzzle))
					{
						// First we check, whether this user has stored puzzles of this type and if this is the case we get their game ids and incorporate them into the solved games array to prevent a stored puzzle to be presented again
						if (!empty($games_to_load))
						{
							$classic_ids = array_merge($classic_ids, $this->get_game_ids($games_to_load, $this->user->data['user_id'], 'c'));
						}

						// No unsolved puzzle so we can choose a new one which has not been played so far by this user
						$in_set = !empty($classic_ids) ? ' WHERE ' . $this->db->sql_in_set('classic_id', $classic_ids, true) : '';
						$sql = 'SELECT * FROM ' . $this->classic_sudoku_table . $in_set;
						$result = $this->db->sql_query($sql);
						$classic_puzzles = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						$classic_count = count($classic_puzzles);
						// Check whether we do have at least one puzzle to work with
						$puzzle_exists = $classic_count == 0 ? false : true;

						$game_level = 0;
						if ($puzzle_exists)
						{
							$puzzle_number = rand(0, $classic_count - 1);

							$classic_puzzle = $classic_puzzles[$puzzle_number];
							$game_info = $this->language->lang('MOT_SUDOKU_GAME_INFO', $classic_puzzle['game_pack'], $classic_puzzle['game_number'], $this->difficulty[$classic_puzzle['game_level']]);
							$title = ($this->config['mot_sudoku_title_enable'] && $classic_puzzle['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $classic_puzzle['game_name'] . '</strong>' : '';
							$puzzle_id = $classic_puzzle['classic_id'];
							$entry_id = 0;
							$player_line = json_encode($this->classic_array);
							$current_points = 0;
							$game_buy_digit = 0;
							$game_reset = 0;
							$game_helper = 0;
						}
					}
					else
					{
						// We have an unsolved puzzle, so we have to get its data and send it to the game
						$puzzle_id = $classic_puzzle['game_id'];
						$entry_id = $classic_puzzle['entry_id'];
						// Get some data from the original puzzle itself
						$sql = 'SELECT game_pack, game_number, game_level, game_name FROM ' . $this->classic_sudoku_table . '
								WHERE classic_id = ' . (int) $classic_puzzle['game_id'];
						$result = $this->db->sql_query($sql);
						$data_row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);
						$game_info = $this->language->lang('MOT_SUDOKU_GAME_INFO', $data_row['game_pack'], $data_row['game_number'], $this->difficulty[$data_row['game_level']]);
						$title = ($this->config['mot_sudoku_title_enable'] && $data_row['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $data_row['game_name'] . '</strong>' : '';
						$player_line = $classic_puzzle['player_line'];
						$current_points = (int) $classic_puzzle['points'];
						$game_reset = (int) $classic_puzzle['reset'];
						$game_buy_digit = (int) $classic_puzzle['buy_digit'];
						$game_helper = (int) $classic_puzzle['helper'];
						$game_level = (int) $classic_puzzle['level'];
					}

					if ($puzzle_exists)
					{
						$puzzle_line = json_decode($classic_puzzle['puzzle_line']);
						$pre_cells_arr = [];
						for ($i = 0; $i < 9; $i++)
						{
							for ($j = 0; $j < 9; $j++)
							{
								if ($puzzle_line[$i][$j])
								{
									$this->template->assign_var('MOT_SUDOKU_CELL_' . ($i + 1) . ($j + 1), $puzzle_line[$i][$j]);
									$pre_cells_arr[] = 'mot_sudoku_c_cell_id_' . ($i + 1) . ($j + 1);
								}
							}
						}
						$gainable_points = (81 - count($pre_cells_arr)) * $this->config['mot_sudoku_cell_points'];
						$empty_cells = $this->array_count_recursive($puzzle_line)[0];

						$this->template->assign_vars([
							'MOT_SUDOKU_PRE_CELLS_ARR'		=> json_encode($pre_cells_arr),
							'MOT_SUDOKU_CLASSIC_ID'			=> $puzzle_id,
							'MOT_SUDOKU_PUZZLE_LINE'		=> json_encode($puzzle_line),
							'MOT_SUDOKU_PLAYER_LINE_C'		=> $player_line,
						]);

						$helper_title = $this->language->lang('MOT_SUDOKU_HELPER_TITLE', $this->config['mot_sudoku_helper_cost']);
						$note_text = $this->language->lang('MOT_SUDOKU_NOTE_TEXT', $this->config['mot_sudoku_cell_points'], $this->config['mot_sudoku_cell_cost'],
										$this->config['mot_sudoku_number_cost'], $this->config['mot_sudoku_reset_cost'], $this->config['mot_sudoku_helper_cost'],
										$this->config['mot_sudoku_level_cost']
						);
						$helper_cost = $this->config['mot_sudoku_helper_cost'];
					}
					break;

				case 'samurai':
					if ($user_stats)		// Since a new user never can get here (classic is default) it seems we do not need this if statement and can do with the 'true' block - same for ninja
					{
						$modal_position = $user_stats['modal_position'];
						$games_solved = $user_stats['samurai_played'];
						$total_points = $user_stats['samurai_points'];
						$samurai_ids = json_decode($user_stats['samurai_ids']) ?? [];
					}
					else
					{
						$modal_position = 0;
						$games_solved = 0;
						$total_points = 0;
						$samurai_ids = [];
					}

					$puzzle_exists = true;
					// Then check whether there is an unsolved puzzle for this user
					$sql = "SELECT * FROM " . $this->sudoku_games_table . "
							WHERE game_type = 's'
							AND user_id = " . (int) $this->user->data['user_id'];
					$result = $this->db->sql_query($sql);
					$samurai_puzzle = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if (empty($samurai_puzzle))
					{
						// First we check, whether this user has stored puzzles of this type and if this is the case we get their game ids and incorporate them into the solved games array to prevent a stored puzzle to be presented again
						if (!empty($games_to_load))
						{
							$samurai_ids = array_merge($samurai_ids, $this->get_game_ids($games_to_load, $this->user->data['user_id'], 's'));
						}

						// No unsolved puzzle so we can choose a new one which has not been played so far by this user
						$in_set = !empty($samurai_ids) ? ' WHERE ' . $this->db->sql_in_set('samurai_id', $samurai_ids, true) : '';
						$sql = 'SELECT * FROM ' . $this->samurai_sudoku_table . $in_set;
						$result = $this->db->sql_query($sql);
						$samurai_puzzles = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						$samurai_count = count($samurai_puzzles);
						// Check whether we do have at least one puzzle to work with
						$puzzle_exists = $samurai_count == 0 ? false : true;

						$game_level = 0;
						if ($puzzle_exists)
						{
							$puzzle_number = rand(0, $samurai_count - 1);

							$samurai_puzzle = $samurai_puzzles[$puzzle_number];
							$game_info = $this->language->lang('MOT_SUDOKU_GAME_INFO', $samurai_puzzle['game_pack'], $samurai_puzzle['game_number'], $this->difficulty[$samurai_puzzle['game_level']]);
							$title = ($this->config['mot_sudoku_title_enable'] && $samurai_puzzle['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $samurai_puzzle['game_name'] . '</strong>' : '';
							$puzzle_id = $samurai_puzzle['samurai_id'];
							$entry_id = 0;
							$player_line = json_encode($this->samurai_array);
							$current_points = 0;
							$game_buy_digit = 0;
							$game_reset = 0;
							$game_helper = 0;
						}
					}
					else
					{
						// We have an unsolved puzzle, so we have to get its data and send it to the game
						$puzzle_id = $samurai_puzzle['game_id'];
						$entry_id = $samurai_puzzle['entry_id'];
						// Get some data from the original puzzle itself
						$sql = 'SELECT game_pack, game_number, game_level, game_name FROM ' . $this->samurai_sudoku_table . '
								WHERE samurai_id = ' . (int) $samurai_puzzle['game_id'];
						$result = $this->db->sql_query($sql);
						$data_row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);
						$game_info = $this->language->lang('MOT_SUDOKU_GAME_INFO', $data_row['game_pack'], $data_row['game_number'], $this->difficulty[$data_row['game_level']]);
						$title = ($this->config['mot_sudoku_title_enable'] && $data_row['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $data_row['game_name'] . '</strong>' : '';
						$player_line = $samurai_puzzle['player_line'];
						$current_points = (int) $samurai_puzzle['points'];
						$game_reset = (int) $samurai_puzzle['reset'];
						$game_buy_digit = (int) $samurai_puzzle['buy_digit'];
						$game_helper = (int) $samurai_puzzle['helper'];
						$game_level = (int) $samurai_puzzle['level'];
					}

					if ($puzzle_exists)
					{
						$puzzle_line = json_decode($samurai_puzzle['puzzle_line']);
						$pre_cells_arr = [];
						for ($grid = 0; $grid < 5; $grid++)
						{
							for ($i = 0; $i < 9; $i++)
							{
								for ($j = 0; $j < 9; $j++)
								{
									if ($puzzle_line[$grid][$i][$j] > 0)
									{
										$this->template->assign_var('MOT_SUDOKU_S_CELL_' . ($grid + 1) . '_' . ($i + 1) . ($j + 1), $puzzle_line[$grid][$i][$j]);
										$pre_cells_arr[] = 'mot_sudoku_s_cell_id_' . ($grid + 1) . '_' . ($i + 1) . ($j + 1);
									}
								}
							}
						}
						$gainable_points = (369 - count($pre_cells_arr)) * $this->config['mot_sudoku_cell_points'];
						$empty_cells = $this->array_count_recursive($puzzle_line)[0];

						$this->template->assign_vars([
							'MOT_SUDOKU_PRE_CELLS_ARR'		=> json_encode($pre_cells_arr),
							'MOT_SUDOKU_SAMURAI_ID'			=> $puzzle_id,
							'MOT_SUDOKU_PUZZLE_LINE'		=> json_encode($puzzle_line),
							'MOT_SUDOKU_PLAYER_LINE_S'		=> $player_line,
						]);

						$helper_title = $this->language->lang('MOT_SUDOKU_HELPER_TITLE', $this->config['mot_sudoku_helper_samurai_cost']);
						$note_text = $this->language->lang('MOT_SUDOKU_NOTE_TEXT', $this->config['mot_sudoku_cell_points'], $this->config['mot_sudoku_cell_cost'],
										$this->config['mot_sudoku_number_cost'], $this->config['mot_sudoku_reset_cost'], $this->config['mot_sudoku_helper_samurai_cost'],
										$this->config['mot_sudoku_level_cost']
						);
						$helper_cost = $this->config['mot_sudoku_helper_samurai_cost'];
					}
					break;

				case 'ninja':
					if ($user_stats)
					{
						$modal_position = $user_stats['modal_position'];
						$games_solved = $user_stats['ninja_played'];
						$total_points = $user_stats['ninja_points'];
						$ninja_ids = json_decode($user_stats['ninja_ids']) ?? [];
					}
					else
					{
						$modal_position = 0;
						$games_solved = 0;
						$total_points = 0;
						$ninja_ids = [];
					}

					$puzzle_exists = true;
					// Then check whether there is an unsolved puzzle for this user
					$sql = "SELECT * FROM " . $this->sudoku_games_table . "
							WHERE game_type = 'n'
							AND user_id = " . (int) $this->user->data['user_id'];
					$result = $this->db->sql_query($sql);
					$ninja_puzzle = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if (empty($ninja_puzzle))
					{
						// First we check, whether this user has stored puzzles of this type and if this is the case we get their game ids and incorporate them into the solved games array to prevent a stored puzzle to be presented again
						if (!empty($games_to_load))
						{
							$ninja_ids = array_merge($ninja_ids, $this->get_game_ids($games_to_load, $this->user->data['user_id'], 'n'));
						}

						// No unsolved puzzle so we can choose a new one which has not been played so far by this user
						$in_set = !empty($ninja_ids) ? ' WHERE ' . $this->db->sql_in_set('ninja_id', $ninja_ids, true) : '';
						$sql = 'SELECT * FROM ' . $this->ninja_sudoku_table . $in_set;
						$result = $this->db->sql_query($sql);
						$ninja_puzzles = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						$ninja_count = count($ninja_puzzles);
						// Check whether we do have at least one puzzle to work with
						$puzzle_exists = $ninja_count == 0 ? false : true;

						$game_level = 0;
						if ($puzzle_exists)
						{
							$puzzle_number = rand(0, $ninja_count - 1);

							$ninja_puzzle = $ninja_puzzles[$puzzle_number];
							$game_info = $this->language->lang('MOT_SUDOKU_GAME_INFO', $ninja_puzzle['game_pack'], $ninja_puzzle['game_number'], $this->difficulty[$ninja_puzzle['game_level']]);
							$title = ($this->config['mot_sudoku_title_enable'] && $ninja_puzzle['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $ninja_puzzle['game_name'] . '</strong>' : '';
							$puzzle_id = $ninja_puzzle['ninja_id'];
							$entry_id = 0;
							$player_line = json_encode($this->ninja_array);
							$current_points = 0;
							$game_buy_digit = 0;
							$game_reset = 0;
							$game_helper = 0;
						}
					}
					else
					{
						// We have an unsolved puzzle, so we have to get its data and send it to the game
						$puzzle_id = $ninja_puzzle['game_id'];
						$entry_id = $ninja_puzzle['entry_id'];
						// Get some data from the original puzzle itself
						$sql = 'SELECT game_pack, game_number, game_level, game_name FROM ' . $this->ninja_sudoku_table . '
								WHERE ninja_id = ' . (int) $ninja_puzzle['game_id'];
						$result = $this->db->sql_query($sql);
						$data_row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);
						$game_info = $this->language->lang('MOT_SUDOKU_GAME_INFO', $data_row['game_pack'], $data_row['game_number'], $this->difficulty[$data_row['game_level']]);
						$title = ($this->config['mot_sudoku_title_enable'] && $data_row['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $data_row['game_name'] . '</strong>' : '';
						$player_line = $ninja_puzzle['player_line'];
						$current_points = (int) $ninja_puzzle['points'];
						$game_reset = (int) $ninja_puzzle['reset'];
						$game_buy_digit = (int) $ninja_puzzle['buy_digit'];
						$game_helper = (int) $ninja_puzzle['helper'];
						$game_level = (int) $ninja_puzzle['level'];
					}

					if ($puzzle_exists)
					{
						$puzzle_line = json_decode($ninja_puzzle['puzzle_line']);
						$pre_cells_arr = [];
						for ($grid = 0; $grid < 9; $grid++)
						{
							for ($i = 0; $i < 9; $i++)
							{
								for ($j = 0; $j < 9; $j++)
								{
									if ($puzzle_line[$grid][$i][$j] > 0)
									{
										$this->template->assign_var('MOT_SUDOKU_N_CELL_' . ($grid + 1) . '_' . ($i + 1) . ($j + 1), $puzzle_line[$grid][$i][$j]);
										$pre_cells_arr[] = 'mot_sudoku_n_cell_id_' . ($grid + 1) . '_' . ($i + 1) . ($j + 1);
									}
								}
							}
						}
						$gainable_points = (621 - count($pre_cells_arr)) * $this->config['mot_sudoku_cell_points'];
						$empty_cells = $this->array_count_recursive($puzzle_line)[0];

						$this->template->assign_vars([
							'MOT_SUDOKU_PRE_CELLS_ARR'		=> json_encode($pre_cells_arr),
							'MOT_SUDOKU_NINJA_ID'			=> $puzzle_id,
							'MOT_SUDOKU_PUZZLE_LINE'		=> json_encode($puzzle_line),
							'MOT_SUDOKU_PLAYER_LINE_N'		=> $player_line,
						]);

						$helper_title = $this->language->lang('MOT_SUDOKU_HELPER_TITLE', $this->config['mot_sudoku_helper_ninja_cost']);
						$note_text = $this->language->lang('MOT_SUDOKU_NOTE_TEXT', $this->config['mot_sudoku_cell_points'], $this->config['mot_sudoku_cell_cost'],
										$this->config['mot_sudoku_number_cost'], $this->config['mot_sudoku_reset_cost'], $this->config['mot_sudoku_helper_ninja_cost'],
										$this->config['mot_sudoku_level_cost']
						);
						$helper_cost = $this->config['mot_sudoku_helper_ninja_cost'];
					}
					break;

				case 'rank':
					// set parameter for pagination
					$start = $this->request->is_set('start') ? $this->request->variable('start', 0) : 0;
					$limit = $this->config['posts_per_page'];	// max lines per page

					$selected_type = $this->request->is_set('mot_sudoku_rank_select_type') ? $this->request->variable('mot_sudoku_rank_select_type', '') : 'classic';

					// Get total numbers of players in score table
					$count_query = "SELECT COUNT(user_id) AS user_count FROM " . $this->sudoku_stats_table . "
									WHERE " . $selected_type . "_played > 0";
					$result = $this->db->sql_query($count_query);
					$row = $this->db->sql_fetchrow($result);
					$count_rankings = $row['user_count'];
					$this->db->sql_freeresult($result);

					// Get data from tables
					$sql_arr = [
						'SELECT'    => 'u.user_id, u.username, u.user_colour, s.*',
						'FROM'		=> [
							USERS_TABLE    		    	=> 'u',
							$this->sudoku_stats_table	=> 's',
						],
						'WHERE'		=> 'u.user_id = s.user_id
										AND ' . (string) $selected_type . '_played > 0',
						'ORDER_BY'	=> 's.' . $selected_type . '_points DESC'
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query_limit( $sql, $limit, $start );
					$user_ranking = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$i = $start;
					foreach ($user_ranking as $row)
					{
						$i++;
						$this->template->assign_block_vars('rankings', [
							'RANK'					=> $i,
							'USERNAME'				=> $row['username'],
							'USER_COLOUR'			=> $row['user_colour'],
							'RANK_GAMES'			=> $row[$selected_type . '_played'],
							'RANK_POINTS'			=> $row[$selected_type . '_points'],
							'RANK_AVG_POINTS'		=> number_format($row[$selected_type . '_points'] / $row[$selected_type . '_played'], 0, ',', ''),
						]);
					}

					//base url for pagination, filtering and sorting
					$base_url = $this->rank_action;

					// Load pagination
					$start = $this->pagination->validate_start($start, $limit, $count_rankings);
					$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_rankings, $limit, $start);

					$this->template->assign_vars([
						'MOT_SUDOKU_SELECT_TYPE_ARR'	=> [
							$this->language->lang('MOT_SUDOKU_TAB_CLASSIC')		=> 'classic',
							$this->language->lang('MOT_SUDOKU_TAB_SAMURAI')		=> 'samurai',
							$this->language->lang('MOT_SUDOKU_TAB_NINJA')		=> 'ninja',
						],
						'MOT_SUDOKU_SELECTED_TYPE'		=> $selected_type,
					]);
					break;

				case 'fame':
					// Get local date variables first
					$date_arr = getdate();
					$months_arr = ['', 'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];
					$number_of_rows = $this->config['mot_sudoku_fame_limit'];
					$selected_type = $this->request->is_set('mot_sudoku_fame_select_type') ? $this->request->variable('mot_sudoku_fame_select_type', '') : 'c';

					// Get best players of current month
					$sql_arr = [
						'SELECT'	=> 'SUM(f.games_played) AS games_played, SUM(f.total_points) AS total_points, u.username, u.user_colour',
						'FROM'		=> [$this->sudoku_fame_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'f.year = ' . (int) $date_arr['year'] . '
										AND f.month = ' . (int) $date_arr['mon'] . "
										AND game_type = '" . (string) $selected_type . "'",
						'GROUP_BY'	=> 'f.user_id',
						'ORDER_BY'	=> 'total_points DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT ' . $number_of_rows;
					$result = $this->db->sql_query($sql);
					$players = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					foreach ($players as $row)
					{
						$this->template->assign_block_vars('current_months', [
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'TOTAL_GAMES'	=> $row['games_played'],
							'TOTAL_POINTS'	=> $row['total_points'],
							'MEAN_POINTS'	=> $row['games_played'] ? number_format($row['total_points'] / $row['games_played'], 0, ',', '') : '-',
						]);
					}

					// Get best players of current year
					$sql_arr = [
						'SELECT'	=> 'SUM(f.games_played) AS games_played, SUM(f.total_points) AS total_points, u.username, u.user_colour',
						'FROM'		=> [$this->sudoku_fame_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'f.year = ' . (int) $date_arr['year'] . "
										AND game_type = '" . (string) $selected_type . "'",
						'GROUP_BY'	=> 'f.user_id',
						'ORDER_BY'	=> 'total_points DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT ' . $number_of_rows;
					$result = $this->db->sql_query($sql);
					$players = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					foreach ($players as $row)
					{
						$this->template->assign_block_vars('current_years', [
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'TOTAL_GAMES'	=> $row['games_played'],
							'TOTAL_POINTS'	=> $row['total_points'],
							'MEAN_POINTS'	=> number_format($row['total_points'] / $row['games_played'], 0, ',', '')
						]);
					}

					// Get the best payers of the last months
					$sql_arr = [
						'SELECT'	=> 'f.*, u.username, u.user_colour',
						'FROM'		=> [$this->sudoku_fame_month_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> "game_type = '" . (string) $selected_type . "'",
						'ORDER_BY'	=> 'f.month_id DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT ' . $number_of_rows;
					$result = $this->db->sql_query($sql);
					$months = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					// Now we can loop through this array and get the player with the most points for the respective months
					foreach ($months as $row)
					{
						$this->template->assign_block_vars('last_months', [
							'MONTH'			=> $this->language->lang($months_arr[$row['month']]) . ' ' . $row['year'],
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'TOTAL_GAMES'	=> $row['games_played'],
							'TOTAL_POINTS'	=> $row['total_points'],
							'MEAN_POINTS'	=> number_format($row['total_points'] / $row['games_played'], 0, ',', '')
						]);
					}

					// Get data for last years
					$sql_arr = [
						'SELECT'	=> 'f.*, u.username, u.user_colour',
						'FROM'		=> [$this->sudoku_fame_year_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> "game_type = '" . (string) $selected_type . "'",
						'ORDER_BY'	=> 'f.year DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT ' . $number_of_rows;
					$result = $this->db->sql_query($sql);
					$years = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					foreach ($years as $row)
					{
						$this->template->assign_block_vars('last_years', [
							'YEAR'			=> $row['year'],
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'TOTAL_GAMES'	=> $row['games_played'],
							'TOTAL_POINTS'	=> $row['total_points'],
							'MEAN_POINTS'	=> number_format($row['total_points'] / $row['games_played'], 0, ',', '')
						]);
					}

					$this->template->assign_vars([
						'MOT_SUDOKU_SELECT_TYPE_ARR'	=> [
							$this->language->lang('MOT_SUDOKU_TAB_CLASSIC')		=> 'c',
							$this->language->lang('MOT_SUDOKU_TAB_SAMURAI')		=> 's',
							$this->language->lang('MOT_SUDOKU_TAB_NINJA')		=> 'n',
						],
						'MOT_SUDOKU_SELECTED_TYPE'		=> $selected_type,
						'MOT_SUDOKU_NUMBER_MONTHS'		=> count($months),
						'MOT_SUDOKU_NUMBER_YEARS'		=> count($years),
					]);
					break;
			}

			// Prepare the level select field and tables
			if (in_array($tab, ['classic', 'samurai', 'ninja']))				// To prevent warnings due to undefined $game_level if highscore or hall of fame are selected
			{
				$level_select = '';
				for ($i = 0; $i < 7; $i++)
				{
					$selected = $game_level == $i ? ' selected' : '';
					$level_select .= '<option value="' . $i . '"' . $selected . '>' . $this->language->lang('MOT_SUDOKU_LEVEL_' . $i) . '</option>';
					$this->template->assign_block_vars('levels', [
						'NAME'		=> $this->language->lang('MOT_SUDOKU_LEVEL_' . $i),
						'DIGIT'		=> $this->level_array[$tab] * $i,
						'DEDUCT'	=> $this->level_array[$tab] * $i * $this->config['mot_sudoku_level_cost'],
					]);
				}

				$this->template->assign_vars([
					'MOT_SUDOKU_PUZZLE_EXISTS'		=> $puzzle_exists,
					'MOT_SUDOKU_NOTE_TEXT'			=> $puzzle_exists ? $note_text : '',
					'MOT_SUDOKU_GAME_INFO'			=> $puzzle_exists ? $game_info . $title : '',
					'MOT_SUDOKU_DIGIT_NO_BUY'		=> $puzzle_exists ? ($empty_cells == 1 ? 1 : 0) : 0,
					'MOT_SUDOKU_HELPER_TITLE'		=> $puzzle_exists ? $helper_title : '',
					'MOT_SUDOKU_SELECT_LEVEL'		=> $level_select,
					'MOT_SUDOKU_MODAL_SWITCH'		=> $modal_position,
					'MOT_SUDOKU_TOTAL_GAMES'		=> $games_solved,
					'MOT_SUDOKU_TOTAL_POINTS'		=> $total_points,
					'MOT_SUDOKU_MEAN_POINTS'		=> $games_solved ? number_format($total_points / $games_solved, 0, ',', '') : 0,
					'MOT_SUDOKU_GAINABLE_POINTS'	=> $puzzle_exists ? $gainable_points : 0,
					'MOT_SUDOKU_CURRENT_POINTS'		=> $puzzle_exists ? $current_points : 0,
					'MOT_SUDOKU_GAME_RESET'			=> $puzzle_exists ? $game_reset : 0,
					'MOT_SUDOKU_GAME_BUY_DIGIT'		=> $puzzle_exists ? $game_buy_digit : 0,
					'MOT_SUDOKU_GAME_HELPER'		=> $puzzle_exists ? $game_helper : 0,
					'MOT_SUDOKU_GAME_LEVEL'			=> $puzzle_exists ? $game_level : 0,
					'MOT_SUDOKU_ENTRY_ID'			=> $puzzle_exists ? $entry_id : 0,						// SUDOKU_PLAYERS_TABLE entry_id if loading an unsolved puzzle, 0 if new puzzle
					'MOT_SUDOKU_NEGATIVE_POINTS'	=> $puzzle_exists ?
														-1 * (($game_reset * $this->config['mot_sudoku_reset_cost']) + ($game_buy_digit * $this->config['mot_sudoku_number_cost']) +
														($game_helper * $helper_cost) + ($game_level * $this->level_array[$tab] * $this->config['mot_sudoku_level_cost']))
														: 0,
				]);
			}

			$this->template->assign_vars([
				'MOT_SUDOKU_SELECTED_TAB'		=> $tab,
				'MOT_SUDOKU_LOAD_TAB'			=> $this->load_action,
				'MOT_SUDOKU_CLASSIC_TAB'		=> $this->classic_action,
				'MOT_SUDOKU_SAMURAI_TAB'		=> $this->samurai_action,
				'MOT_SUDOKU_NINJA_TAB'			=> $this->ninja_action,
				'MOT_SUDOKU_RANK_TAB'			=> $this->rank_action,
				'MOT_SUDOKU_FAME_TAB'			=> $this->fame_action,
				'MOT_SUDOKU_ENABLE_SAVE'		=> $this->config['mot_sudoku_enable_game_save'],
				'MOT_SUDOKU_ENABLE_LOAD'		=> $load_game_enabled,
				'MOT_SUDOKU_ENABLE_RANK'		=> $this->config['mot_sudoku_enable_rank'],
				'MOT_SUDOKU_ENABLE_FAME'		=> $this->config['mot_sudoku_enable_fame'],
				'MOT_SUDOKU_ACTIVE'				=> true,								// signal the footer copyright notice that Sudoku is running
				'MOT_SUDOKU_AJAX_NUMBER'		=> $this->helper->route('mot_sudoku_ajax_number'),
				'MOT_SUDOKU_AJAX_RESET'			=> $this->helper->route('mot_sudoku_ajax_reset'),
				'MOT_SUDOKU_AJAX_BUY'			=> $this->helper->route('mot_sudoku_ajax_buy'),
				'MOT_SUDOKU_AJAX_HELPER'		=> $this->helper->route('mot_sudoku_ajax_helper'),
				'MOT_SUDOKU_AJAX_QUIT'			=> $this->helper->route('mot_sudoku_ajax_quit'),
				'MOT_SUDOKU_AJAX_SAVE'			=> $this->helper->route('mot_sudoku_ajax_save'),
				'MOT_SUDOKU_AJAX_MODAL'			=> $this->helper->route('mot_sudoku_ajax_modal'),
				'MOT_SUDOKU_AJAX_LEVEL'			=> $this->helper->route('mot_sudoku_ajax_level'),
				'MOT_SUDOKU_COPYRIGHT'			=> $this->ext_data['extra']['display-name'] . ' ' . $this->ext_data['version'] . ' &copy; Mike-on-Tour (<a href="' . $this->ext_data['homepage'] . '">' . $this->ext_data['homepage'] . '</a>)',
				'MOT_SUDOKU_GAME_RESET_TITLE'	=> $this->language->lang('MOT_SUDOKU_GAME_RESET_TITLE', $this->config['mot_sudoku_reset_cost']),
				'MOT_SUDOKU_BUY_NUMBER_TITLE'	=> $this->language->lang('MOT_SUDOKU_BUY_NUMBER_TITLE', $this->config['mot_sudoku_number_cost']),
				'MOT_SUDOKU_HELPER_ENABLED'		=> $this->config['mot_sudoku_helper_enable'],
				'MOT_SUDOKU_S_HELPER_ENABLED'	=> $this->config['mot_sudoku_helper_samurai_enable'],
				'MOT_SUDOKU_N_HELPER_ENABLED'	=> $this->config['mot_sudoku_helper_ninja_enable'],
				'MOT_SUDOKU_ABORT_COST'			=> (int) $this->config['mot_sudoku_abort_cost'],
				'MOT_SUDOKU_USER_ID'			=> $this->user->data['user_id'],
			]);

			// Add breadcrumbs link
			$this->template->assign_block_vars('navlinks', [
				'FORUM_NAME'	=> $this->language->lang('MOT_SUDOKU_TITLE'),
				'U_VIEW_FORUM'	=> $this->helper->route('mot_sudoku_main'),
			]);

			return $this->helper->render('@mot_sudoku/mot_sudoku_main.html', $this->language->lang('MOT_SUDOKU_TITLE'));
		}
		else
		{
			trigger_error($this->language->lang('NO_AUTH_OPERATION'));
		}
	}

	/**
	* This function gets called from the game js file after a digit has been selected
	*
	*/
	public function mot_sudoku_ajax_number()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);
			$sudoku_id = $this->request->variable('id', '');
			$sudoku_type = $this->request->variable('type', '');
			$sudoku_number = $this->request->variable('number', 0);
			$sudoku_cell = $this->request->variable('cell', '');
			$user_id = $this->request->variable('user_id', 0);

			// First we check whether the user is logged in
			if ((int) $user_id != $this->user->data['user_id'])
			{
				// Now we can send back the needed data
				$result = [
					'logged_in'		=> false,
				];

				return new \Symfony\Component\HttpFoundation\JsonResponse($result);
			}

			// Get the existing data from the database if we have a valid entry_id
			if ($sudoku_entry)
			{
				$sql = 'SELECT * FROM ' . $this->sudoku_games_table . '
						WHERE entry_id = ' . (int) $sudoku_entry;
				$result = $this->db->sql_query($sql);
				$sql_arr = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
			}

			// Check whether we already have this game in the database
			if (!$sudoku_entry)
			{
				// This is a new game and we have to store it in the database
				switch ($sudoku_type)
				{
					case 'c':
						// Make a new player line
						$player_line = $this->classic_array;
						// Get line and row of the cell just filled
						$line = ((int) substr($sudoku_cell, 0, 1)) - 1;
						$row = ((int) substr($sudoku_cell, 1, 1)) - 1;
						// Store the number in the player line
						$player_line[$line][$row] = $sudoku_number;

						$sql = 'SELECT puzzle_line, solution_line FROM ' . $this->classic_sudoku_table . '
								WHERE classic_id = ' . (int) $sudoku_id;
						$result = $this->db->sql_query($sql);
						$classic_puzzle = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						// Store all data as a new item
						$sql_arr = [
							'user_id'			=> $user_id,
							'game_type'			=> $sudoku_type,
							'game_id'			=> $sudoku_id,
							'points'			=> $sudoku_number ? $this->config['mot_sudoku_cell_points'] : $sudoku_number, // give points only if a real number was selected
							'player_line'		=> json_encode($player_line),
							'puzzle_line'		=> $classic_puzzle['puzzle_line'],
							'solution_line'		=> $classic_puzzle['solution_line'],
						];
						break;

					case 's':
						// Make a new player line
						$player_line = $this->samurai_array;
						// Get grid, line and row of the cell just filled
						$grid = ((int) substr($sudoku_cell, 0, 1)) - 1;
						$line = ((int) substr($sudoku_cell, 2, 1)) - 1;
						$row = ((int) substr($sudoku_cell, 3, 1)) - 1;
						// Store the number in the player line
						$player_line[$grid][$line][$row] = $sudoku_number;

						$sql = 'SELECT puzzle_line, solution_line FROM ' . $this->samurai_sudoku_table . '
								WHERE samurai_id = ' . (int) $sudoku_id;
						$result = $this->db->sql_query($sql);
						$samurai_puzzle = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						// Store all data as a new item
						$sql_arr = [
							'user_id'			=> $user_id,
							'game_type'			=> $sudoku_type,
							'game_id'			=> $sudoku_id,
							'points'			=> $sudoku_number ? $this->config['mot_sudoku_cell_points'] : $sudoku_number, // give points only if a real number was selected
							'player_line'		=> json_encode($player_line),
							'puzzle_line'		=> $samurai_puzzle['puzzle_line'],
							'solution_line'		=> $samurai_puzzle['solution_line'],
						];
						break;

					case 'n':
						// Make a new player line
						$player_line = $this->ninja_array;
						// Get grid, line and row of the cell just filled
						$grid = ((int) substr($sudoku_cell, 0, 1)) - 1;
						$line = ((int) substr($sudoku_cell, 2, 1)) - 1;
						$row = ((int) substr($sudoku_cell, 3, 1)) - 1;
						// Store the number in the player line
						$player_line[$grid][$line][$row] = $sudoku_number;

						$sql = 'SELECT puzzle_line, solution_line FROM ' . $this->ninja_sudoku_table . '
								WHERE ninja_id = ' . (int) $sudoku_id;
						$result = $this->db->sql_query($sql);
						$ninja_puzzle = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						// Store all data as a new item
						$sql_arr = [
							'user_id'			=> $user_id,
							'game_type'			=> $sudoku_type,
							'game_id'			=> $sudoku_id,
							'points'			=> $sudoku_number ? $this->config['mot_sudoku_cell_points'] : $sudoku_number, // give points only if a real number was selected
							'player_line'		=> json_encode($player_line),
							'puzzle_line'		=> $ninja_puzzle['puzzle_line'],
							'solution_line'		=> $ninja_puzzle['solution_line'],
						];
						break;
				}

				// Now we can store everything into the database
				$sql = 'INSERT INTO ' . $this->sudoku_games_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
				$this->db->sql_query($sql);
				// Get the entry_id
				$sudoku_entry = $this->db->sql_nextid();
			}
			else
			{
				// Existing game, we have to change  the existing data
				switch ($sudoku_type)
				{
					case 'c':
						// Get line and row of the cell just filled
						$line = ((int) substr($sudoku_cell, 0, 1)) - 1;
						$row = ((int) substr($sudoku_cell, 1, 1)) - 1;
						// Make the stored player line an array again
						$sql_arr['player_line'] = json_decode($sql_arr['player_line']);

						// Set the new digit or delete the old digit or exchange the digit according to the pressed button
						if ($sql_arr['player_line'][$line][$row] == 0)		// no existing digit
						{
							switch ($sudoku_number)
							{
								// Somebody tries to delete a nonexisting digit so do nothing
								case 0:
									break;

								// The player inserts a digit into an empty cell so we enter it and give him the points for this action
								default:
									$sql_arr['player_line'][$line][$row] = $sudoku_number;
									$sql_arr['points'] += $this->config['mot_sudoku_cell_points'];
									break;
							}
						}
						else		// in this cell already exists a digit
						{
							// The player either erases an existing digit or overwrites it so he gets deducted, but only if he does not try to overwrite a digit with the same digit
							if ($sudoku_number == 0 || $sudoku_number != $sql_arr['player_line'][$line][$row])
							{
								$sql_arr['points'] -= $this->config['mot_sudoku_cell_cost'];
							}
							$sql_arr['player_line'][$line][$row] = $sudoku_number;
						}
						// and encode the array again for storage
						$sql_arr['player_line'] = json_encode($sql_arr['player_line']);
						break;

					case 's':
					case 'n':
						// Get grid, line and row of the cell just filled
						$grid = ((int) substr($sudoku_cell, 0, 1)) - 1;
						$line = ((int) substr($sudoku_cell, 2, 1)) - 1;
						$row = ((int) substr($sudoku_cell, 3, 1)) - 1;
						// Make the stored player line an array again
						$sql_arr['player_line'] = json_decode($sql_arr['player_line']);

						// Set the new digit or delete the old digit or exchange the digit according to the pressed button
						if ($sql_arr['player_line'][$grid][$line][$row] == 0)		// no existing digit
						{
							switch ($sudoku_number)
							{
								// Somebody tries to delete a nonexisting digit so do nothing
								case 0:
									break;

								// The player inserts a digit into an empty cell so we enter it and give him the points for this action
								default:
									$sql_arr['player_line'][$grid][$line][$row] = $sudoku_number;
									$sql_arr['points'] += $this->config['mot_sudoku_cell_points'];
									break;
							}
						}
						else		// in this cell already exists a digit
						{
							// The player either erases an existing digit or overwrites it so he gets deducted, but only if he does not try to overwrite a digit with the same digit
							if ($sudoku_number == 0 || $sudoku_number != $sql_arr['player_line'][$grid][$line][$row])
							{
								$sql_arr['points'] -= $this->config['mot_sudoku_cell_cost'];
							}
							$sql_arr['player_line'][$grid][$line][$row] = $sudoku_number;
						}
						// and encode the array again for storage
						$sql_arr['player_line'] = json_encode($sql_arr['player_line']);
						break;
				}

				// And store everything back into the database
				$sql = 'UPDATE ' . $this->sudoku_games_table . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
						WHERE entry_id = ' . (int) $sudoku_entry;
				$this->db->sql_query($sql);
			}

			//  Everything is set so we can check whether the player entered a digit into every empty cell
			$puzzle_line = json_decode($sql_arr['puzzle_line']);
			$player_line = json_decode($sql_arr['player_line']);
			$filled = false;
			$solved = true;
			$wrong_digits = [];
			$up_points = 0;

			switch ($sudoku_type)
			{
				case 'c':
					$empty_cells = $this->count_empty_cells($player_line, $puzzle_line);

					// If we have only one empty cell we inhibit buying a digit
					$digit_no_buy = $empty_cells == 1 ? true : false;

					// Check if all cells are filled, if yes we can check whether the puzzle is solved or needs fixing
					if ($empty_cells == 0)
					{
						// Indicate that the player filled all cells
						$filled = true;

						// And now we check whether the cells are filled correctly
						$solution_line = json_decode($sql_arr['solution_line']);
						for ($i = 0; $i <= 8; $i++)
						{
							for ($j = 0; $j <= 8; $j++)
							{
								if ($player_line[$i][$j] + $puzzle_line[$i][$j] != $solution_line[$i][$j])
								{
									// Indicate that we do not have a valid solution
									$solved = false;
									$wrong_digits[] = [
										'i'		=> $i + 1,
										'j'		=> $j + 1,
									];
									// Delete the wrong digit
									$player_line[$i][$j] = 0;
									// Deduct points for deleted digit
									$sql_arr['points'] -= $this->config['mot_sudoku_cell_cost'];
								}
							}
						}
						$empty_cells = $this->count_empty_cells( $player_line, $puzzle_line);

						// If we have only one empty cell we inhibit buying a digit
						$digit_no_buy = $empty_cells == 1 ? true : false;

						// Now check whether we have a solved puzzle
						if ($solved)
						{
							// To get the really gained points we have to deduct the negative points
							$sql_arr['points'] -= (($sql_arr['reset'] * $this->config['mot_sudoku_reset_cost']) +
													($sql_arr['buy_digit'] * $this->config['mot_sudoku_number_cost']) +
													($sql_arr['helper'] * $this->config['mot_sudoku_helper_cost']) +
													($sql_arr['level'] * $this->level_array[$sudoku_type] * $this->config['mot_sudoku_level_cost']));

							// Now we can store this solved game into the SUDOKU_STATS_TABLE, delete it from the SUDOKU_GAMES_TABLE and update the SUDOKU_FAME_TABLE
							$up_points = $this->save_game_points((int) $sql_arr['user_id'], $sudoku_type, (int) $sql_arr['game_id'], (int) $sql_arr['points'], $sudoku_entry);
						}
						else
						{
							// Store the game into the SUDOKU_GAMES_TABLE
							$sql_arr['player_line'] = json_encode($player_line);
							$sql = 'UPDATE ' . $this->sudoku_games_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
									WHERE entry_id = ' . (int) $sudoku_entry;
							$this->db->sql_query($sql);
						}
					}
					break;

				case 's':
					$empty_cells = $this->count_empty_grid_cells($player_line, $puzzle_line, 5);

					// If we have only one empty cell we inhibit buying a digit
					$digit_no_buy = $empty_cells == 1 ? true : false;

					// Check if all cells are filled, if yes we can check whether the puzzle is solved or needs fixing
					if ($empty_cells == 0)
					{
						// Indicate that the player filled all cells
						$filled = true;

						// And now we check whether the cells are filled correctly
						$solution_line = json_decode($sql_arr['solution_line']);
						for ($g = 0; $g <= 4; $g++)
						{
							for ($i = 0; $i <= 8; $i++)
							{
								for ($j = 0; $j <= 8; $j++)
								{
									if (($player_line[$g][$i][$j] > -1) && ($player_line[$g][$i][$j] + $puzzle_line[$g][$i][$j] != $solution_line[$g][$i][$j]))
									{
										// Indicate that we do not have a valid solution
										$solved = false;
										$wrong_digits[] = [
											'g'		=> $g + 1,
											'i'		=> $i + 1,
											'j'		=> $j + 1,
										];
										// Delete the wrong digit
										$player_line[$g][$i][$j] = 0;
										// Deduct points for deleted digit
										$sql_arr['points'] -= $this->config['mot_sudoku_cell_cost'];
									}
								}
							}
						}
						$empty_cells = $this->count_empty_grid_cells( $player_line, $puzzle_line, 5);

						// If we have only one empty cell we inhibit buying a digit
						$digit_no_buy = $empty_cells == 1 ? true : false;

						// Now check whether we have a solved puzzle
						if ($solved)
						{
							// To get the really gained points we have to deduct the negative points
							$sql_arr['points'] -= (($sql_arr['reset'] * $this->config['mot_sudoku_reset_cost']) +
													($sql_arr['buy_digit'] * $this->config['mot_sudoku_number_cost']) +
													($sql_arr['helper'] * $this->config['mot_sudoku_helper_samurai_cost']) +
													($sql_arr['level'] * $this->level_array[$sudoku_type] * $this->config['mot_sudoku_level_cost']));

							// Now we can store this solved game into the SUDOKU_STATS_TABLE, delete it from the SUDOKU_GAMES_TABLE and update the SUDOKU_FAME_TABLE
							$up_points = $this->save_game_points((int) $sql_arr['user_id'], $sudoku_type, (int) $sql_arr['game_id'], (int) $sql_arr['points'], $sudoku_entry);
						}
						else
						{
							// Store the game into the SUDOKU_GAMES_TABLE
							$sql_arr['player_line'] = json_encode($player_line);
							$sql = 'UPDATE ' . $this->sudoku_games_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
									WHERE entry_id = ' . (int) $sudoku_entry;
							$this->db->sql_query($sql);
						}
					}
					break;

				case 'n':
					$empty_cells = $this->count_empty_grid_cells($player_line, $puzzle_line, 9);

					// If we have only one empty cell we inhibit buying a digit
					$digit_no_buy = $empty_cells == 1 ? true : false;

					// Check if all cells are filled, if yes we can check whether the puzzle is solved or needs fixing
					if ($empty_cells == 0)
					{
						// Indicate that the player filled all cells
						$filled = true;

						// And now we check whether the cells are filled correctly
						$solution_line = json_decode($sql_arr['solution_line']);
						for ($g = 0; $g < 9; $g++)
						{
							for ($i = 0; $i < 9; $i++)
							{
								for ($j = 0; $j < 9; $j++)
								{
									if (($player_line[$g][$i][$j] > -1) && ($player_line[$g][$i][$j] + $puzzle_line[$g][$i][$j] != $solution_line[$g][$i][$j]))
									{
										// Indicate that we do not have a valid solution
										$solved = false;
										$wrong_digits[] = [
											'g'		=> $g + 1,
											'i'		=> $i + 1,
											'j'		=> $j + 1,
										];
										// Delete the wrong digit
										$player_line[$g][$i][$j] = 0;
										// Deduct points for deleted digit
										$sql_arr['points'] -= $this->config['mot_sudoku_cell_cost'];
									}
								}
							}
						}
						$empty_cells = $this->count_empty_grid_cells( $player_line, $puzzle_line, 9);

						// If we have only one empty cell we inhibit buying a digit
						$digit_no_buy = $empty_cells == 1 ? true : false;

						// Now check whether we have a solved puzzle
						if ($solved)
						{
							// To get the really gained points we have to deduct the negative points
							$sql_arr['points'] -= (($sql_arr['reset'] * $this->config['mot_sudoku_reset_cost']) +
													($sql_arr['buy_digit'] * $this->config['mot_sudoku_number_cost']) +
													($sql_arr['helper'] * $this->config['mot_sudoku_helper_ninja_cost']) +
													($sql_arr['level'] * $this->level_array[$sudoku_type] * $this->config['mot_sudoku_level_cost']));

							// Now we can store this solved game into the SUDOKU_STATS_TABLE, delete it from the SUDOKU_GAMES_TABLE and update the SUDOKU_FAME_TABLE
							$up_points = $this->save_game_points((int) $sql_arr['user_id'], $sudoku_type, (int) $sql_arr['game_id'], (int) $sql_arr['points'], $sudoku_entry);
						}
						else
						{
							// Store the game into the SUDOKU_GAMES_TABLE
							$sql_arr['player_line'] = json_encode($player_line);
							$sql = 'UPDATE ' . $this->sudoku_games_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
									WHERE entry_id = ' . (int) $sudoku_entry;
							$this->db->sql_query($sql);
						}
					}
					break;
			}

			// Now we can send back the needed data
			$result = [
				'logged_in'		=> true,
				'entry_id'		=> $sudoku_entry,
				'points'		=> $sql_arr['points'],
				'player_line'	=> $player_line,
				'filled'		=> $filled,
				'solved'		=> $solved,
				'wrong_digits'	=> $wrong_digits,
				'digit_no_buy'	=> $digit_no_buy,
				'up_points'		=> $up_points,
			];

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

	/**
	* This function is called from the game when the reset button is pressed
	*
	*/
	public function mot_sudoku_ajax_reset()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);

			// Check whether we already have this game in the database
			if (!$sudoku_entry)
			{
				// Some practical joker tries to reset a new virgin game so ignore it
				$result = [
					'success'	=> false,
				];
			}
			else
			{
				$sql = 'SELECT * FROM ' . $this->sudoku_games_table . '
						WHERE entry_id = ' . (int) $sudoku_entry;
				$result = $this->db->sql_query($sql);
				$sql_arr = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// Check whether the player already gained points in this game, if not we refuse this action
				if (!$sql_arr['points'])
				{
					// No points gained so far, which can only happen if the player chose another level and has not entered any digits afterward
					$result = [
						'success'	=> false,
					];
				}
				else
				{
					// Now we check whether the user is still logged in
					if ($sql_arr['user_id'] != $this->user->data['user_id'])
					{
						// Now we can send back the needed data
						$result = [
							'success'		=> true,		// We have to set this to true to prevent the error messge from being displayed
							'logged_in'		=> false,
						];

						return new \Symfony\Component\HttpFoundation\JsonResponse($result);
					}

					// Increment the reset count
					$sql_arr['reset']++;
					// Reset the points
					$sql_arr['points'] = 0;

					// and reset all entries according to the game type
					switch ($sql_arr['game_type'])
					{
						case 'c':
							$player_line = $this->classic_array;
							$helper_cost = $this->config['mot_sudoku_helper_cost'];
							break;

						case 's':
							$player_line = $this->samurai_array;
							$helper_cost = $this->config['mot_sudoku_helper_samurai_cost'];
							break;

						case 'n':
							$player_line = $this->ninja_array;
							$helper_cost = $this->config['mot_sudoku_helper_ninja_cost'];
							break;
					}

					$sql_arr['player_line'] = json_encode($player_line);
					// and write it back to the database
					$sql = 'UPDATE ' . $this->sudoku_games_table . '
							SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
							WHERE entry_id = ' . (int) $sudoku_entry;
					$this->db->sql_query($sql);

					// Now we can send back the needed data
					$result = [
						'success'			=> true,
						'logged_in'			=> true,
						'type'				=> $sql_arr['game_type'],
						'puzzle_line'		=> json_decode($sql_arr['puzzle_line']),			// do not send a json encoded array, for some reason unknown to me this does not work
						'player_line'		=> $player_line,
						'reset'				=> $sql_arr['reset'],
						'points'			=> $sql_arr['points'],
						'negative_points'	=> -1 * (($sql_arr['reset'] * $this->config['mot_sudoku_reset_cost']) + ($sql_arr['buy_digit'] * $this->config['mot_sudoku_number_cost']) + ($sql_arr['helper'] * $helper_cost) + ($sql_arr['level'] * $this->level_array[$sql_arr['game_type']] * $this->config['mot_sudoku_level_cost'])),
					];
				}
			}

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

	/**
	* This function is called from the game when the 'buy digit' button is pressed
	*
	*/
	public function mot_sudoku_ajax_buy()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);

			// Check whether we already have this game in the database
			if (!$sudoku_entry)
			{
				// Some practical joker tries to buy a digit in a new virgin game so ignore it
				$result = [
					'success'	=> false,
				];
			}
			else
			{
				// Get this puzzles data
				$sql = 'SELECT * FROM ' . $this->sudoku_games_table . '
						WHERE entry_id = ' . (int) $sudoku_entry;
				$result = $this->db->sql_query($sql);
				$sql_arr = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// Check whether the player already gained points in this game, if not we refuse this action
				if (!$sql_arr['points'])
				{
					// No points gained so far, which can only happen if the player chose another level and has not entered any digits afterward
					$result = [
						'success'	=> false,
					];
				}
				else
				{
					// Now we check whether the user is still logged in
					if ($sql_arr['user_id'] != $this->user->data['user_id'])
					{
						// Now we can send back the needed data
						$result = [
							'success'		=> true,		// We have to set this to true to prevent the error messge from being displayed
							'logged_in'		=> false,
						];

						return new \Symfony\Component\HttpFoundation\JsonResponse($result);
					}

					// Decode the needed arrays
					$player_line = json_decode($sql_arr['player_line']);
					$puzzle_line = json_decode($sql_arr['puzzle_line']);
					$solution_line = json_decode($sql_arr['solution_line']);

					// and get a random number according to the game type
					switch ($sql_arr['game_type'])
					{
						case 'c':
							// Get random numbers for line and column
							do
							{
								$i = rand(0, 8);
								$j = rand(0, 8);
							} while (!($player_line[$i][$j] == 0 && $puzzle_line[$i][$j] == 0));

							// We found a matching cell, now get its digit from the solution
							$digit = $solution_line[$i][$j];
							// and write it into the puzzle array
							$puzzle_line[$i][$j] = $digit;

							// Now we have to set all the other variables to their new values
							// Increment the buy digit count
							$sql_arr['buy_digit']++;
							$sql_arr['puzzle_line'] = json_encode($puzzle_line);
							$empty_cells = $this->array_count_recursive($puzzle_line);
							$g = 0;		// Just for compatibility reasons, this is not needed in classic puzzles but a value has to be given in the ajax response
							$helper_cost = $this->config['mot_sudoku_helper_cost'];
							break;

						case 's':
						case 'n':
							$grid = $sql_arr['game_type'] == 's' ? 4 : 8;
							// Get random numbers for grid, line and column
							do
							{
								$g = rand(0, $grid);
								$i = rand(0, 8);
								$j = rand(0, 8);
							} while (!($player_line[$g][$i][$j] == 0 && $puzzle_line[$g][$i][$j] == 0));

							// We found a matching cell, now get its digit from the solution
							$digit = $solution_line[$g][$i][$j];
							// and write it into the puzzle array
							$puzzle_line[$g][$i][$j] = $digit;

							// Now we have to set all the other variables to their new values
							// Increment the buy digit count
							$sql_arr['buy_digit']++;
							$sql_arr['puzzle_line'] = json_encode($puzzle_line);
							$empty_cells = $this->array_count_recursive($puzzle_line);
							$helper_cost = $sql_arr['game_type'] == 's' ? $this->config['mot_sudoku_helper_samurai_cost'] : $this->config['mot_sudoku_helper_ninja_cost'];
							break;
					}

					// and write it back to the database
					$sql = 'UPDATE ' . $this->sudoku_games_table . '
							SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
							WHERE entry_id = ' . (int) $sudoku_entry;
					$this->db->sql_query($sql);

					// Now we can send back the needed data
					$result = [
						'success'			=> true,
						'logged_in'			=> true,
						'type'				=> $sql_arr['game_type'],
						'g'					=> $g,
						'i'					=> $i,
						'j'					=> $j,
						'digit'				=> $digit,
						'puzzle_line'		=> $puzzle_line,
						'gainable_points'	=> $empty_cells[0] * $this->config['mot_sudoku_cell_points'],
						'negative_points'	=> -1 * (($sql_arr['reset'] * $this->config['mot_sudoku_reset_cost']) + ($sql_arr['buy_digit'] * $this->config['mot_sudoku_number_cost']) + ($sql_arr['helper'] * $helper_cost) + ($sql_arr['level'] * $this->level_array[$sql_arr['game_type']] * $this->config['mot_sudoku_level_cost'])),
					];
				}
			}

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

	/**
	* This function is called from the game when the helper button is pressed for the first time in a game
	*
	*/
	public function mot_sudoku_ajax_helper()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);

			// Get this puzzles data
			$sql = 'SELECT * FROM ' . $this->sudoku_games_table . '
					WHERE entry_id = ' . (int) $sudoku_entry;
			$result = $this->db->sql_query($sql);
			$sql_arr = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			// Check whether the player already gained points in this game, if not we refuse this action
			if (!$sql_arr['points'])
			{
				// No points gained so far, which can only happen if the player chose another level and has not entered any digits afterward
				$result = [
					'success'	=> false,
				];
			}
			else
			{
				// increment the helper count
				$sql_arr['helper']++;

				// and write it back to the database
				$sql = 'UPDATE ' . $this->sudoku_games_table . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
						WHERE entry_id = ' . (int) $sudoku_entry;
				$this->db->sql_query($sql);

				// Get the appropriate number of helper cost points
				switch ($sql_arr['game_type'])
				{
						case 'c':
							$helper_cost = $this->config['mot_sudoku_helper_cost'];
							break;

						case 's':
							$helper_cost = $this->config['mot_sudoku_helper_samurai_cost'];
							break;

						case 'n':
							$helper_cost = $this->config['mot_sudoku_helper_ninja_cost'];
							break;
				}

				// Now we can send back the needed data
				$result = [
					'success'			=> true,
					'type'				=> $sql_arr['game_type'],
					'negative_points'	=> -1 * (($sql_arr['reset'] * $this->config['mot_sudoku_reset_cost']) + ($sql_arr['buy_digit'] * $this->config['mot_sudoku_number_cost']) + ($sql_arr['helper'] * $helper_cost) + ($sql_arr['level'] * $this->level_array[$sql_arr['game_type']] * $this->config['mot_sudoku_level_cost'])),
				];
			}

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

	/**
	* Handle aborting the game
	*
	*/
	public function mot_sudoku_ajax_quit()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);
			$user_id = $this->request->variable('user_id', 0);
			$sudoku_type = $this->request->variable('type', '');

			$result = [
				'logged_in'	=> false,
				'success'	=> false,
				'points'	=> (int) $this->config['mot_sudoku_abort_cost'],
				'up_points'	=> 0,
			];

			// First we check whether the user is logged in
			if ((int) $user_id == $this->user->data['user_id'])
			{
				// Flag the user as logged in
				$result['logged_in'] = true;

				if ($sudoku_entry)	// Check whether the player wants do abort a game in progress
				{
					if ((int) $this->config['mot_sudoku_abort_cost'] > 0)	// Is there a penalty for aborting?
					{
						// Save the penalty points (using 0 as game_id, so this puzzle can again be presented at another time)
						$result['up_points'] = $this->save_game_points($user_id, $sudoku_type, 0, (-1 * (int) $this->config['mot_sudoku_abort_cost']), $sudoku_entry);
					}

					// Now delete this game from the SUDOKU_GAMES_TABLE
					$sql = 'DELETE FROM ' . $this->sudoku_games_table . '
							WHERE entry_id = ' . (int) $sudoku_entry;
					$this->db->sql_query($sql);

					// Flag the delete operation as successful
					$result['success'] = true;
				}
			}

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

	/*
	* Handle saving a game
	*
	*/
	public function mot_sudoku_ajax_save()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);
			$user_id = $this->request->variable('user_id', 0);

			$result = [
				'logged_in'	=> false,
				'success'	=> false,
			];

			// First we check whether the user is logged in
			if ((int) $user_id == $this->user->data['user_id'])
			{
				// Flag the user as logged in
				$result['logged_in'] = true;

				if ($sudoku_entry)	// Check whether the player wants do abort a game in progress
				{
					// Get the game data from the MOT_SUDOKU_GAMES_TABLE
					$sql = 'SELECT user_id, game_type, game_id, reset, buy_digit, helper, level, points, player_line FROM ' . $this->sudoku_games_table . '
							WHERE entry_id = ' . (int) $sudoku_entry;
					$sql_result = $this->db->sql_query($sql);
					$game = $this->db->sql_fetchrow($sql_result);
					$this->db->sql_freeresult($sql_result);

					// Store the data into the MOT_SUDOKU_SAVED_GAMES_TABLE
					$sql = 'INSERT INTO ' . $this->sudoku_saved_games_table . ' ' . $this->db->sql_build_array('INSERT', $game);
					$this->db->sql_query($sql);

					// Now delete this game from the SUDOKU_GAMES_TABLE
					$sql = 'DELETE FROM ' . $this->sudoku_games_table . '
							WHERE entry_id = ' . (int) $sudoku_entry;
					$this->db->sql_query($sql);

					// Flag the delete operation as successful
					$result['success'] = true;
				}
			}

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

	/**
	* Handle the level select
	*
	*/
	public function mot_sudoku_ajax_level()
	{
		if ($this->request->is_ajax())
		{
			$sudoku_entry = $this->request->variable('entry', 0);
			$sudoku_id = $this->request->variable('id', 0);
			$sudoku_type = $this->request->variable('type', '');
			$sudoku_level = $this->request->variable('level', 0);
			$user_id = $this->request->variable('user_id', 0);

			// First we check whether the user is logged in
			if ((int) $user_id != $this->user->data['user_id'])
			{
				// Now we can send back the needed data
				$result = [
					'logged_in'		=> false,
				];

				return new \Symfony\Component\HttpFoundation\JsonResponse($result);
			}

			// Check whether we already have this game in the database
			if (!$sudoku_entry) 	// Setting the level is only possible if we have a new game and no digit entered so far (so the entry_id equals 0)
			{
				switch ($sudoku_type)
				{
					case 'c':
						// Make a new player line
						$player_line = $this->classic_array;

						// Since this is a new game we have to get the information from the correct puzzle type table
						$sql = 'SELECT puzzle_line, solution_line FROM ' . $this->classic_sudoku_table . '
								WHERE classic_id = ' . (int) $sudoku_id;
						$result = $this->db->sql_query($sql);
						$classic_puzzle = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						// Get the puzzle line and add the additional digits according to the level
						$new_digits_arr = [];
						$puzzle_line = json_decode($classic_puzzle['puzzle_line']);
						$solution_line = json_decode($classic_puzzle['solution_line']);
						for ($l = 0; $l < $sudoku_level; $l++)
						{
							// Get random numbers for line and column
							do
							{
								$i = rand(0, 8);
								$j = rand(0, 8);
							} while (!($puzzle_line[$i][$j] == 0));

							// We found a matching cell, now get its digit from the solution
							$digit = $solution_line[$i][$j];
							// and write it into the puzzle array
							$puzzle_line[$i][$j] = $digit;
							// and into the array we will pass back to fill the grid
							$new_digits_arr[] = [
								'i'			=> $i,
								'j'			=> $j,
								'digit'		=> $digit,
							];
						}
						// Get the new count of empty cells
						$empty_cells = $this->array_count_recursive($puzzle_line);

						break;

					case 's':
						// Make a new player line
						$player_line = $this->samurai_array;

						// Since this is a new game we have to get the information from the correct puzzle type table
						$sql = 'SELECT puzzle_line, solution_line FROM ' . $this->samurai_sudoku_table . '
								WHERE samurai_id = ' . (int) $sudoku_id;
						$result = $this->db->sql_query($sql);
						$samurai_puzzle = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						// Get the puzzle line and add the additional digits according to the level
						$new_digits_arr = [];
						$puzzle_line = json_decode($samurai_puzzle['puzzle_line']);
						$solution_line = json_decode($samurai_puzzle['solution_line']);
						for ($g = 0; $g < 5; $g++)
						{
							for ($l = 0; $l < $sudoku_level; $l++)
							{
								// Get random numbers for grid, line and column
								do
								{
									$i = rand(0, 8);
									$j = rand(0, 8);
								} while (!($puzzle_line[$g][$i][$j] == 0));

								// We found a matching cell, now get its digit from the solution
								$digit = $solution_line[$g][$i][$j];
								// and write it into the puzzle array
								$puzzle_line[$g][$i][$j] = $digit;
								// and into the array we will pass back to fill the grid
								$new_digits_arr[] = [
									'g'			=> $g,
									'i'			=> $i,
									'j'			=> $j,
									'digit'		=> $digit,
								];
							}
						}
						// Get the new count of empty cells
						$empty_cells = $this->array_count_recursive($puzzle_line);

						break;

					case 'n':
						// Make a new player line
						$player_line = $this->ninja_array;

						// Since this is a new game we have to get the information from the correct puzzle type table
						$sql = 'SELECT puzzle_line, solution_line FROM ' . $this->ninja_sudoku_table . '
								WHERE ninja_id = ' . (int) $sudoku_id;
						$result = $this->db->sql_query($sql);
						$ninja_puzzle = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						// Get the puzzle line and add the additional digits according to the level
						$new_digits_arr = [];
						$puzzle_line = json_decode($ninja_puzzle['puzzle_line']);
						$solution_line = json_decode($ninja_puzzle['solution_line']);
						for ($g = 0; $g < 9; $g++)
						{
							for ($l = 0; $l < $sudoku_level; $l++)
							{
								// Get random numbers for line and column
								do
								{
									$i = rand(0, 8);
									$j = rand(0, 8);
								} while (!($puzzle_line[$g][$i][$j] == 0));

								// We found a matching cell, now get its digit from the solution
								$digit = $solution_line[$g][$i][$j];
								// and write it into the puzzle array
								$puzzle_line[$g][$i][$j] = $digit;
								// and into the array we will pass back to fill the grid
								$new_digits_arr[] = [
									'g'			=> $g,
									'i'			=> $i,
									'j'			=> $j,
									'digit'		=> $digit,
								];
							}
						}
						// Get the new count of empty cells
						$empty_cells = $this->array_count_recursive($puzzle_line);

						break;
				}

				// Store all data as a new item
				$sql_arr = [
					'user_id'			=> $this->user->data['user_id'],
					'game_type'			=> $sudoku_type,
					'game_id'			=> $sudoku_id,
					'level'				=> $sudoku_level,
					'player_line'		=> json_encode($player_line),
					'puzzle_line'		=> json_encode($puzzle_line),
					'solution_line'		=> json_encode($solution_line),
				];
				$sql = 'INSERT INTO ' . $this->sudoku_games_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
				$this->db->sql_query($sql);
				// Get the entry_id
				$sudoku_entry = $this->db->sql_nextid();

				$result = [
					'entry_id'			=> $sudoku_entry,
					'type'				=> $sudoku_type,
					'new_digits'		=> $new_digits_arr,
					'puzzle_line'		=> $puzzle_line,
					'gainable_points'	=> $empty_cells[0] * $this->config['mot_sudoku_cell_points'],
					'negative_points'	=> -1 * ($sql_arr['level'] * $this->level_array[$sudoku_type] * $this->config['mot_sudoku_level_cost']),
					'logged_in'			=> true,
				];

				return new \Symfony\Component\HttpFoundation\JsonResponse($result);
			}
		}
	}

	/**
	* This function is called from the game js file when the player selects another position for the modal window
	*
	*/
	public function mot_sudoku_ajax_modal()
	{
		if ($this->request->is_ajax())
		{
			$modal_position = $this->request->variable('position', 0);

			$sql_arr = [
				'modal_position'	=> $modal_position,
			];
			$sql = 'UPDATE ' . $this->sudoku_stats_table . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
					WHERE user_id = ' . (int) $this->user->data['user_id'];
			$this->db->sql_query($sql);

			$result = [
				'success'	=> true,
			];

			return new \Symfony\Component\HttpFoundation\JsonResponse($result);
		}
	}

// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	/**
	* Get the count of all selective values in the array
	*
	* @param	$arr		The array to count in
	*
	* @return	An array with the selective values as key and their count as value (e.g. '0' => (int) 5)
	*/
	private function array_count_recursive(array $arr): array
	{
		$occurrences = [];
		array_walk_recursive($arr, function($value, $key) use (&$occurrences) {
		   // @ $occurrences[$value]++;		   // @ to surpress warnings "Undefined array key".
		   $occurrences[$value] = ($occurrences[$value] ?? 0) + 1;
		});
		return $occurrences;
	}

	/**
	* Get the count of all cells within two combined arrays of 9 * 9 integer values which are both holding a 0
	*
	* @param	$arr1, $arr2	the two arrays to combine
	*
	* @return	The number of zeros found in both arrays at the same place
	*/
	private function count_empty_cells(array $arr1, array $arr2) : int
	{
		$count = 0;
		for ($i = 0; $i < 9; $i++)
		{
			for ($j = 0; $j < 9; $j++)
			{
				$count = ($arr1[$i][$j] + $arr2[$i][$j] == 0) ? $count + 1 : $count;
			}
		}
		return $count;
	}

	/**
	* Get the count of all cells within two combined arrays 9 * 9 integer values within x arrays which are both holding a 0
	*
	* @param	$arr1, $arr2	the two arrays to combine
	*		$grids		The number of 9 * 9 arrays
	*
	* @return	The number of zeros found in both arrays at the same place
	*/
	private function count_empty_grid_cells(array $arr1, array $arr2, int $grids) : int
	{
		$count = 0;
		for ($g = 0; $g < $grids; $g++)
		{
			for ($i = 0; $i < 9; $i++)
			{
				for ($j = 0; $j < 9; $j++)
				{
					$count = ($arr1[$g][$i][$j] == 0 && $arr2[$g][$i][$j] == 0) ? $count + 1 : $count;
				}
			}
		}
		return $count;
	}

	/**
	* Check whether the values other than 0 in the array to be checked are identical to the values in the corresponding cells of the solution array
	*
	* @param	$solution_arr	the 9 * 9 array with the values of the solution
	*		$check_arr		the 9 * 9 array with the values to be checked which still has values of 0 where the pre-defined digits are
	*
	* @return	Either true = the values are identical or false = at least one value differs in which case they are deleted from the array $check_arr
	*/
	private function check_solution(array $solution_arr, array &$check_arr) : bool
	{
		$return = true;		// We assume that everything is correct and change this only if at least one value differs
		for ($i = 0; $i < 9; $i++)
		{
			for ($j = 0; $j < 9; $j++)
			{
				$return = !$check_arr[$i][$j] && $check_arr[$i][$j] != $solution_arr[$i][$j] ? false : $return;
				$check_arr[$i][$j] = !$check_arr[$i][$j] && $check_arr[$i][$j] != $solution_arr[$i][$j] ? 0 : $check_arr[$i][$j];
			}
		}

		return $return;
	}

	/**
	* Save the points gained into the MOT_SUDOKU_STATS_TABLE and the MOT_SUDOKU_FAME_TABLE
	*
	* @params	$user_id		current user
	*		$sudoku_type	Sudoku puzzle type
	*		$game_id		id of the finished game, 0 in case of abort
	*		$points		points to add
	*		$sudoku_entry	the id into the MOT_SUDOKU_GAMES_TABLE, 0 in case of deletion of a stored game
	*
	* @return	Either false = no UP points credited or float = amount of UP points credited
	*/
	private function save_game_points(int $user_id, string $sudoku_type, int $game_id, int $points, int $sudoku_entry = 0) : bool|float
	{
		$sql = 'SELECT * FROM ' . $this->sudoku_stats_table . '
				WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$stats = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($stats[$this->game_name_arr[$sudoku_type] . 'played'] == 0)
		{
			$ids = [$game_id];
		}
		else
		{
			$ids = json_decode($stats[$this->game_name_arr[$sudoku_type] . 'ids']);
			$ids[] = $game_id;
		}

		// Add the gained points
		$stats[$this->game_name_arr[$sudoku_type] . 'points'] += $points;

		// Only if a puzzle has been resolved we need to change the following, an aborted puzzle (game_id = 0) doesn't count
		if ($game_id)
		{
			// Increment the played games count
			$stats[$this->game_name_arr[$sudoku_type] . 'played']++;
			// Add the game id to the played games list
			$stats[$this->game_name_arr[$sudoku_type] . 'ids'] = json_encode($ids);
		}

		$sql = 'UPDATE ' . $this->sudoku_stats_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $stats) . '
				WHERE user_id = ' . (int) $user_id;
		$this->db->sql_query($sql);

		// Add the points gained to the fame table
		$up_points = $this->save_to_fame($user_id, $sudoku_type, $points, $game_id);

		// Since this game is finished we delete it from the SUDOKU_GAMES_TABLE
		$sql = 'DELETE FROM ' . $this->sudoku_games_table . '
				WHERE entry_id = ' . (int) $sudoku_entry;
		$this->db->sql_query($sql);

		return $up_points;
	}

	/**
	* Add points to the player's account of the current month
	*
	* @param	$user_id		current user
	*		$game_type		Sudoku puzzle type
	*		$points		points to add
	*		$game_id		if 0 we do not increment the game count
	*
	* @return	Either false = no UP points credited or float = amount of UP points credited
	*/
	private function save_to_fame(int $user_id, string $game_type, int $points, int $game_id) : bool|float
	{
		// Get local date variables and user id first
		$date_arr = getdate();
		$julian_day = gregoriantojd($date_arr['mon'], $date_arr['mday'], $date_arr['year']);

		$return = false;	// Set it to false initially, if points system is activated and UP enabled this will hold the UP points gathered

		// Check whether there already is an entry with the users data for the current day
		$sql_arr = [
			'year'			=> $date_arr['year'],
			'month'			=> $date_arr['mon'],
			'julian_day'	=> $julian_day,
			'user_id'		=> $user_id,
			'game_type'		=> $game_type,
		];
		$sql = 'SELECT * FROM ' . $this->sudoku_fame_table . '
				WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// Update or Insert this user's score
		if (!empty ($row))
		{
			$sql_arr = [
				'games_played'		=> $game_id ? ++$row['games_played'] : $row['games_played'],
				'total_points'		=> $row['total_points'] + $points,
			];
			$sql = 'UPDATE ' . $this->sudoku_fame_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
					WHERE fame_id = ' . (int) $row['fame_id'];
		}
		else
		{
			$sql_arr = [
				'year'				=> $date_arr['year'],
				'month'				=> $date_arr['mon'],
				'julian_day'		=> $julian_day,
				'user_id'			=> $user_id,
				'game_type'			=> $game_type,
				'games_played'		=> $game_id ? 1 : 0,
				'total_points'		=> $points,
			];
			$sql = 'INSERT INTO ' . $this->sudoku_fame_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		}
		$this->db->sql_query($sql);

		// Check if points system is activated and UP enabled and if yes calculate awarded points into UP points and add to the user's account
		if ($this->config['mot_sudoku_points_enable'] && $this->phpbb_extension_manager->is_enabled('dmzx/ultimatepoints'))
		{
			$this->functions_points = $this->phpbb_container->get('dmzx.ultimatepoints.core.functions.points');
			$factor_points = round($this->config['mot_sudoku_points_ratio'] * $points, 2);
			$this->functions_points->add_points($user_id, $factor_points);
			$return = $factor_points;
		}

		return $return;
	}

	/**
	* Get the array holding the info for the puzzle with the id $id and return it
	*
	* @param	$haystack	The array of arrays we need the info from
	*		$needle	The item_id of the array we are looking for
	*
	* @return	The array we are looking for or false if the id wasn't found
	*/
	private function get_subarray(array $haystack, int $needle) : array | bool
	{
		foreach ($haystack as $row)
		{
			if ($row['item_id'] == $needle)
			{
				return $row;
			}
		}

		return false;
	}

	/**
	* Get all the ids of the stored games of the chosen type
	*
	* @params	$haystack	The array of arrays we need the info from
	*		$user_id	The user's id we are looking for
	*		$type		The game type we are looking for
	*
	* @return	All game_ids meeting the criteria
	*/
	private function get_game_ids(array $haystack, int $user_id, string $type) : array
	{
		$return = [];
		foreach ($haystack as $row)
		{
			if ($row['user_id'] == $user_id && $row['game_type'] == $type)
			{
				$return[] = (int) $row['game_id'];
			}
		}

		return $return;
	}
}
