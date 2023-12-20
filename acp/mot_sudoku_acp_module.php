<?php
/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\sudoku\acp;

class mot_sudoku_acp_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	/**
	 * Main ACP module
	 *
	 * @param	string	$id		The module identifier (\mot\sudoku\acp\mot_sudoku_acp_module)
	 *		string	$mode	The module mode (settings)
	 *
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \mot.pages.controller.acp $acp_config_controller */
		$acp_controller = $phpbb_container->get('mot.sudoku.controller.mot_sudoku_acp');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_mot_sudoku_' . $mode;

		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_MOT_SUDOKU') . ' - ' . $language->lang('ACP_MOT_SUDOKU_' . mb_strtoupper($mode));

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action)->{$mode}();
	}
}
