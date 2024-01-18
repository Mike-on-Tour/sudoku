<?php
/**
*
* @package MoT Sudoku v0.3.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class mot_sudoku_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup'			=> 'load_language_on_setup',
			'core.page_header'			=> 'add_page_header_link',
			'core.page_footer'			=> 'get_visited_page',
			'core.permissions'			=> 'load_permissions'
		);
	}

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/* @var \phpbb\template\template */
	protected $template;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\language\language $language,
								\phpbb\template\template $template)
	{
		$this->auth = $auth;
		$this->db = $db;
		$this->helper = $helper;
		$this->language = $language;
		$this->template = $template;
	}

	/**
	 * Load language files
	 *
	 * @param \phpbb\event\data $event
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'mot/sudoku',
			'lang_set' => 'mot_sudoku_common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Add a page header nav bar link
	 *
	 * @param \phpbb\event\data $event The event object
	 */
	public function add_page_header_link()
	{
		$this->template->assign_vars([
			'U_MOT_SUDOKU' 			=> $this->helper->route('mot_sudoku_main'),
			'U_MOT_SUDOKU_PLAY'		=> $this->auth->acl_get('u_play_mot_sudoku'),
		]);
	}

	/**
	* Get all users playing Sudoku from the SESSIONS_TABLE
	*
	*/
	public function get_visited_page()
	{
		$sql_ary = [
			'SELECT'	=> 's.session_user_id, u.username, u.user_colour',

			'FROM'		=> [
				SESSIONS_TABLE	=> 's',
			],

			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [USERS_TABLE	=> 'u'],
					'ON'	=> 'u.user_id = s.session_user_id'
				],
			],

			'WHERE'		=> 	"s.session_page LIKE '%sudoku%'
							AND s.session_user_id <> " . ANONYMOUS,

			'ORDER_BY'	=> 's.session_user_id ASC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$sudoku_users = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$sudoku_users_count = $this->language->lang('MOT_SUDOKU_TOTAL_PLAYERS', count($sudoku_users));
		$sudoku_user_list = '';
		foreach ($sudoku_users as $row)
		{
			$sudoku_user = '<span style="color: #' . $row['user_colour'] . ';">' . $row['username'] . '</span>';
			$sudoku_user_list .= $sudoku_user_list != '' ? ', ' . $sudoku_user : $sudoku_user;
		}

		$this->template->assign_vars([
			'MOT_SUDOKU_TOTAL_USERS_ONLINE'	=> $sudoku_users_count . $sudoku_user_list,
		]);
	}

	/**
	* Load permissions
	*/
	public function load_permissions($event)
	{
		$event->update_subarray('permissions', 'a_manage_mot_sudoku', ['lang' => 'ACL_A_MOT_SUDOKU_MANAGE', 'cat' => 'misc']);
		$event->update_subarray('permissions', 'u_play_mot_sudoku', ['lang' => 'ACL_U_MOT_SUDOKU_PLAY', 'cat' => 'misc']);
	}
}
