<?php
/**
*
* @package MoT Sudoku v0.8.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\controller;

class mot_sudoku_main
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\language\language $language */
	protected $language;

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

	/** @var string mot.sudoku.tables.mot_sudoku_fame */
	protected $mot_sudoku_fame_table;

	/** @var string mot.sudoku.tables.mot_sudoku_fame_month */
	protected $mot_sudoku_fame_month_table;

	/** @var string mot.sudoku.tables.mot_sudoku_fame_year */
	protected $mot_sudoku_fame_year_table;

	/** @var string mot.sudoku.tables.mot_sudoku_games */
	protected $mot_sudoku_games_table;

	/** @var string mot.sudoku.tables.mot_sudoku_ninja */
	protected $mot_sudoku_ninja_table;

	/** @var string mot.sudoku.tables.mot_sudoku_samurai */
	protected $mot_sudoku_samurai_table;

	/** @var string mot.sudoku.tables.mot_sudoku_stats */
	protected $mot_sudoku_stats_table;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper,
								\phpbb\language\language $language, \phpbb\pagination $pagination, \phpbb\extension\manager $phpbb_extension_manager,
								\phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $mot_sudoku_classic_table,
								$mot_sudoku_fame_table, $mot_sudoku_fame_month_table, $mot_sudoku_fame_year_table, $mot_sudoku_games_table, $mot_sudoku_ninja_table,
								$mot_sudoku_samurai_table, $mot_sudoku_stats_table)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->language = $language;
		$this->pagination = $pagination;
		$this->phpbb_extension_manager 	= $phpbb_extension_manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;

		$this->classic_sudoku_table = $mot_sudoku_classic_table;
		$this->sudoku_fame_table = $mot_sudoku_fame_table;
		$this->sudoku_fame_month_table = $mot_sudoku_fame_month_table;
		$this->sudoku_fame_year_table = $mot_sudoku_fame_year_table;
		$this->sudoku_games_table = $mot_sudoku_games_table;
		$this->ninja_sudoku_table = $mot_sudoku_ninja_table;
		$this->samurai_sudoku_table = $mot_sudoku_samurai_table;
		$this->sudoku_stats_table = $mot_sudoku_stats_table;

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

			$this->classic_action = $this->helper->route('mot_sudoku_main', ['tab' => 'classic']);
			$this->samurai_action = $this->helper->route('mot_sudoku_main', ['tab' => 'samurai']);
			$this->ninja_action = $this->helper->route('mot_sudoku_main', ['tab' => 'ninja']);
			$this->rank_action = $this->helper->route('mot_sudoku_main', ['tab' => 'rank']);
			$this->fame_action = $this->helper->route('mot_sudoku_main', ['tab' => 'fame']);

			$this->difficulty = ['', $this->language->lang('MOT_SUDOKU_EASY'), $this->language->lang('MOT_SUDOKU_MEDIUM'), $this->language->lang('MOT_SUDOKU_HARD')];

			$type_array = [
				'classic'	=> $this->language->lang('MOT_SUDOKU_TAB_CLASSIC'),
				'samurai'	=> $this->language->lang('MOT_SUDOKU_TAB_SAMURAI'),
				'ninja'		=> $this->language->lang('MOT_SUDOKU_TAB_NINJA'),
			];

			$short_type_array = [
				'classic'	=> 'c',
				'samurai'	=> 's',
				'ninja'		=> 'n',
			];

			$tab = $this->request->variable('tab', 'classic');
			$tab = (($tab == 'rank' && !$this->config['mot_sudoku_enable_rank']) || ($tab == 'fame' && !$this->config['mot_sudoku_enable_fame'])) ? 'classic' : $tab;

			// First check whether this user is already in the SUDOKU_STATS_TABLE
			$sql = 'SELECT * FROM ' . $this->sudoku_stats_table . '
					WHERE user_id = ' . (int) $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			$user_stats = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!$user_stats)
			{
				// No entry for this user, we have to store a new entry
				$sql_arr = [
					'user_id'		=> $this->user->data['user_id'],
					'classic_ids'	=> '',
					'samurai_ids'	=> '',
					'ninja_ids'		=> '',
				];
				$sql = 'INSERT INTO ' . $this->sudoku_stats_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
				$this->db->sql_query($sql);
			}

			switch ($tab)
			{
				case 'classic':
					if ($user_stats)
					{
						$modal_position = $user_stats['modal_position'];
						$games_solved = $user_stats['classic_played'];
						$total_points = $user_stats['classic_points'];
						$classic_ids = json_decode($user_stats['classic_ids']);
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
						$samurai_ids = json_decode($user_stats['samurai_ids']);
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
						$ninja_ids = json_decode($user_stats['ninja_ids']);
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

					$selected_type = $this->request->is_set('mot_sudoku_select_type') ? $this->request->variable('mot_sudoku_select_type', '') : 'classic';

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
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' ORDER BY s.' . $selected_type . '_points DESC';
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

					// Create type selection
					$type_selection = '';
					$selected_name = '';
					foreach ($type_array as $key => $value)
					{
						$selected = '';
						if ($selected_type == $key)
						{
							$selected =  ' selected';
							$selected_name = $value;
						}
						$type_selection .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
					}

					$this->template->assign_vars([
						'MOT_SUDOKU_TYPE_SELECTION'		=> $type_selection,
						'MOT_SUDOKU_SELECTED_TYPE'		=> $selected_name,
					]);
					break;

				case 'fame':
					// Get local date variables first
					$date_arr = getdate();
					$number_of_rows = $this->config['mot_sudoku_fame_limit'];
					$months_arr = ['', 'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];

					$selected_type = $this->request->is_set('mot_sudoku_select_type') ? $this->request->variable('mot_sudoku_select_type', '') : 'classic';

					// Get best players of current month
					$sql_arr = [
						'SELECT'	=> 'f.*, u.username, u.user_colour',
						'FROM'		=> [$this->sudoku_fame_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'f.year = ' . (int) $date_arr['year'] . '
										AND f.month = ' . (int) $date_arr['mon'] . "
										AND game_type = '" . (string) $short_type_array[$selected_type] . "'",
						'ORDER_BY'	=> 'f.total_points DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$players = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$i = 0;
					foreach ($players as $row)
					{
						$this->template->assign_block_vars('current_months', [
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'TOTAL_GAMES'	=> $row['games_played'],
							'TOTAL_POINTS'	=> $row['total_points'],
							'MEAN_POINTS'	=> number_format($row['total_points'] / $row['games_played'], 0, ',', '')
						]);
						$i++;
						if ($i == $number_of_rows)
						{
							break;
						}
					}

					// Get best players of current year
					$sql_arr = [
						'SELECT'	=> 'f.*, u.username, u.user_colour',
						'FROM'		=> [$this->sudoku_fame_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'f.year = ' . (int) $date_arr['year'] . "
						AND game_type = '" . (string) $short_type_array[$selected_type] . "'",
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$players = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$year_arr = [];
					foreach ($players as $row)
					{
						if (array_key_exists($row['user_id'], $year_arr))
						{
							$year_arr[$row['user_id']]['points'] += $row['total_points'];
							$year_arr[$row['user_id']]['games'] += $row['games_played'];
						}
						else
						{
							$year_arr[$row['user_id']] = [
								'username'		=> $row['username'],
								'user_colour'	=> $row['user_colour'],
								'games'			=> $row['games_played'],
								'points'		=> $row['total_points'],
							];
						}
					}
					usort($year_arr,
						function ($item1, $item2)
						{
							return $item2['points'] <=> $item1['points'];
						}
					);

					$i = 0;
					foreach ($year_arr as $row)
					{
						$this->template->assign_block_vars('current_years', [
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'TOTAL_GAMES'	=> $row['games'],
							'TOTAL_POINTS'	=> $row['points'],
							'MEAN_POINTS'	=> number_format($row['points'] / $row['games'], 0, ',', '')
						]);
						$i++;
						if ($i == $number_of_rows)
						{
							break;
						}
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
						'WHERE'		=> "game_type = '" . (string) $short_type_array[$selected_type] . "'",
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
						'WHERE'		=> "game_type = '" . (string) $short_type_array[$selected_type] . "'",
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

					// Create type selection
					$type_selection = '';
					$selected_name = '';
					foreach ($type_array as $key => $value)
					{
						$selected = '';
						if ($selected_type == $key)
						{
							$selected =  ' selected';
							$selected_name = $value;
						}
						$type_selection .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
					}

					$this->template->assign_vars([
						'MOT_SUDOKU_TYPE_SELECTION'		=> $type_selection,
						'MOT_SUDOKU_SELECTED_TYPE'		=> $selected_name,
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
				'MOT_SUDOKU_CLASSIC_TAB'		=> $this->classic_action,
				'MOT_SUDOKU_SAMURAI_TAB'		=> $this->samurai_action,
				'MOT_SUDOKU_NINJA_TAB'			=> $this->ninja_action,
				'MOT_SUDOKU_RANK_TAB'			=> $this->rank_action,
				'MOT_SUDOKU_FAME_TAB'			=> $this->fame_action,
				'MOT_SUDOKU_ENABLE_RANK'		=> $this->config['mot_sudoku_enable_rank'],
				'MOT_SUDOKU_ENABLE_FAME'		=> $this->config['mot_sudoku_enable_fame'],
				'MOT_SUDOKU_ACTIVE'				=> true,								// signal the footer copyright notice that Sudoku is running
				'MOT_SUDOKU_AJAX_NUMBER'		=> $this->helper->route('mot_sudoku_ajax_number'),
				'MOT_SUDOKU_AJAX_RESET'			=> $this->helper->route('mot_sudoku_ajax_reset'),
				'MOT_SUDOKU_AJAX_BUY'			=> $this->helper->route('mot_sudoku_ajax_buy'),
				'MOT_SUDOKU_AJAX_HELPER'		=> $this->helper->route('mot_sudoku_ajax_helper'),
				'MOT_SUDOKU_AJAX_MODAL'			=> $this->helper->route('mot_sudoku_ajax_modal'),
				'MOT_SUDOKU_AJAX_LEVEL'			=> $this->helper->route('mot_sudoku_ajax_level'),
				'MOT_SUDOKU_COPYRIGHT'			=> $this->ext_data['extra']['display-name'] . ' ' . $this->ext_data['version'] . ' &copy; Mike-on-Tour (<a href="' . $this->ext_data['homepage'] . '">' . $this->ext_data['homepage'] . '</a>)',
				'MOT_SUDOKU_GAME_RESET_TITLE'	=> $this->language->lang('MOT_SUDOKU_GAME_RESET_TITLE', $this->config['mot_sudoku_reset_cost']),
				'MOT_SUDOKU_BUY_NUMBER_TITLE'	=> $this->language->lang('MOT_SUDOKU_BUY_NUMBER_TITLE', $this->config['mot_sudoku_number_cost']),
				'MOT_SUDOKU_HELPER_ENABLED'		=> $this->config['mot_sudoku_helper_enable'],
				'MOT_SUDOKU_S_HELPER_ENABLED'	=> $this->config['mot_sudoku_helper_samurai_enable'],
				'MOT_SUDOKU_N_HELPER_ENABLED'	=> $this->config['mot_sudoku_helper_ninja_enable'],
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

			// Get the existing data from the database if we have a valid entry_id
			if ($sudoku_entry)
			{
				$sql = 'SELECT * FROM ' . $this->sudoku_games_table . '
						WHERE entry_id = ' . (int) $sudoku_entry;
				$result = $this->db->sql_query($sql);
				$sql_arr = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// Now we check whether the user to whom this id belongs is logged in
				if ($sql_arr['user_id'] != $this->user->data['user_id'])
				{
					// Now we can send back the needed data
					$result = [
						'logged_in'		=> false,
					];

					return new \Symfony\Component\HttpFoundation\JsonResponse($result);
				}
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
							'user_id'			=> $this->user->data['user_id'],
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
							'user_id'			=> $this->user->data['user_id'],
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
							'user_id'			=> $this->user->data['user_id'],
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

							// Now we can store this solved game into the SUDOKU_STATS_TABLE
							$sql = 'SELECT * FROM ' . $this->sudoku_stats_table . '
									WHERE user_id = ' . (int) $sql_arr['user_id'];
							$result = $this->db->sql_query($sql);
							$stats = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);

							if ($stats['classic_played'] == 0)
							{
								$classic_ids = [(int) $sql_arr['game_id']];
							}
							else
							{
								$classic_ids = json_decode($stats['classic_ids']);
								$classic_ids[] = (int) $sql_arr['game_id'];
							}

							// Add the gained points
							$stats['classic_points'] += $sql_arr['points'];
							// Increment the played games count
							$stats['classic_played']++;
							// Add the game id to the played games list
							$stats['classic_ids'] = json_encode($classic_ids);

							$sql = 'UPDATE ' . $this->sudoku_stats_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $stats) . '
									WHERE user_id = ' . (int) $sql_arr['user_id'];
							$this->db->sql_query($sql);

							// Add the points gained to the fame table
							$this->save_to_fame($sql_arr['user_id'], $sudoku_type, $sql_arr['points']);

							// Since this game is finished we delete it from the SUDOKU_GAMES_TABLE
							$sql = 'DELETE FROM ' . $this->sudoku_games_table . '
									WHERE entry_id = ' . (int) $sudoku_entry;
							$this->db->sql_query($sql);
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

							// Now we can store this solved game to the SUDOKU_STATS_TABLE
							$sql = 'SELECT * FROM ' . $this->sudoku_stats_table . '
									WHERE user_id = ' . (int) $sql_arr['user_id'];
							$result = $this->db->sql_query($sql);
							$stats = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);

							if ($stats['samurai_played'] == 0)
							{
								$samurai_ids = [(int) $sql_arr['game_id']];
							}
							else
							{
								$samurai_ids = json_decode($stats['samurai_ids']);
								$samurai_ids[] = (int) $sql_arr['game_id'];
							}

							// Add the gained points
							$stats['samurai_points'] += $sql_arr['points'];
							// Increment the played games count
							$stats['samurai_played']++;
							// Add the game id to the played games list
							$stats['samurai_ids'] = json_encode($samurai_ids);

							$sql = 'UPDATE ' . $this->sudoku_stats_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $stats) . '
									WHERE user_id = ' . (int) $sql_arr['user_id'];
							$this->db->sql_query($sql);

							// Add the points gained to the fame table
							$this->save_to_fame($sql_arr['user_id'], $sudoku_type, $sql_arr['points']);

							// Since this game is finished we delete it from the SUDOKU_GAMES_TABLE
							$sql = 'DELETE FROM ' . $this->sudoku_games_table . '
									WHERE entry_id = ' . (int) $sudoku_entry;
							$this->db->sql_query($sql);
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

							// Now we can store this solved game to the SUDOKU_STATS_TABLE
							$sql = 'SELECT * FROM ' . $this->sudoku_stats_table . '
									WHERE user_id = ' . (int) $sql_arr['user_id'];
							$result = $this->db->sql_query($sql);
							$stats = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);

							if ($stats['ninja_played'] == 0)
							{
								$ninja_ids = [(int) $sql_arr['game_id']];
							}
							else
							{
								$ninja_ids = json_decode($stats['ninja_ids']);
								$ninja_ids[] = (int) $sql_arr['game_id'];
							}

							// Add the gained points
							$stats['ninja_points'] += $sql_arr['points'];
							// Increment the played games count
							$stats['ninja_played']++;
							// Add the game id to the played games list
							$stats['ninja_ids'] = json_encode($ninja_ids);

							$sql = 'UPDATE ' . $this->sudoku_stats_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $stats) . '
									WHERE user_id = ' . (int) $sql_arr['user_id'];
							$this->db->sql_query($sql);

							// Add the points gained to the fame table
							$this->save_to_fame($sql_arr['user_id'], $sudoku_type, $sql_arr['points']);

							// Since this game is finished we delete it from the SUDOKU_GAMES_TABLE
							$sql = 'DELETE FROM ' . $this->sudoku_games_table . '
									WHERE entry_id = ' . (int) $sudoku_entry;
							$this->db->sql_query($sql);
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
	* @param	array		$arr		The array to count in
	*
	* @return	array				An array with the selective values as key and their count as value (e.g. '0' => (int) 5)
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
	* @param	array		$arr1, $arr2	the two arrays to combine
	*
	* @return	integer				the number of zeros found in both arrays at the same place
	*/
	private function count_empty_cells($arr1, $arr2): int
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
	* @param	array		$arr1, $arr2	the two arrays to combine
	*		int		$grids		The number of 9 * 9 arrays
	*
	* @return	integer				the number of zeros found in both arrays at the same place
	*/
	private function count_empty_grid_cells($arr1, $arr2, $grids): int
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
	* @param	array		$solution_arr	the 9 * 9 array with the values of the solution
	*		array		$check_arr		the 9 * 9 array with the values to be checked which still has values of 0 where the pre-defined digits are
	*
	* @return	boolean				either true = the values are identical or false = at least one value differs in which case they are deleted from the array $check_arr
	*/
	private function check_solution($solution_arr, &$check_arr)
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
	* Add points to the players account of the current month
	*
	* @param	integer	$user_id		current user
	*		string		$game_type		Sudoku puzzle type
	*		integer 	$points		points to add
	*
	*/
	private function save_to_fame($user_id, $game_type, $points)
	{
		// Get local date variables and user id first
		$date_arr = getdate();

		// Check whether there already is an entry with the users data for the current month
		$sql_arr = [
			'year'		=> $date_arr['year'],
			'month'		=> $date_arr['mon'],
			'user_id'	=> $user_id,
			'game_type'	=> $game_type,
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
				'games_played'		=> ++$row['games_played'],
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
				'user_id'			=> $user_id,
				'game_type'			=> $game_type,
				'games_played'		=> 1,
				'total_points'		=> $points,
			];
			$sql = 'INSERT INTO ' . $this->sudoku_fame_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		}
		$this->db->sql_query($sql);
	}
}
