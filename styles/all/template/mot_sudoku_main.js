/**
*
* @package MoT Sudoku v0.2.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Select the tab as active and the corresponding content box after a tab was selected
*
* @params	integer	index		the numerical descriptor of the selected tab
*
* @return	none
*/

motSudoku.selectTab = function(index) {
	var elementId = "";

	// Hide all boxes
	$("div.inner").each(function() {
		elementId = $(this).attr('id');
		if ((typeof elementId !== 'undefined') && (elementId.substr(0,15) == 'mot_sudoku_box_')) {
			$(this).attr("hidden", true);
		}
	});

	// Set all tabs to inactive
	$("li.tab").each(function() {
		elementId = $(this).attr('id');
		if ((typeof elementId !== 'undefined') && (elementId.substr(0,15) == 'mot_sudoku_tab_')) {
			$(this).attr("class", 'tab');
		}
	});

	// Set selected tab to active
	$("#mot_sudoku_tab_" + index).attr("class", 'tab activetab');

	// Show selected box
	$("#mot_sudoku_box_" + index).attr("hidden", false);
}

motSudoku.selectTab(motSudoku.tab);

})(jQuery); // Avoid conflicts with other libraries
