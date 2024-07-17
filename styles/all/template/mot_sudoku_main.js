/**
*
* @package MoT Sudoku v0.10.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Select the tab as active and the corresponding content box after a tab was selected
*
* @params	string	index		the descriptor of the selected tab
*
* @return	none
*/
motSudoku.selectTab = function(index) {
	let elementId = "";

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

motSudoku.newLevel = motSudoku.gameLevel;

motSudoku.puzzleInProgress = true;

motSudoku.screenWidth = 700;
motSudoku.normalOffsetY = 80;
motSudoku.smallOffsetY = 110;
motSudoku.normalOffsetYAbove = 50;
motSudoku.smallOffsetYAbove = 70;

/*
* Hide the level submit button if this is a stored game
*
*/
if (motSudoku.gameEntryId > 0) {
	$("#mot_sudoku_select_level_button_c").hide();
	$("#mot_sudoku_select_level_button_s").hide();
	$("#mot_sudoku_select_level_button_n").hide();
}

/*
* Set the correct display status on the helper note and the button name if helper is enabled
*
*/
if (motSudoku.helper) {
	let type = motSudoku.tab.substr(0, 1);
	$("#mot_sudoku_helper_note_" + type).show();
	$("#mask_helper_button_" + type).show();
	$("#enable_helper_button_" + type).html(motSudoku.updateHelper);
	$("#enable_helper_button_" + type).prop('title', motSudoku.updateHelper);
} else {
	let type = motSudoku.tab.substr(0, 1);
	$("#mot_sudoku_helper_note_" + type).hide();
	$("#mask_helper_button_" + type).hide();
}

/*
* Put an event handler on each of the three level select inputs to detect a change and save it
*
*/
$("select[name^='mot_sudoku_select_level_']").on('change', function(e) {
	motSudoku.newLevel = $(this).prop('selectedIndex');
});

/*
* Handle a click on one of the digits in the modal windows digit line
*
*/
$("#mot_sudoku_modal_1, #mot_sudoku_modal_2, #mot_sudoku_modal_3, #mot_sudoku_modal_4, #mot_sudoku_modal_5, #mot_sudoku_modal_6, #mot_sudoku_modal_7, #mot_sudoku_modal_8, #mot_sudoku_modal_9, #mot_sudoku_modal_0").on("click", function() {
	if (motSudoku.puzzleInProgress) {
		// Get the css settings
		let fontSizeBig = $("#" + motSudoku.CellId).css('--fontSizeBig');
		let fontWeightNormal = $("#" + motSudoku.CellId).css('--fontWeightNormal');
		let textColorPlayer = $("#" + motSudoku.CellId).css('--textColorPlayer');
		let textAlignCenter = $("#" + motSudoku.CellId).css('--textAlignCenter');
		let verticalAlignMiddle = $("#" + motSudoku.CellId).css('--verticalAlignMiddle');

		// Get this buttons ID
		let thisElementId = $(this).attr('id');
		// Extract the number from the ID
		let number = thisElementId.substr(17, 1);

		$("#mot_sudoku_modal").hide();

		// Now send all the necessary information back to the server
		let type = motSudoku.CellId.substr(11, 1);
		// Ajax call
		$.post(
			motSudoku.ajaxNumberCall,
			{
				entry:		motSudoku.gameEntryId,
				type:		type,
				id:			motSudoku.puzzleId,
				number:		number,
				cell:		motSudoku.CellId.substr(21),
				user_id:	motSudoku.userId,
			},
			function(result) {
				// First we check if the player is still logged in and if he is not we reload the page and thus enforce a new login
				if (!result['logged_in']) {
					location.reload();
				} else {
					motSudoku.digitNoBuy = result['digit_no_buy'];
					motSudoku.gameEntryId = result['entry_id'];
					$("#mot_sudoku_select_level_button_" + type).hide();
					$("#mot_sudoku_current_points_" + type).html(result['points']);

					// Handle the type of button
					if (number > 0) {
						// Set the style for the selected cell and write the number into it
						$("#" + motSudoku.CellId).css({"font-size": fontSizeBig, "font-weight": fontWeightNormal, "color": textColorPlayer, "text-align": textAlignCenter, "vertical-align": verticalAlignMiddle, 'background-color': motSudoku.backgroundColour});
						$("#" + motSudoku.CellId).html(number);
					} else {
						// Number was removed, reset style and delete it from cell
						$("#" + motSudoku.CellId).css('background-color', motSudoku.backgroundColour);
						$("#" + motSudoku.CellId).html('');
					}

					switch (type) {
						case 'c':
							// Update the array with player input
							motSudoku.playerLineC = result['player_line'];
							if (result['filled']) {
								if (result['solved']) {
									// Puzzle is solved, first we set the puzzleInProgress to false
									motSudoku.puzzleInProgress = false;
									// Show the end of game message
									phpbb.alert(motSudoku.congratulation, motSudoku.puzzleSolved + result['points'] + motSudoku.startNew);
									phpbb.loadingIndicator();
									setTimeout(function() {
										$("#mot_sudoku_classic").trigger( "submit" );
									}, 5000);
								} else {
									// Puzzle wasn't solved correctly, remove the incorrect digits from the grid
									result['wrong_digits'].forEach(function(item) {
										$("#mot_sudoku_c_cell_id_" + item.i + item.j).html('');
									});
									// Display a message to explain what happened
									phpbb.alert(motSudoku.errorErr, motSudoku.errorSolution);
								}
							}
							break;

						case 's':
							// Update the array with player input
							motSudoku.playerLineS = result['player_line'];
							if (result['filled']) {
								if (result['solved']) {
									// Puzzle is solved, first we set the puzzleInProgress to false
									motSudoku.puzzleInProgress = false;
									// Show the end of game message
									phpbb.alert(motSudoku.congratulation, motSudoku.puzzleSolved + result['points'] + motSudoku.startNew);
									phpbb.loadingIndicator();
									setTimeout(function() {
										$("#mot_sudoku_samurai").trigger( "submit" );
									}, 5000);
								} else {
									// Puzzle wasn't solved correctly, remove the incorrect digits from the grid
									result['wrong_digits'].forEach(function(item) {
										$("#mot_sudoku_s_cell_id_" + item.g + "_" + item.i + '' + item.j).html('');
									});
									// Display a message to explain what happened
									phpbb.alert(motSudoku.errorErr, motSudoku.errorSolution);
								}
							}
							break;

						case 'n':
							// Update the array with player input
							motSudoku.playerLineN = result['player_line'];
							if (result['filled']) {
								if (result['solved']) {
									// Puzzle is solved, first we set the puzzleInProgress to false
									motSudoku.puzzleInProgress = false;
									// Show the end of game message
									phpbb.alert(motSudoku.congratulation, motSudoku.puzzleSolved + result['points'] + motSudoku.startNew);
									phpbb.loadingIndicator();
									setTimeout(function() {
										$("#mot_sudoku_ninja").trigger( "submit" );
									}, 5000);
								} else {
									// Puzzle wasn't solved correctly, remove the incorrect digits from the grid
									result['wrong_digits'].forEach(function(item) {
										$("#mot_sudoku_n_cell_id_" + item.g + "_" + item.i + '' + item.j).html('');
									});
									// Display a message to explain what happened
									phpbb.alert(motSudoku.errorErr, motSudoku.errorSolution);
								}
							}
							break;
					}
				}
			}
		);
	} else {
		// Puzzle is finished, do not do anything
		$("#" + motSudoku.CellId).css('background-color', motSudoku.backgroundColour);
		$("#mot_sudoku_modal").hide();
	}
});

/*
* Handle a click on the modal window outside the digit line (just close it and do nothing else)
*
*/
$("#mot_sudoku_modal").on("click", function() {
	$("#" + motSudoku.CellId).css('background-color', motSudoku.backgroundColour);
	$(this).hide();
});

/*
* Reset the game grid to the puzzle line from the database players item since there may be stored additional (bought) digits
*
*/
$("#game_reset_button_c, #game_reset_button_s, #game_reset_button_n").on("click", function() {
	if (motSudoku.puzzleInProgress) {
		// Ajax call
		$.post(
			motSudoku.ajaxGameReset,
			{
				entry:	motSudoku.gameEntryId,
			},
			function(result) {
				if (result['success']) {
					// First we check if the player is still logged in and if he is not we reload the page and thus enforce a new login
					if (!result['logged_in']) {
						location.reload();
					} else {
						// set the proper values
						motSudoku.reset = result['reset'];
						$("#mot_sudoku_negative_points_" + result['type']).html(result['negative_points']);
						$("#mot_sudoku_current_points_" + result['type']).html(result['points']);

						// restore the puzzle line according to the game type
						switch (result['type']) {
							case 'c':
								motSudoku.resetClassic(result['puzzle_line']);
								motSudoku.playerLineC = result['player_line'];		// Reset the players input (no need to do it with the puzzle line since this hasn't changed
								break;

							case 's':
								motSudoku.resetSamurai(result['puzzle_line']);
								motSudoku.playerLineS = result['player_line'];		// Reset the players input (no need to do it with the puzzle line since this hasn't changed
								break;

							case 'n':
								motSudoku.resetNinja(result['puzzle_line']);
								motSudoku.playerLineN = result['player_line'];		// Reset the players input (no need to do it with the puzzle line since this hasn't changed
								break;
						}
					}
				} else {
					phpbb.alert(motSudoku.errorErr, motSudoku.errorReset);
				}
			}
		);
	}
});

/*
* Handle buying a digit
*
*/
$("#buy_digit_button_c, #buy_digit_button_s, #buy_digit_button_n").on("click", function() {
	if (motSudoku.puzzleInProgress) {
		// If somebody tries to buy the last missing digit display an error message
		if (motSudoku.digitNoBuy) {
			phpbb.alert(motSudoku.errorErr, motSudoku.errorBuyLastDigit);
		} else {
			// Ajax call
			$.post(
				motSudoku.ajaxBuyDigit,
				{
					entry:	motSudoku.gameEntryId,
				},
				function(result) {
					if (result['success']) {
						// First we check if the player is still logged in and if he is not we reload the page and thus enforce a new login
						if (!result['logged_in']) {
							location.reload();
						} else {
							// Get the proper css variables
							let textColorBuy = $("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).css('--textColorBuy');
							let fontWeightBold = $("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).css('--fontWeightBold');
							let fontSizeBig = $("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).css('--fontSizeBig');
							let textAlignCenter = $("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).css('--textAlignCenter');
							let verticalAlignMiddle = $("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).css('--verticalAlignMiddle');

							// restore the puzzle line according to the game type
							switch (result['type']) {
								case 'c':
									// Set the new values
									$("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).html(result['digit']);
									$("#mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1)).css({"color": textColorBuy, "font-weight": fontWeightBold, "font-size": fontSizeBig, "text-align": textAlignCenter, "vertical-align": verticalAlignMiddle});
									motSudoku.preSelectedCells.push("mot_sudoku_c_cell_id_" + (result['i'] + 1) + (result['j'] + 1));
									motSudoku.puzzleLine = result['puzzle_line'];		// Update the stored puzzle
									break;

								case 's':
									// Set the new values
									$("#mot_sudoku_s_cell_id_" + (result['g'] + 1) + "_" + (result['i'] + 1) + (result['j'] + 1)).html(result['digit']);
									$("#mot_sudoku_s_cell_id_" + (result['g'] + 1) + "_" + (result['i'] + 1) + (result['j'] + 1)).css({"color": textColorBuy, "font-weight": fontWeightBold, "font-size": fontSizeBig, "text-align": textAlignCenter, "vertical-align": verticalAlignMiddle});
									motSudoku.preSelectedCells.push("mot_sudoku_s_cell_id_" + (result['g'] + 1) + "_" + (result['i'] + 1) + (result['j'] + 1));
									motSudoku.puzzleLine = result['puzzle_line'];		// Update the stored puzzle
									break;

								case 'n':
									fontSizeBig = $("#mot_sudoku_n_cell_id_" + (result['g'] + 1) + '_' + (result['i'] + 1) + (result['j'] + 1)).css('--fontSizeBig');
									// Set the new values
									$("#mot_sudoku_n_cell_id_" + (result['g'] + 1) + "_" + (result['i'] + 1) + (result['j'] + 1)).html(result['digit']);
									$("#mot_sudoku_n_cell_id_" + (result['g'] + 1) + "_" + (result['i'] + 1) + (result['j'] + 1)).css({"color": textColorBuy, "font-weight": fontWeightBold, "font-size": fontSizeBig, "text-align": textAlignCenter, "vertical-align": verticalAlignMiddle});
									motSudoku.preSelectedCells.push("mot_sudoku_n_cell_id_" + (result['g'] + 1) + "_" + (result['i'] + 1) + (result['j'] + 1));
									motSudoku.puzzleLine = result['puzzle_line'];		// Update the stored puzzle
									break;
							}
							$("#mot_sudoku_gainable_points_" + result['type']).html(result['gainable_points']);
							$("#mot_sudoku_negative_points_" + result['type']).html(result['negative_points']);
						}
					} else {
						phpbb.alert(motSudoku.errorErr, motSudoku.errorBuyDigit);
					}
				}
			);
		}
	}
});

/*
* Add an event handler to the helper button
*
*/
$("#enable_helper_button_c, #enable_helper_button_s, #enable_helper_button_n").on("click", function() {
	if (motSudoku.puzzleInProgress) {
		if (motSudoku.gameEntryId) {		// We have an entry_id > 0 and thus a running game
			if (motSudoku.helper) {
				let type = $(this).attr('id').substr(21, 1);
				motSudoku.callTypeHelper(type);
			} else {
				// The helper is still disabled so we have to enable it and set the negative points
				// Ajax call
				$.post(
					motSudoku.ajaxEnableHelper,
					{
						entry:	motSudoku.gameEntryId,
					},
					function(result) {
						if (result['success']) {
							motSudoku.helper++;
							$("#mot_sudoku_negative_points_" + result['type']).html(result['negative_points']);
							$("#mot_sudoku_helper_note_" + result['type']).show();
							$("#mask_helper_button_" + result['type']).show();
							$("#enable_helper_button_" + result['type']).html(motSudoku.updateHelper);
							$("#enable_helper_button_" + result['type']).prop('title', motSudoku.updateHelper);
							motSudoku.callTypeHelper(result['type']);
						} else {
							phpbb.alert(motSudoku.errorErr, motSudoku.errorHelper);
						}
					}
				);
			}
		} else { 							// We have a new game and therefor no reason to use the helper
			phpbb.alert(motSudoku.errorErr, motSudoku.errorHelper);
		}
	}
});

/*
* Add an event handler to the mask helper button
*
*/
$("#mask_helper_button_c, #mask_helper_button_s, #mask_helper_button_n").on("click", function() {
	if (motSudoku.puzzleInProgress) {
		let type = $(this).attr('id').substr(19, 1);
		switch (type) {
		case 'c':
			motSudoku.classicHelperMask();
			break;

		case 's':
			motSudoku.samuraiHelperMask();
			break;

		case 'n':
			motSudoku.ninjaHelperMask();
			break;
		}
	}
});

/*
* Quit the game in case the player is stuck
*
*/
$("#game_quit_button_c, #game_quit_button_s, #game_quit_button_n").on("click", function() {
	if (motSudoku.puzzleInProgress) {
		let type = $(this).attr('id').substr(17, 1);

		phpbb.confirm(motSudoku.confirmQuitMsg, function(quit) {
			if (quit) {
				// Ajax call
				$.post(
					motSudoku.ajaxGameQuit,
					{
						entry:		motSudoku.gameEntryId,
						user_id:	motSudoku.userId,
					},
					function(result) {
						// First we check if the player is still logged in and if he is not we reload the page and thus enforce a new login
						if (!result['logged_in']) {
							location.reload();
						} else if (result['success']) {
							// Game has been deleted from the SUDOKU_GAMES_TABLE, inform the player
							phpbb.alert(motSudoku.notesTitle, motSudoku.notesQuit);
							phpbb.loadingIndicator();

							// and now load a new game
							switch (type){
								case 'c':
									setTimeout(function() {
										$("#mot_sudoku_classic").trigger( "submit" );
									}, 5000);
									break;

								case 's':
									setTimeout(function() {
										$("#mot_sudoku_samurai").trigger( "submit" );
									}, 5000);
									break;

								case 'n':
									setTimeout(function() {
										$("#mot_sudoku_ninja").trigger( "submit" );
									}, 5000);
									break;
							}
						} else {
							phpbb.alert(motSudoku.errorErr, motSudoku.errorQuit);
						}
					}
				);
			}
		});
	}
});

/*
* Handle the modal window position switch and set the proper values
*
*/
$("input[name='mot_sudoku_modal_switch']").click(function() {
	let switchPos = 0;

	// Check radio buttons
	if ($(this).attr('type') == 'radio') {
		if ($(this).val() == 1) {
			switchPos = 1;
		} else {
			switchPos = 0;
		}
	}

	// Check checkbox
	if ($(this).attr('type') == 'checkbox') {
		if ($(this).is(":checked")) {
			switchPos = 1;
		} else {
			switchPos = 0;
		}
	}

	motSudoku.modalSwitch = switchPos;
	// Ajax call
	$.post(
		motSudoku.ajaxModalPos,
		{
			position:	switchPos,
		},
	);
});

/*
* Handle a click on the level submit button
*
*/
$("#mot_sudoku_select_level_button_c, #mot_sudoku_select_level_button_s, #mot_sudoku_select_level_button_n").on('click', function() {
	if (motSudoku.newLevel != motSudoku.gameLevel) {
		$.post(
			motSudoku.ajaxSelectLevel,
			{
				entry:		motSudoku.gameEntryId,
				id:			motSudoku.puzzleId,
				type:		$(this).attr('id').substr(31, 1),
				level:		motSudoku.newLevel,
				user_id:	motSudoku.userId,
			},
			function(result) {
				// First we check if the player is still logged in and if he is not we reload the page and thus enforce a new login
				if (!result['logged_in']) {
					location.reload();
				}

				// Set the new entry_id
				motSudoku.gameEntryId = result['entry_id'];
				// Enter the additional digits into the displayed grid according to the game type
				switch (result['type']) {
					case 'c':
						// Get the proper css variables first, and since these are equal for all cells we do it just once to improve performance
						let textColorBuyC = $("#mot_sudoku_c_cell_id_11").css('--textColorBuy');
						result['new_digits'].forEach(function(item) {
							$("#mot_sudoku_c_cell_id_" + (item.i + 1) + (item.j + 1)).html(item.digit);
							$("#mot_sudoku_c_cell_id_" + (item.i + 1) + (item.j + 1)).css("color", textColorBuyC);
							motSudoku.preSelectedCells.push("mot_sudoku_c_cell_id_" + (item.i + 1) + (item.j + 1));
						});
						break;

					case 's':
						// Get the proper css variables first, and since these are equal for all cells we do it just once to improve performance
						let textColorBuyS = $("#mot_sudoku_s_cell_id_1_11").css('--textColorBuy');
						result['new_digits'].forEach(function(item) {
							$("#mot_sudoku_s_cell_id_" + (item.g + 1) + '_' + (item.i + 1) + (item.j + 1)).html(item.digit);
							$("#mot_sudoku_s_cell_id_" + (item.g + 1) + '_' + (item.i + 1) + (item.j + 1)).css("color", textColorBuyS);
							motSudoku.preSelectedCells.push("mot_sudoku_s_cell_id_" + (item.g + 1) + '_' + (item.i + 1) + (item.j + 1));
						});
						break;

					case 'n':
						// Get the proper css variables first, and since these are equal for all cells we do it just once to improve performance
						let textColorBuyN = $("#mot_sudoku_n_cell_id_1_11").css('--textColorBuy');
						result['new_digits'].forEach(function(item) {
							$("#mot_sudoku_n_cell_id_" + (item.g + 1) + '_' + (item.i + 1) + (item.j + 1)).html(item.digit);
							$("#mot_sudoku_n_cell_id_" + (item.g + 1) + '_' + (item.i + 1) + (item.j + 1)).css("color", textColorBuyN);
							motSudoku.preSelectedCells.push("mot_sudoku_n_cell_id_" + (item.g + 1) + '_' + (item.i + 1) + (item.j + 1));
						});
						break;
				}

				motSudoku.puzzleLine = result['puzzle_line'];		// Update the stored puzzle
				$("#mot_sudoku_gainable_points_" + result['type']).html(result['gainable_points']);
				$("#mot_sudoku_negative_points_" + result['type']).html(result['negative_points']);
				$("#mot_sudoku_select_level_button_" + result['type']).hide();
			}
		);
	} else {
		phpbb.alert(motSudoku.errorErr, motSudoku.errorLevel);
	}
});

/*
* Call the correct function for each game type helper
*
*/
motSudoku.callTypeHelper = function(type) {
	switch (type) {
		case 'c':
			motSudoku.classicHelper();
			break;

		case 's':
		case 'n':
			let tempPuzzle = new Array();
			let grid = type == 's' ? 5 : 9;
			for (let g = 0; g < grid; g++) {
				tempPuzzle[g] = new Array();
				for (let i = 0; i < 9; i++) {
					tempPuzzle[g][i] = new Array();
					for (let j = 0; j < 9; j++) {
						tempPuzzle[g][i].push(this.puzzleLine[g][i][j]);
					}
				}
			}

			if (type == 's') {
				let tempPlayer = new Array();
				for (let g = 0; g < grid; g++) {
					tempPlayer[g] = new Array();
					for (let i = 0; i < 9; i++) {
						tempPlayer[g][i] = new Array();
						for (let j = 0; j < 9; j++) {
							tempPlayer[g][i].push(this.playerLineS[g][i][j]);
						}
					}
				}

				this.samuraiHelper(tempPuzzle, tempPlayer);
			}

			if (type == 'n') {
				let tempPlayer = new Array();
				for (let g = 0; g < grid; g++) {
					tempPlayer[g] = new Array();
					for (let i = 0; i < 9; i++) {
						tempPlayer[g][i] = new Array();
						for (let j = 0; j < 9; j++) {
							tempPlayer[g][i].push(this.playerLineN[g][i][j]);
						}
					}
				}

				this.ninjaHelper(tempPuzzle, tempPlayer);
			}
			break;
	}
}

motSudoku.getGridDigits = function(puzzle, player) {
	let lines = [];
	let columns = [];
	let subGrids = [];
	let content = '';
	let digitsArray = [[], [], [], [], [], [], [], [], []];

	// Get the digits already present in the 9 lines
	for (let i = 0; i <= 8; i++) {
		lines[i] = [];
		for (let j = 0; j <= 8; j++) {
			content = puzzle[i][j] + player[i][j];
			if (content > 0) {
				lines[i].push(Number(content));
			}
		}
	}

	// Get the digits already present in the 9 columns
	for (let j = 0; j <= 8; j++) {
		columns[j] = [];
		for (let i = 0; i <= 8; i++) {
			content = puzzle[i][j] + player[i][j];
			if (content > 0) {
				columns[j].push(Number(content));
			}
		}
	}

	// Get the digits already present in the 9 sub grids
	let line = 0;
	let row = 0;
	for (let l = 1; l <= 3; l++) {
		for (let r = 1; r <= 3; r++) {
			let grid = ((3 * (l - 1)) + r);
			subGrids[grid] = [];
			for (let i = 1; i <= 3; i++) {
				for (let j = 1; j <= 3; j++) {
					line = ((3 * (l - 1)) + i) - 1;
					row = ((3 * (r - 1)) + j) - 1;
					content = puzzle[line][row] + player[line][row];
					if (content > 0) {
						subGrids[grid].push(Number(content));
					}
				}
			}
		}
	}

	// Go through every cell and if it is empty get the digits which are not excluded by line, row or subgrid
	let allDigits = [1, 2, 3, 4, 5, 6, 7, 8, 9];
	let cellDigits = [];

	for (let l = 1; l <= 3; l++) {
		for (let r = 1; r <= 3; r++) {
			let grid = ((3 * (l - 1)) + r);
			for (let i = 1; i <= 3; i++) {
				for (let j = 1; j <= 3; j++) {
					line = ((3 * (l - 1)) + i);
					row = ((3 * (r - 1)) + j);
					content = puzzle[line - 1][row - 1] + player[line - 1][row - 1];
					if (content == 0) {
						cellDigits = allDigits.filter(function(value) {
							return !lines[line - 1].includes(value);
						});
						cellDigits = cellDigits.filter( function(value) {
							return !columns[row - 1].includes(value);
						});
						cellDigits = cellDigits.filter( function(value) {
							return !subGrids[grid].includes(value);
						});
						digitsArray[line - 1][row - 1] = cellDigits;
					}
				}
			}
		}
	}
	return digitsArray;
}

})(jQuery); // Avoid conflicts with other libraries
