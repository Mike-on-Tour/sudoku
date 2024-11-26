/**
*
* @package MoT Sudoku v0.11.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license EULA
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Check the 'Enable hall of fame' setting and hide or show the 'Number of players' setting accordingly
*/
$("input[name='mot_sudoku_enable_fame']").click(function() {
	// Check radio buttons
	if ($(this).attr('type') == 'radio') {
		if ($(this).val() == 1) {
			$("#mot_sudoku_fame_limit_field").show();
		} else {
			$("#mot_sudoku_fame_limit_field").hide();
		}
	}
	// Check checkbox
	if ($(this).attr('type') == 'checkbox') {
		if ($(this).is(":checked")) {
			$("#mot_sudoku_fame_limit_field").show();
		} else {
			$("#mot_sudoku_fame_limit_field").hide();
		}
	}
});

if ($("input[name='mot_sudoku_enable_fame']:checked").val() == 1) {
	$("#mot_sudoku_fame_limit_field").show();
}

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

/*
* Check the 'mot_sudoku_reward_time' setting for the value 1 (weekly) and hide or show the 'mot_sudoku_weekday_select' selection
*/
$("#mot_sudoku_reward_time").on('change', function() {
	if ($(this).val() == 1) {
		$("#mot_sudoku_weekday_select").show();
	} else {
		$("#mot_sudoku_weekday_select").hide();
	}
});

// Show the day selection at start if period is set to weekly
if ($("#mot_sudoku_reward_time").val() == 1) {
	$("#mot_sudoku_weekday_select").show();
}

/*
* Submit the form if another entry was selected from the Sudoku type dropdown select
*/
$("#acp_mot_sudoku_select_type").on('change', function() {
	this.form.submit();
});

})(jQuery); // Avoid conflicts with other libraries
