<?php
/**
*
* @package MoT Sudoku v0.2.0
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
			'core.permissions'			=> 'load_permissions'
		);
	}

	/** @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		$this->auth = $auth;
		$this->helper = $helper;
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
	* Load permissions
	*/
	public function load_permissions($event)
	{
		$event->update_subarray('permissions', 'a_manage_mot_sudoku', ['lang' => 'ACL_A_MOT_SUDOKU_MANAGE', 'cat' => 'misc']);
		$event->update_subarray('permissions', 'u_play_mot_sudoku', ['lang' => 'ACL_U_MOT_SUDOKU_PLAY', 'cat' => 'misc']);
	}
}
