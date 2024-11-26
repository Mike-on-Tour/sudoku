<?php
/**
*
* @package MoT Sudoku v0.11.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\includes;

class mot_sudoku_functions
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language $language */
	protected $language;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $php_ext;

	/** @var string mot.sudoku.tables.mot_sudoku_fame */
	protected $mot_sudoku_fame_table;

	/** @var string mot.sudoku.tables.mot_sudoku_fame_month */
	protected $mot_sudoku_fame_month_table;

	/** @var string mot.sudoku.tables.mot_sudoku_fame_year */
	protected $mot_sudoku_fame_year_table;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language, $root_path, $php_ext,
								$mot_sudoku_fame_table, $mot_sudoku_fame_month_table, $mot_sudoku_fame_year_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->sudoku_fame_table = $mot_sudoku_fame_table;
		$this->sudoku_fame_month_table = $mot_sudoku_fame_month_table;
		$this->sudoku_fame_year_table = $mot_sudoku_fame_year_table;

		$this->type_arr = ['c', 's', 'n'];
	}

	/*
	* Function to fill the monthly and yearly fame tables from the fame table
	*
	*/
	public function check_month_year()
	{
		// Get the current date
		$date_arr = getdate();
		$current_month = $this->config['mot_sudoku_current_month'];

		// Check if we have a new month
		if (($date_arr['year'] * 100 + $date_arr['mon']) > $current_month)
		{
			// Save the new current month to the CONFIG_TABLE (we do this as soon as possible to prevent a second call)
			$this->config->set('mot_sudoku_current_month', ($date_arr['year'] * 100 + $date_arr['mon']));

			// Get year and month of last month
			$year = intdiv($current_month, 100);
			$month = ($current_month % 100);

			foreach ($this->type_arr as $type)
			{
				// It is a new month so we can get the best player of the previous month and store the data into the FAME_MONTH_TABLE
				$sql = 'SELECT user_id, SUM(games_played) AS games_played, SUM(total_points) AS total_points FROM ' . $this->sudoku_fame_table . '
						WHERE year = ' . (int) $year . '
						AND month = ' . (int) $month . '
						AND game_type = "' . (string) $type . '"
						GROUP BY user_id
						ORDER BY total_points DESC
						LIMIT 1';
				$result = $this->db->sql_query($sql);
				$player = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				if ($player)
				{
					$player['year'] = $year;
					$player['month'] = $month;
					$player['game_type'] = $type;

					// Save this into the FAME_MONTH_TABLE
					$sql = 'INSERT INTO ' . $this->sudoku_fame_month_table . ' ' . $this->db->sql_build_array('INSERT', $player);
					$this->db->sql_query($sql);
				}
			}
		}

		// Check if we have a new year
		$current_year = $this->config['mot_sudoku_current_year'];
		if ($date_arr['year'] > $current_year)
		{
			foreach ($this->type_arr as $type)
			{
				// Save the new current year to the CONFIG_TABLE (we do this as soon as possible to prevent a second call)
				$this->config->set('mot_sudoku_current_year', $date_arr['year']);

				// Get best players of last year
				$sql = 'SELECT user_id, SUM(games_played) AS games_played, SUM(total_points) AS total_points FROM ' . $this->sudoku_fame_table . '
						WHERE year = ' . (int) $current_year . '
						AND game_type = "' . (string) $type . '"';
				$result = $this->db->sql_query($sql);
				$player = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// If there are results for last year get them and calculate the best player
				if ($player)
				{
					$player['year'] = $year;
					$player['game_type'] = $type;

					// Save this into the FAME_MONTH_TABLE
					$sql = 'INSERT INTO ' . $this->sudoku_fame_year_table . ' ' . $this->db->sql_build_array('INSERT', $player);
					$this->db->sql_query($sql);
				}
			}
		}
	}

	/*
	* Check if a new rewards period has started and look who ist to get what reward
	*
	*/
	public function check_rewards()
	{
		$this->admin_arr = [];
		$this->types_lang_arr = [
			'c'		=> $this->language->lang('MOT_SUDOKU_TAB_CLASSIC'),
			's'		=> $this->language->lang('MOT_SUDOKU_TAB_SAMURAI'),
			'n'		=> $this->language->lang('MOT_SUDOKU_TAB_NINJA'),
		];

		// Get the current date
		$date_arr = getdate();

		// Check if we have a new month
		if (($date_arr['year'] * 100 + $date_arr['mon']) > $this->config['mot_sudoku_current_month'])
		{
			// If we do have a new month that means that the listener hasn't run yet, so we must first do the respective actions otherwise the ranking and the hall of fame would not show this
			$this->check_month_year();
		}

		// Get the type of periodic bonus calculation for building the PM to the admin
		$this->admin_arr['period'] = $this->config['mot_sudoku_reward_time'];

		// Get admin data for PM if PMs are enabled
		if ($this->config['mot_sudoku_pm_enable'])
		{
			$sql_arr = [
				'SELECT'	=> 'u.user_id, u.username, s.session_ip',
				'FROM'		=> [
						USERS_TABLE	=> 'u',
				],
				'LEFT_JOIN'	=> [
					[
							'FROM'	=> [SESSIONS_TABLE	=> 's'],
							'ON'	=> 's.session_user_id = u.user_id',
					],
				],
				'WHERE'		=> 'user_id = ' . (int) $this->config['mot_sudoku_admin_id'],
			];
			$sql = $this->db->sql_build_query('SELECT', $sql_arr);
			$result = $this->db->sql_query($sql);
			$admin = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
		}

		switch ($this->config['mot_sudoku_reward_time'])
		{
			// Daily calculation
			case 0:
				// First check whether we need to do this calculation
				if (($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday'] > $this->config['mot_sudoku_last_reward'])
				{
					$yesterday = gregoriantojd($date_arr['mon'], $date_arr['mday'], $date_arr['year']) - 1;
					foreach ($this->type_arr as $type)
					{
						$sql_arr = [
							'SELECT'	=> 'f.user_id, f.games_played, f.total_points, u.username',
							'FROM'		=> [
									$this->sudoku_fame_table	=> 'f',
							],
							'LEFT_JOIN'	=> [
								[
										'FROM'	=> [USERS_TABLE	=> 'u'],
										'ON'	=> 'u.user_id = f.user_id',
								],
							],
							'WHERE'		=> 'julian_day = ' . (int) $yesterday . ' AND game_type = "' . (string) $type . '"',
						];
						$sql = $this->db->sql_build_query('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$players = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						if (!empty($players))
						{
							$this->admin_arr[$type] = [];
							$this->get_points($players, $type, $this->config['mot_sudoku_reward_time'], $admin);
						}
					}
				}

				// Save the date of the last run into the CONFIG_TABLE
				$this->config->set('mot_sudoku_last_reward', ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday']);
				break;

			// Weekly calculation
			case 1:
				// First check whether we need to do this calculation
				if ((($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday'] > $this->config['mot_sudoku_last_reward']) && $date_arr['wday'] == $this->config['mot_sudoku_week_start'])
				{
					$today = gregoriantojd($date_arr['mon'], $date_arr['mday'], $date_arr['year']);
					$jd_arr = [];
					// Build the array with julian days we need to calculate
					for ($i = 1; $i <= 7; $i++)
					{
						$jd_arr[] = $today - $i;
					}

					foreach ($this->type_arr as $type)
					{
						$sql_arr = [
							'SELECT'	=> 'f.user_id, SUM(f.games_played) AS games_played, SUM(f.total_points) AS total_points, u.username',
							'FROM'		=> [
									$this->sudoku_fame_table	=> 'f',
							],
							'LEFT_JOIN'	=> [
								[
										'FROM'	=> [USERS_TABLE	=> 'u'],
										'ON'	=> 'u.user_id = f.user_id',
								],
							],
							'WHERE'		=> 'game_type = "' . (string) $type . '" AND ' . $this->db->sql_in_set('julian_day', $jd_arr),
							'GROUP_BY'	=> 'f.user_id',
						];
						$sql = $this->db->sql_build_query('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$players = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						if (!empty($players))
						{
							$this->admin_arr[$type] = [];
							$this->get_points($players, $type, $this->config['mot_sudoku_reward_time'], $admin);
						}
					}
				}

				// Save the date of the last run into the CONFIG_TABLE
				$this->config->set('mot_sudoku_last_reward', ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday']);
				break;

			// Monthly calculation
			case 2:
				$last_calc = intdiv($this->config['mot_sudoku_last_reward'], 100);	// Time of last calculation as yyyymm

				// First check whether we need to do this calculation
				if (($date_arr['year'] * 100 + $date_arr['mon']) > $last_calc)
				{
					// Get year and month for the query
					$year = intdiv($last_calc, 100);
					$month = ($last_calc % 100);

					foreach ($this->type_arr as $type)
					{
						$sql_arr = [
							'SELECT'	=> 'f.user_id, SUM(f.games_played) AS games_played, SUM(f.total_points) AS total_points, u.username',
							'FROM'		=> [
									$this->sudoku_fame_table	=> 'f',
							],
							'LEFT_JOIN'	=> [
								[
										'FROM'	=> [USERS_TABLE	=> 'u'],
										'ON'	=> 'u.user_id = f.user_id',
								],
							],
							'WHERE'		=> 'year = ' . (int) $year . ' AND month = ' . (int) $month . ' AND game_type = "' . (string) $type . '"',
							'GROUP_BY'	=> 'f.user_id',
						];
						$sql = $this->db->sql_build_query('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$players = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						if (!empty($players))
						{
							$this->admin_arr[$type] = [];
							$this->get_points($players, $type, $this->config['mot_sudoku_reward_time'], $admin);
						}
					}
				}

				// Save the date of the last run into the CONFIG_TABLE
				$this->config->set('mot_sudoku_last_reward', ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday']);
				break;

			// Yearly calculation
			case 3:
				// First check whether we need to do this calculation
				if ($date_arr['year'] > intdiv($this->config['mot_sudoku_last_reward'], 10000))	// Time of last calculation as yyyy
				{
					foreach ($this->type_arr as $type)
					{
						$sql_arr = [
							'SELECT'	=> 'f.user_id, SUM(f.games_played) AS games_played, SUM(f.total_points) AS total_points, u.username',
							'FROM'		=> [
									$this->sudoku_fame_table	=> 'f',
							],
							'LEFT_JOIN'	=> [
								[
										'FROM'	=> [USERS_TABLE	=> 'u'],
										'ON'	=> 'u.user_id = f.user_id',
								],
							],
							'WHERE'		=> 'year = ' . (int) $date_arr['year'] . ' AND game_type = "' . (string) $type . '"',
							'GROUP_BY'	=> 'f.user_id',
						];
						$sql = $this->db->sql_build_query('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$players = $this->db->sql_fetchrowset($result);
						$this->db->sql_freeresult($result);

						if (!empty($players))
						{
							$this->admin_arr[$type] = [];
							$this->get_points($players, $type, $this->config['mot_sudoku_reward_time'], $admin);
						}
					}
				}

				// Save the date of the last run into the CONFIG_TABLE
				$this->config->set('mot_sudoku_last_reward', ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday']);
				break;
		}
		if ($this->config['mot_sudoku_pm_enable'] && count($this->admin_arr) > 1)
		{
			$subject = $this->language->lang('MOT_SUDOKU_ADMIN_SUBJECT_' . $this->admin_arr['period']);
			$msg = '';
			foreach ($this->type_arr as $type)
			{
				if (array_key_exists($type, $this->admin_arr))
				{
					$msg .= $this->language->lang('MOT_SUDOKU_ADMIN_MESSAGE',
						$this->types_lang_arr[$type],
						$this->admin_arr[$type]['total_points']['username'], $this->admin_arr[$type]['total_points']['total_points'], $this->admin_arr[$type]['total_points']['up_points'],
						$this->admin_arr[$type]['games_played']['username'], $this->admin_arr[$type]['games_played']['games_played'], $this->admin_arr[$type]['games_played']['up_points'],
						$this->admin_arr[$type]['high_average']['username'], $this->admin_arr[$type]['high_average']['avg_points'], $this->admin_arr[$type]['high_average']['up_points']
						);
				}
			}
			$this->send_pm($admin, $subject, $msg, $admin);
		}
	}

/*
* Private functions ---------------------------------------------------------------------------------------------------------
*/

	/*
	* Calculate the UP points for every Sudoku type for highest total points, most solved puzzle and highest average points earned
	*
	* @params	array		$players	an array holding all players who have earned points during this period
	*		string		$type		the Sudoku type we handle here e.g. 'c' for classic
	*		integer	$period	the period we calculate, e.g. monthly = 2
	*		array		$admin	an array holding the information about the admin we need for the PM
	*/
	private function get_points($players, $type, $period, $admin)
	{
		global $phpbb_container;

		// Get a handle for the function from UP
		$this->functions_points = $phpbb_container->get('dmzx.ultimatepoints.core.functions.points');

		// Initialize the types arrays
		$types_arr = [
			'c'		=> 'classic',
			's'		=> 'samurai',
			'n'		=> 'ninja',
		];

		/*
		* Sort for most points
		*/
		usort($players, function ($item1, $item2) {
			return $item2['total_points'] <=> $item1['total_points'];	// Sort DESC
		});

		// The winner is in the first array
		$winner = $players[0];

		// Calculate the UP points and hand them over
		$winner['up_points'] = round($this->config['mot_sudoku_points_ratio'] * $this->config['mot_sudoku_' . $types_arr[$type] . '_price'], 2);
		$this->admin_arr[$type]['total_points'] = $winner;
		$this->functions_points->add_points($winner['user_id'], $winner['up_points']);

		// If PMs are enabled, create and send the PM to the winner
		if ($this->config['mot_sudoku_pm_enable'])
		{
			$this->send_pm($winner,
							$this->language->lang('MOT_SUDOKU_WINNER_SUBJECT', $this->types_lang_arr[$type]),
							$this->language->lang('MOT_SUDOKU_WINNER_MESSAGE_' . $period, $winner['username'], $this->types_lang_arr[$type], $winner['total_points'], $winner['up_points'], $admin['username']),
							$admin
			);
		}

		/*
		* Sort for most games
		*/
		usort($players, function ($item1, $item2) {
				return $item2['games_played'] <=> $item1['games_played'];	// Sort DESC
		});
		$winner = $players[0];
		$winner['up_points'] = round($this->config['mot_sudoku_points_ratio'] * $this->config['mot_sudoku_most_games'], 2);
		$this->admin_arr[$type]['games_played'] = $winner;
		$this->functions_points->add_points($winner['user_id'], $winner['up_points']);

		// If PMs are enabled, create and send the PM to the winner
		if ($this->config['mot_sudoku_pm_enable'])
		{
			$this->send_pm($winner,
							$this->language->lang('MOT_SUDOKU_GAMES_SUBJECT', $this->types_lang_arr[$type]),
							$this->language->lang('MOT_SUDOKU_GAMES_MESSAGE_' . $period, $winner['username'], $this->types_lang_arr[$type], $winner['games_played'], $winner['up_points'], $admin['username']),
							$admin
			);
		}

		/*
		* Sort for most average points
		*/
		usort($players, function ($item1, $item2) {
			return $item2['total_points'] / $item2['games_played'] <=> $item1['total_points'] / $item1['games_played'];	// Sort DESC
		});
		$winner = $players[0];
		$winner['avg_points'] = (int) ($winner['total_points'] / $winner['games_played']);
		$winner['up_points'] = round($this->config['mot_sudoku_points_ratio'] * $this->config['mot_sudoku_high_average'], 2);
		$this->admin_arr[$type]['high_average'] = $winner;
		$this->functions_points->add_points($winner['user_id'], $winner['up_points']);

		// If PMs are enabled, create and send the PM to the winner
		if ($this->config['mot_sudoku_pm_enable'])
		{
			$this->send_pm($winner,
							$this->language->lang('MOT_SUDOKU_AVERAGE_SUBJECT', $this->types_lang_arr[$type]),
							$this->language->lang('MOT_SUDOKU_AVERAGE_MESSAGE_' . $period, $winner['username'], $this->types_lang_arr[$type], $winner['avg_points'], $winner['up_points'], $admin['username']),
							$admin
			);
		}
	}

	/*
	* Function to send a PM
	*
	* @params	array		$recipient		the array holding the information about the recipient
	*		string		$subject		string holding the PM subject
	*		string		$message		string holding the PM message
	*		array		$sender		the array holding the information about the sender
	*/
	private function send_pm($recipient, $subject, $message, $sender)
	{
		if (!function_exists('submit_pm'))
		{
			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
		}

		if (!function_exists('generate_text_for_storage'))
		{
			include($this->root_path . 'includes/functions_content.' . $this->php_ext);
		}

		$uid = $bitfield = $options = '';
		generate_text_for_storage($subject, $uid, $bitfield, $options, false, false, false);
		generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);

		$pm_data = [
			'address_list'		=> ['u' => [$recipient['user_id'] => 'to']],
			'from_user_id'		=> $sender['user_id'],
			'from_username'		=> $sender['username'],
			'icon_id'			=> 0,
			'from_user_ip'		=> $sender['session_ip'],

			'enable_bbcode'		=> true,
			'enable_smilies'	=> true,
			'enable_urls'		=> true,
			'enable_sig'		=> true,

			'message'			=> $message,
			'bbcode_bitfield'	=> $bitfield,
			'bbcode_uid'		=> $uid,
		];
		submit_pm('post', $subject, $pm_data, false);
		return;
	}
}
