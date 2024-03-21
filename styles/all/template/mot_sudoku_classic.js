/**
*
* @package MoT Sudoku v0.6.2
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Add the filled cells to the classic Sudoku puzzle at game start
*
*/
if (motSudoku.playerLineC != null) {
	// Get the css variables, we do this here once since it is the same for all cells and thus improves performance
	let fontWeightNormal = $("#mot_sudoku_c_cell_id_11").css('--fontWeightNormal');
	let textColorPlayer = $("#mot_sudoku_c_cell_id_11").css('--textColorPlayer');

	for (let i = 0; i < 9; i++) {
		for (let j = 0; j < 9; j++) {
			if (motSudoku.playerLineC[i][j] > 0) {
				$("#mot_sudoku_c_cell_id_" + (i +1) + (j + 1)).css({"font-weight": fontWeightNormal, "color": textColorPlayer});
				$("#mot_sudoku_c_cell_id_" + (i +1) + (j + 1)).html(motSudoku.playerLineC[i][j]);
			}
		}
	}
}

/*
* Add the highlighting of the selected cell and opening of the modal window to the classic Sudoku game's cells
*
*/
$(
"#mot_sudoku_c_cell_id_11, #mot_sudoku_c_cell_id_12, #mot_sudoku_c_cell_id_13, #mot_sudoku_c_cell_id_14, #mot_sudoku_c_cell_id_15, #mot_sudoku_c_cell_id_16, #mot_sudoku_c_cell_id_17, #mot_sudoku_c_cell_id_18, #mot_sudoku_c_cell_id_19, " +
"#mot_sudoku_c_cell_id_21, #mot_sudoku_c_cell_id_22, #mot_sudoku_c_cell_id_23, #mot_sudoku_c_cell_id_24, #mot_sudoku_c_cell_id_25, #mot_sudoku_c_cell_id_26, #mot_sudoku_c_cell_id_27, #mot_sudoku_c_cell_id_28, #mot_sudoku_c_cell_id_29, " +
"#mot_sudoku_c_cell_id_31, #mot_sudoku_c_cell_id_32, #mot_sudoku_c_cell_id_33, #mot_sudoku_c_cell_id_34, #mot_sudoku_c_cell_id_35, #mot_sudoku_c_cell_id_36, #mot_sudoku_c_cell_id_37, #mot_sudoku_c_cell_id_38, #mot_sudoku_c_cell_id_39, " +
"#mot_sudoku_c_cell_id_41, #mot_sudoku_c_cell_id_42, #mot_sudoku_c_cell_id_43, #mot_sudoku_c_cell_id_44, #mot_sudoku_c_cell_id_45, #mot_sudoku_c_cell_id_46, #mot_sudoku_c_cell_id_47, #mot_sudoku_c_cell_id_48, #mot_sudoku_c_cell_id_49, " +
"#mot_sudoku_c_cell_id_51, #mot_sudoku_c_cell_id_52, #mot_sudoku_c_cell_id_53, #mot_sudoku_c_cell_id_54, #mot_sudoku_c_cell_id_55, #mot_sudoku_c_cell_id_56, #mot_sudoku_c_cell_id_57, #mot_sudoku_c_cell_id_58, #mot_sudoku_c_cell_id_59, " +
"#mot_sudoku_c_cell_id_61, #mot_sudoku_c_cell_id_62, #mot_sudoku_c_cell_id_63, #mot_sudoku_c_cell_id_64, #mot_sudoku_c_cell_id_65, #mot_sudoku_c_cell_id_66, #mot_sudoku_c_cell_id_67, #mot_sudoku_c_cell_id_68, #mot_sudoku_c_cell_id_69, " +
"#mot_sudoku_c_cell_id_71, #mot_sudoku_c_cell_id_72, #mot_sudoku_c_cell_id_73, #mot_sudoku_c_cell_id_74, #mot_sudoku_c_cell_id_75, #mot_sudoku_c_cell_id_76, #mot_sudoku_c_cell_id_77, #mot_sudoku_c_cell_id_78, #mot_sudoku_c_cell_id_79, " +
"#mot_sudoku_c_cell_id_81, #mot_sudoku_c_cell_id_82, #mot_sudoku_c_cell_id_83, #mot_sudoku_c_cell_id_84, #mot_sudoku_c_cell_id_85, #mot_sudoku_c_cell_id_86, #mot_sudoku_c_cell_id_87, #mot_sudoku_c_cell_id_88, #mot_sudoku_c_cell_id_89, " +
"#mot_sudoku_c_cell_id_91, #mot_sudoku_c_cell_id_92, #mot_sudoku_c_cell_id_93, #mot_sudoku_c_cell_id_94, #mot_sudoku_c_cell_id_95, #mot_sudoku_c_cell_id_96, #mot_sudoku_c_cell_id_97, #mot_sudoku_c_cell_id_98, #mot_sudoku_c_cell_id_99"
).on("click", function(e) {
	if (motSudoku.preSelectedCells.indexOf($(this).attr('id')) == -1) {
		let thisElementId = $(this).attr('id');
		let lineNumber = thisElementId.substr(21, 1);
		let columnNumber = thisElementId.substr(22, 1);
		let offsetX = 0;
		let offsetY = 0;

		if ($(window).width() >= motSudoku.screenWidth) {
			offsetX = (columnNumber * 40) - (10/columnNumber);
			if (motSudoku.modalSwitch) {
				offsetY = motSudoku.normalOffsetY;
			} else {
				offsetY = (lineNumber * 40) + motSudoku.normalOffsetYAbove;
			}
		} else {
			offsetX = columnNumber * 20;
			if (motSudoku.modalSwitch) {
				offsetY = motSudoku.smallOffsetY;
			} else {
				offsetY = (lineNumber * 37) + motSudoku.smallOffsetYAbove;
			}
		}

		let yStart = e.clientY - offsetY > 0 ? e.clientY - offsetY : 0;
		let xStart = e.clientX - offsetX > 30 ? e.clientX - offsetX : 30;
		motSudoku.CellId = thisElementId;
		motSudoku.backgroundColour = $(this).css('background-color');
		let backgroundColour = $(this).css('--backgroundColorActive');
		$(this).css('background-color', backgroundColour);
		$("#mot_sudoku_modal_content").css({top: yStart, left: xStart, position: 'relative'});
		$("#mot_sudoku_modal").show();
	}
});

/*
* Reset the classic grid to the content of puzzle
*
* param	puzzle	array		a 9 * 9 array with the content to be written into the cells
*/
motSudoku.resetClassic = function(puzzle) {
	let systemColor = $(".panel").css('color');
	for (let i = 0; i < 9; i++) {
		for (let j = 0; j < 9; j++) {
			if (puzzle[i][j]) {
				$("#mot_sudoku_c_cell_id_" + (i + 1) + (j + 1)).html(puzzle[i][j]);
				$("#mot_sudoku_c_cell_id_" + (i + 1) + (j + 1)).css('color', systemColor);
			} else {
				$("#mot_sudoku_c_cell_id_" + (i + 1) + (j + 1)).html('');
			}
			// since the 'motSudoku.preSelectedCells' array should still hold valid names we do not need to set it here, too
		}
	}
}

/*
* Classic Sudoku helper
*
*/
motSudoku.classicHelper = function() {
	// Get the css variables
	let fontSizeSmall = $("#mot_sudoku_c_cell_id_11").css('--fontSizeSmall');
	let fontWeightNormal = $("#mot_sudoku_c_cell_id_11").css('--fontWeightNormal');
	let textColorPlayer = $("#mot_sudoku_c_cell_id_11").css('--textColorPlayer');
	let textAlignLeft = $("#mot_sudoku_c_cell_id_11").css('--textAlignLeft');
	let verticalAlignTop = $("#mot_sudoku_c_cell_id_11").css('--verticalAlignTop');

	let lines = new Array();
	let columns = new Array();
	let subGrids = new Array();
	let content = '';

	// Get the digits already present in the 9 lines
	for (let i = 0; i <= 8; i++) {
		lines[i] = new Array();
		for (let j = 0; j <= 8; j++) {
			content = this.puzzleLine[i][j] + this.playerLineC[i][j];
			if (content > 0) {
				lines[i].push(Number(content));
			}
		}
	}

	// Get the digits already present in the 9 columns
	for (let j = 0; j <= 8; j++) {
		columns[j] = new Array();
		for (let i = 0; i <= 8; i++) {
			content = this.puzzleLine[i][j] + this.playerLineC[i][j];
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
			subGrids[grid] = new Array();
			for (let i = 1; i <= 3; i++) {
				for (let j = 1; j <= 3; j++) {
					line = ((3 * (l - 1)) + i) - 1;
					row = ((3 * (r - 1)) + j) - 1;
					content = this.puzzleLine[line][row] + this.playerLineC[line][row];
					if (content > 0) {
						subGrids[grid].push(Number(content));
					}
				}
			}
		}
	}

	// Go through every cell and if it is empty get the digits which are not excluded by line, row or subgrid
	let allDigits = [1, 2, 3, 4, 5, 6, 7, 8, 9];
	let cellDigits = new Array();

	for (let l = 1; l <= 3; l++) {
		for (let r = 1; r <= 3; r++) {
			let grid = ((3 * (l - 1)) + r);
			for (let i = 1; i <= 3; i++) {
				for (let j = 1; j <= 3; j++) {
					line = ((3 * (l - 1)) + i);
					row = ((3 * (r - 1)) + j);
					content = this.puzzleLine[line - 1][row - 1] + this.playerLineC[line - 1][row - 1];
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
						// Set the style
						$("#mot_sudoku_c_cell_id_" + line + row).css({"font-size": fontSizeSmall, "font-weight": fontWeightNormal, "color": textColorPlayer, "text-align": textAlignLeft, "vertical-align": verticalAlignTop});
						$("#mot_sudoku_c_cell_id_" + line + row).html(cellDigits.join(', '));
					}
				}
			}
		}
	}
}

motSudoku.classicHelperMask = function() {
	let content = '';
	for (let x = 0; x <= 8; x++) {
		for (let y = 0; y <= 8; y++) {
			content = this.puzzleLine[x][y] + this.playerLineC[x][y];
			if (content == 0) {
				$("#mot_sudoku_c_cell_id_" + (x + 1) + (y + 1)).html('');
			}
		}
	}
}

})(jQuery); // Avoid conflicts with other libraries
