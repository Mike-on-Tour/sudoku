<?php
/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
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
	* Load permissions
	*/
	public function load_permissions($event)
	{
		$event->update_subarray('permissions', 'a_manage_mot_sudoku', ['lang' => 'ACL_A_MOT_SUDOKU_MANAGE', 'cat' => 'misc']);
		$event->update_subarray('permissions', 'u_play_mot_sudoku', ['lang' => 'ACL_U_MOT_SUDOKU_PLAY', 'cat' => 'misc']);
	}
}
