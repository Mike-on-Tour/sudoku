/**
*
* @package MoT Sudoku v0.1.0
* @copyright (c) 2023 Mike-on-Tour
* @license EULA
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

	/*
	* Check the 'mot_sudoku_points_enable' setting and hide or show the according settings
	*/
	$("input[name='mot_sudoku_points_enable']").click(function() {
		// Check radio buttons
		if ($(this).attr('type') == 'radio') {
			if ($(this).val() == 1) {
				$("#mot_sudoku_show_point_ratio").show();
				$("#mot_sudoku_show_reward_enable").show();
			} else {
				$("#mot_sudoku_show_point_ratio").hide();
				$("#mot_sudoku_show_reward_enable").hide();
			}
		}
		// Check checkbox
		if ($(this).attr('type') == 'checkbox') {
			if ($(this).is(":checked")) {
				$("#mot_sudoku_show_point_ratio").show();
				$("#mot_sudoku_show_reward_enable").show();
			} else {
				$("#mot_sudoku_show_point_ratio").hide();
				$("#mot_sudoku_show_reward_enable").hide();
			}
		}
	});

	// Show this div at the start if it is checked
	if ($("input[name='mot_sudoku_points_enable']:checked").val() == 1) {
		$("#mot_sudoku_show_point_ratio").show();
		$("#mot_sudoku_show_reward_enable").show();
	}

	/*
	* Check the 'mot_sudoku_reward_enable' setting and hide or show the according settings
	*/
	$("input[name='mot_sudoku_reward_enable']").click(function() {
		// Check radio buttons
		if ($(this).attr('type') == 'radio') {
			if ($(this).val() == 1) {
				$("#mot_sudoku_show_reward_settings").show();
			} else {
				$("#mot_sudoku_show_reward_settings").hide();
			}
		}
		// Check checkbox
		if ($(this).attr('type') == 'checkbox') {
			if ($(this).is(":checked")) {
				$("#mot_sudoku_show_reward_settings").show();
			} else {
				$("#mot_sudoku_show_reward_settings").hide();
			}
		}
	});

	// Show this div at the start if it is checked
	if ($("input[name='mot_sudoku_reward_enable']:checked").val() == 1) {
		$("#mot_sudoku_show_reward_settings").show();
	}

})(jQuery); // Avoid conflicts with other libraries
