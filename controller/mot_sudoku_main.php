<?php
/**
*
* @package MoT Sudoku v0.2.0
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

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper,
								\phpbb\language\language $language, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, $root_path, $mot_sudoku_classic_table)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->language = $language;
		$this->phpbb_extension_manager 	= $phpbb_extension_manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;

		$this->classic_sudoku_table = $mot_sudoku_classic_table;

		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/sudoku');
		$this->ext_data = $this->md_manager->get_metadata();
	}

	public function handle()
	{
		//If user is a bot.... redirect to the index.
		if ($this->user->data['is_bot'])
		{
			redirect(append_sid("{$this->root_path}index." . $this->php_ext));
		}

		// Check if the user ist logged in.
		if (!$this->user->data['is_registered'])
		{
			// Not logged in ? Redirect to the loginbox.
			login_box('', $this->language->lang('NO_AUTH_OPERATION'));
		}

		$this->classic_action = $this->helper->route('mot_sudoku_main', ['tab' => 'classic']);
		$this->samurai_action = $this->helper->route('mot_sudoku_main', ['tab' => 'samurai']);
		$this->ninja_action = $this->helper->route('mot_sudoku_main', ['tab' => 'ninja']);

		$tab = $this->request->variable('tab', '');
		switch ($tab)
		{
			default:
			case 'classic':
				$sql = 'SELECT * FROM ' . $this->classic_sudoku_table;
				$result = $this->db->sql_query($sql);
				$classic_puzzles = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$puzzle_number = rand(0, count($classic_puzzles) - 1);
				$classic_puzzle = $classic_puzzles[$puzzle_number];
				$puzzle = json_decode($classic_puzzle['puzzle_line']);
				$pre_cells_arr = [];
				for ($i = 0; $i < 9; $i++)
				{
					for ($j = 0; $j < 9; $j++)
					{
						if ($puzzle[$i][$j])
						{
							$this->template->assign_var('MOT_SUDOKU_CELL_' . ($i + 1) . ($j + 1), $puzzle[$i][$j]);
							$pre_cells_arr[] = 'mot_sudoku_c_cell_id_' . ($i + 1) . ($j + 1);
						}
					}
				}

				$title = ($this->config['mot_sudoku_title_enable'] && $classic_puzzle['game_name'] != '') ? '&nbsp;||&nbsp;<strong>' . $classic_puzzle['game_name'] . '</strong>' : '';
				$this->template->assign_var('MOT_SUDOKU_PRE_CELLS_ARR', json_encode($pre_cells_arr));
				$selected_tab = 'classic';
				break;

			case 'samurai':
				$selected_tab = 'samurai';
				break;

			case 'ninja':
				$selected_tab = 'ninja';
				break;
		}

		$this->template->assign_vars([
			'MOT_SUDOKU_SELECTED_TAB'	=> $selected_tab,
			'MOT_SUDOKU_CLASSIC_TAB'	=> $this->classic_action,
			'MOT_SUDOKU_SAMURAI_TAB'	=> $this->samurai_action,
			'MOT_SUDOKU_NINJA_TAB'		=> $this->ninja_action,
			'MOT_SUDOKU_ACTIVE'			=> true,
			'MOT_SUDOKU_GAME_INFO'		=> $this->language->lang('MOT_SUDOKU_GAME_INFO', $classic_puzzle['game_pack'], $classic_puzzle['game_number'], $classic_puzzle['game_level']) . $title,
			'MOT_SUDOKU_COPYRIGHT'		=> $this->ext_data['extra']['display-name'] . ' ' . $this->ext_data['version'] . ' &copy; Mike-on-Tour (<a href="' . $this->ext_data['homepage'] . '">' . $this->ext_data['homepage'] . '</a>)',
		]);

		// Add breadcrumbs link
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('MOT_SUDOKU_TITLE'),
			'U_VIEW_FORUM'	=> $this->helper->route('mot_sudoku_main'),
		]);

		return $this->helper->render('@mot_sudoku/mot_sudoku_main.html', $this->language->lang('MOT_SUDOKU_TITLE'));
	}
}
