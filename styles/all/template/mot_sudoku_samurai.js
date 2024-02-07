/**
*
* @package MoT Sudoku v0.4.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Add the filled cells to the Samurai Sudoku puzzle at game start
*
*/
if (motSudoku.playerLineS != null) {
	// Get the css variables, we do this here once since it is the same for all cells and thus improves performance
	let fontWeightNormal = $("#mot_sudoku_s_cell_id_1_11").css('--fontWeightNormal');
	let textColorPlayer = $("#mot_sudoku_s_cell_id_1_11").css('--textColorPlayer');

	for (let g = 0; g < 5; g++) {
		for (let i = 0; i < 9; i++) {
			for (let j = 0; j < 9; j++) {
				if (motSudoku.playerLineS[g][i][j] > 0) {
					$("#mot_sudoku_s_cell_id_" + (g + 1) + "_" + (i +1) + (j + 1)).css({"font-weight": fontWeightNormal, "color": textColorPlayer});
					$("#mot_sudoku_s_cell_id_" + (g + 1) + "_" + (i +1) + (j + 1)).html(motSudoku.playerLineS[g][i][j]);
				}
			}
		}
	}
}

/*
* Add the highlighting of the selected cell and opening of the modal window to the Samurai Sudoku game's cells
*
*/
$(
"#mot_sudoku_s_cell_id_1_11, #mot_sudoku_s_cell_id_1_12, #mot_sudoku_s_cell_id_1_13, #mot_sudoku_s_cell_id_1_14, #mot_sudoku_s_cell_id_1_15, #mot_sudoku_s_cell_id_1_16, #mot_sudoku_s_cell_id_1_17, #mot_sudoku_s_cell_id_1_18, #mot_sudoku_s_cell_id_1_19, " +
"#mot_sudoku_s_cell_id_1_21, #mot_sudoku_s_cell_id_1_22, #mot_sudoku_s_cell_id_1_23, #mot_sudoku_s_cell_id_1_24, #mot_sudoku_s_cell_id_1_25, #mot_sudoku_s_cell_id_1_26, #mot_sudoku_s_cell_id_1_27, #mot_sudoku_s_cell_id_1_28, #mot_sudoku_s_cell_id_1_29, " +
"#mot_sudoku_s_cell_id_1_31, #mot_sudoku_s_cell_id_1_32, #mot_sudoku_s_cell_id_1_33, #mot_sudoku_s_cell_id_1_34, #mot_sudoku_s_cell_id_1_35, #mot_sudoku_s_cell_id_1_36, #mot_sudoku_s_cell_id_1_37, #mot_sudoku_s_cell_id_1_38, #mot_sudoku_s_cell_id_1_39, " +
"#mot_sudoku_s_cell_id_1_41, #mot_sudoku_s_cell_id_1_42, #mot_sudoku_s_cell_id_1_43, #mot_sudoku_s_cell_id_1_44, #mot_sudoku_s_cell_id_1_45, #mot_sudoku_s_cell_id_1_46, #mot_sudoku_s_cell_id_1_47, #mot_sudoku_s_cell_id_1_48, #mot_sudoku_s_cell_id_1_49, " +
"#mot_sudoku_s_cell_id_1_51, #mot_sudoku_s_cell_id_1_52, #mot_sudoku_s_cell_id_1_53, #mot_sudoku_s_cell_id_1_54, #mot_sudoku_s_cell_id_1_55, #mot_sudoku_s_cell_id_1_56, #mot_sudoku_s_cell_id_1_57, #mot_sudoku_s_cell_id_1_58, #mot_sudoku_s_cell_id_1_59, " +
"#mot_sudoku_s_cell_id_1_61, #mot_sudoku_s_cell_id_1_62, #mot_sudoku_s_cell_id_1_63, #mot_sudoku_s_cell_id_1_64, #mot_sudoku_s_cell_id_1_65, #mot_sudoku_s_cell_id_1_66, #mot_sudoku_s_cell_id_1_67, #mot_sudoku_s_cell_id_1_68, #mot_sudoku_s_cell_id_1_69, " +
"#mot_sudoku_s_cell_id_1_71, #mot_sudoku_s_cell_id_1_72, #mot_sudoku_s_cell_id_1_73, #mot_sudoku_s_cell_id_1_74, #mot_sudoku_s_cell_id_1_75, #mot_sudoku_s_cell_id_1_76, #mot_sudoku_s_cell_id_1_77, #mot_sudoku_s_cell_id_1_78, #mot_sudoku_s_cell_id_1_79, " +
"#mot_sudoku_s_cell_id_1_81, #mot_sudoku_s_cell_id_1_82, #mot_sudoku_s_cell_id_1_83, #mot_sudoku_s_cell_id_1_84, #mot_sudoku_s_cell_id_1_85, #mot_sudoku_s_cell_id_1_86, #mot_sudoku_s_cell_id_1_87, #mot_sudoku_s_cell_id_1_88, #mot_sudoku_s_cell_id_1_89, " +
"#mot_sudoku_s_cell_id_1_91, #mot_sudoku_s_cell_id_1_92, #mot_sudoku_s_cell_id_1_93, #mot_sudoku_s_cell_id_1_94, #mot_sudoku_s_cell_id_1_95, #mot_sudoku_s_cell_id_1_96, #mot_sudoku_s_cell_id_1_97, #mot_sudoku_s_cell_id_1_98, #mot_sudoku_s_cell_id_1_99, " +
"#mot_sudoku_s_cell_id_2_11, #mot_sudoku_s_cell_id_2_12, #mot_sudoku_s_cell_id_2_13, #mot_sudoku_s_cell_id_2_14, #mot_sudoku_s_cell_id_2_15, #mot_sudoku_s_cell_id_2_16, #mot_sudoku_s_cell_id_2_17, #mot_sudoku_s_cell_id_2_18, #mot_sudoku_s_cell_id_2_19, " +
"#mot_sudoku_s_cell_id_2_21, #mot_sudoku_s_cell_id_2_22, #mot_sudoku_s_cell_id_2_23, #mot_sudoku_s_cell_id_2_24, #mot_sudoku_s_cell_id_2_25, #mot_sudoku_s_cell_id_2_26, #mot_sudoku_s_cell_id_2_27, #mot_sudoku_s_cell_id_2_28, #mot_sudoku_s_cell_id_2_29, " +
"#mot_sudoku_s_cell_id_2_31, #mot_sudoku_s_cell_id_2_32, #mot_sudoku_s_cell_id_2_33, #mot_sudoku_s_cell_id_2_34, #mot_sudoku_s_cell_id_2_35, #mot_sudoku_s_cell_id_2_36, #mot_sudoku_s_cell_id_2_37, #mot_sudoku_s_cell_id_2_38, #mot_sudoku_s_cell_id_2_39, " +
"#mot_sudoku_s_cell_id_2_41, #mot_sudoku_s_cell_id_2_42, #mot_sudoku_s_cell_id_2_43, #mot_sudoku_s_cell_id_2_44, #mot_sudoku_s_cell_id_2_45, #mot_sudoku_s_cell_id_2_46, #mot_sudoku_s_cell_id_2_47, #mot_sudoku_s_cell_id_2_48, #mot_sudoku_s_cell_id_2_49, " +
"#mot_sudoku_s_cell_id_2_51, #mot_sudoku_s_cell_id_2_52, #mot_sudoku_s_cell_id_2_53, #mot_sudoku_s_cell_id_2_54, #mot_sudoku_s_cell_id_2_55, #mot_sudoku_s_cell_id_2_56, #mot_sudoku_s_cell_id_2_57, #mot_sudoku_s_cell_id_2_58, #mot_sudoku_s_cell_id_2_59, " +
"#mot_sudoku_s_cell_id_2_61, #mot_sudoku_s_cell_id_2_62, #mot_sudoku_s_cell_id_2_63, #mot_sudoku_s_cell_id_2_64, #mot_sudoku_s_cell_id_2_65, #mot_sudoku_s_cell_id_2_66, #mot_sudoku_s_cell_id_2_67, #mot_sudoku_s_cell_id_2_68, #mot_sudoku_s_cell_id_2_69, " +
"#mot_sudoku_s_cell_id_2_71, #mot_sudoku_s_cell_id_2_72, #mot_sudoku_s_cell_id_2_73, #mot_sudoku_s_cell_id_2_74, #mot_sudoku_s_cell_id_2_75, #mot_sudoku_s_cell_id_2_76, #mot_sudoku_s_cell_id_2_77, #mot_sudoku_s_cell_id_2_78, #mot_sudoku_s_cell_id_2_79, " +
"#mot_sudoku_s_cell_id_2_81, #mot_sudoku_s_cell_id_2_82, #mot_sudoku_s_cell_id_2_83, #mot_sudoku_s_cell_id_2_84, #mot_sudoku_s_cell_id_2_85, #mot_sudoku_s_cell_id_2_86, #mot_sudoku_s_cell_id_2_87, #mot_sudoku_s_cell_id_2_88, #mot_sudoku_s_cell_id_2_89, " +
"#mot_sudoku_s_cell_id_2_91, #mot_sudoku_s_cell_id_2_92, #mot_sudoku_s_cell_id_2_93, #mot_sudoku_s_cell_id_2_94, #mot_sudoku_s_cell_id_2_95, #mot_sudoku_s_cell_id_2_96, #mot_sudoku_s_cell_id_2_97, #mot_sudoku_s_cell_id_2_98, #mot_sudoku_s_cell_id_2_99, " +
"#mot_sudoku_s_cell_id_3_14, #mot_sudoku_s_cell_id_3_15, #mot_sudoku_s_cell_id_3_16, " +
"#mot_sudoku_s_cell_id_3_24, #mot_sudoku_s_cell_id_3_25, #mot_sudoku_s_cell_id_3_26, " +
"#mot_sudoku_s_cell_id_3_34, #mot_sudoku_s_cell_id_3_35, #mot_sudoku_s_cell_id_3_36, " +
"#mot_sudoku_s_cell_id_3_41, #mot_sudoku_s_cell_id_3_42, #mot_sudoku_s_cell_id_3_43, #mot_sudoku_s_cell_id_3_44, #mot_sudoku_s_cell_id_3_45, #mot_sudoku_s_cell_id_3_46, #mot_sudoku_s_cell_id_3_47, #mot_sudoku_s_cell_id_3_48, #mot_sudoku_s_cell_id_3_49, " +
"#mot_sudoku_s_cell_id_3_51, #mot_sudoku_s_cell_id_3_52, #mot_sudoku_s_cell_id_3_53, #mot_sudoku_s_cell_id_3_54, #mot_sudoku_s_cell_id_3_55, #mot_sudoku_s_cell_id_3_56, #mot_sudoku_s_cell_id_3_57, #mot_sudoku_s_cell_id_3_58, #mot_sudoku_s_cell_id_3_59, " +
"#mot_sudoku_s_cell_id_3_61, #mot_sudoku_s_cell_id_3_62, #mot_sudoku_s_cell_id_3_63, #mot_sudoku_s_cell_id_3_64, #mot_sudoku_s_cell_id_3_65, #mot_sudoku_s_cell_id_3_66, #mot_sudoku_s_cell_id_3_67, #mot_sudoku_s_cell_id_3_68, #mot_sudoku_s_cell_id_3_69, " +
"#mot_sudoku_s_cell_id_3_74, #mot_sudoku_s_cell_id_3_75, #mot_sudoku_s_cell_id_3_76, " +
"#mot_sudoku_s_cell_id_3_84, #mot_sudoku_s_cell_id_3_85, #mot_sudoku_s_cell_id_3_86, " +
"#mot_sudoku_s_cell_id_3_94, #mot_sudoku_s_cell_id_3_95, #mot_sudoku_s_cell_id_3_96, " +
"#mot_sudoku_s_cell_id_4_11, #mot_sudoku_s_cell_id_4_12, #mot_sudoku_s_cell_id_4_13, #mot_sudoku_s_cell_id_4_14, #mot_sudoku_s_cell_id_4_15, #mot_sudoku_s_cell_id_4_16, #mot_sudoku_s_cell_id_4_17, #mot_sudoku_s_cell_id_4_18, #mot_sudoku_s_cell_id_4_19, " +
"#mot_sudoku_s_cell_id_4_21, #mot_sudoku_s_cell_id_4_22, #mot_sudoku_s_cell_id_4_23, #mot_sudoku_s_cell_id_4_24, #mot_sudoku_s_cell_id_4_25, #mot_sudoku_s_cell_id_4_26, #mot_sudoku_s_cell_id_4_27, #mot_sudoku_s_cell_id_4_28, #mot_sudoku_s_cell_id_4_29, " +
"#mot_sudoku_s_cell_id_4_31, #mot_sudoku_s_cell_id_4_32, #mot_sudoku_s_cell_id_4_33, #mot_sudoku_s_cell_id_4_34, #mot_sudoku_s_cell_id_4_35, #mot_sudoku_s_cell_id_4_36, #mot_sudoku_s_cell_id_4_37, #mot_sudoku_s_cell_id_4_38, #mot_sudoku_s_cell_id_4_39, " +
"#mot_sudoku_s_cell_id_4_41, #mot_sudoku_s_cell_id_4_42, #mot_sudoku_s_cell_id_4_43, #mot_sudoku_s_cell_id_4_44, #mot_sudoku_s_cell_id_4_45, #mot_sudoku_s_cell_id_4_46, #mot_sudoku_s_cell_id_4_47, #mot_sudoku_s_cell_id_4_48, #mot_sudoku_s_cell_id_4_49, " +
"#mot_sudoku_s_cell_id_4_51, #mot_sudoku_s_cell_id_4_52, #mot_sudoku_s_cell_id_4_53, #mot_sudoku_s_cell_id_4_54, #mot_sudoku_s_cell_id_4_55, #mot_sudoku_s_cell_id_4_56, #mot_sudoku_s_cell_id_4_57, #mot_sudoku_s_cell_id_4_58, #mot_sudoku_s_cell_id_4_59, " +
"#mot_sudoku_s_cell_id_4_61, #mot_sudoku_s_cell_id_4_62, #mot_sudoku_s_cell_id_4_63, #mot_sudoku_s_cell_id_4_64, #mot_sudoku_s_cell_id_4_65, #mot_sudoku_s_cell_id_4_66, #mot_sudoku_s_cell_id_4_67, #mot_sudoku_s_cell_id_4_68, #mot_sudoku_s_cell_id_4_69, " +
"#mot_sudoku_s_cell_id_4_71, #mot_sudoku_s_cell_id_4_72, #mot_sudoku_s_cell_id_4_73, #mot_sudoku_s_cell_id_4_74, #mot_sudoku_s_cell_id_4_75, #mot_sudoku_s_cell_id_4_76, #mot_sudoku_s_cell_id_4_77, #mot_sudoku_s_cell_id_4_78, #mot_sudoku_s_cell_id_4_79, " +
"#mot_sudoku_s_cell_id_4_81, #mot_sudoku_s_cell_id_4_82, #mot_sudoku_s_cell_id_4_83, #mot_sudoku_s_cell_id_4_84, #mot_sudoku_s_cell_id_4_85, #mot_sudoku_s_cell_id_4_86, #mot_sudoku_s_cell_id_4_87, #mot_sudoku_s_cell_id_4_88, #mot_sudoku_s_cell_id_4_89, " +
"#mot_sudoku_s_cell_id_4_91, #mot_sudoku_s_cell_id_4_92, #mot_sudoku_s_cell_id_4_93, #mot_sudoku_s_cell_id_4_94, #mot_sudoku_s_cell_id_4_95, #mot_sudoku_s_cell_id_4_96, #mot_sudoku_s_cell_id_4_97, #mot_sudoku_s_cell_id_4_98, #mot_sudoku_s_cell_id_4_99, " +
"#mot_sudoku_s_cell_id_5_11, #mot_sudoku_s_cell_id_5_12, #mot_sudoku_s_cell_id_5_13, #mot_sudoku_s_cell_id_5_14, #mot_sudoku_s_cell_id_5_15, #mot_sudoku_s_cell_id_5_16, #mot_sudoku_s_cell_id_5_17, #mot_sudoku_s_cell_id_5_18, #mot_sudoku_s_cell_id_5_19, " +
"#mot_sudoku_s_cell_id_5_21, #mot_sudoku_s_cell_id_5_22, #mot_sudoku_s_cell_id_5_23, #mot_sudoku_s_cell_id_5_24, #mot_sudoku_s_cell_id_5_25, #mot_sudoku_s_cell_id_5_26, #mot_sudoku_s_cell_id_5_27, #mot_sudoku_s_cell_id_5_28, #mot_sudoku_s_cell_id_5_29, " +
"#mot_sudoku_s_cell_id_5_31, #mot_sudoku_s_cell_id_5_32, #mot_sudoku_s_cell_id_5_33, #mot_sudoku_s_cell_id_5_34, #mot_sudoku_s_cell_id_5_35, #mot_sudoku_s_cell_id_5_36, #mot_sudoku_s_cell_id_5_37, #mot_sudoku_s_cell_id_5_38, #mot_sudoku_s_cell_id_5_39, " +
"#mot_sudoku_s_cell_id_5_41, #mot_sudoku_s_cell_id_5_42, #mot_sudoku_s_cell_id_5_43, #mot_sudoku_s_cell_id_5_44, #mot_sudoku_s_cell_id_5_45, #mot_sudoku_s_cell_id_5_46, #mot_sudoku_s_cell_id_5_47, #mot_sudoku_s_cell_id_5_48, #mot_sudoku_s_cell_id_5_49, " +
"#mot_sudoku_s_cell_id_5_51, #mot_sudoku_s_cell_id_5_52, #mot_sudoku_s_cell_id_5_53, #mot_sudoku_s_cell_id_5_54, #mot_sudoku_s_cell_id_5_55, #mot_sudoku_s_cell_id_5_56, #mot_sudoku_s_cell_id_5_57, #mot_sudoku_s_cell_id_5_58, #mot_sudoku_s_cell_id_5_59, " +
"#mot_sudoku_s_cell_id_5_61, #mot_sudoku_s_cell_id_5_62, #mot_sudoku_s_cell_id_5_63, #mot_sudoku_s_cell_id_5_64, #mot_sudoku_s_cell_id_5_65, #mot_sudoku_s_cell_id_5_66, #mot_sudoku_s_cell_id_5_67, #mot_sudoku_s_cell_id_5_68, #mot_sudoku_s_cell_id_5_69, " +
"#mot_sudoku_s_cell_id_5_71, #mot_sudoku_s_cell_id_5_72, #mot_sudoku_s_cell_id_5_73, #mot_sudoku_s_cell_id_5_74, #mot_sudoku_s_cell_id_5_75, #mot_sudoku_s_cell_id_5_76, #mot_sudoku_s_cell_id_5_77, #mot_sudoku_s_cell_id_5_78, #mot_sudoku_s_cell_id_5_79, " +
"#mot_sudoku_s_cell_id_5_81, #mot_sudoku_s_cell_id_5_82, #mot_sudoku_s_cell_id_5_83, #mot_sudoku_s_cell_id_5_84, #mot_sudoku_s_cell_id_5_85, #mot_sudoku_s_cell_id_5_86, #mot_sudoku_s_cell_id_5_87, #mot_sudoku_s_cell_id_5_88, #mot_sudoku_s_cell_id_5_89, " +
"#mot_sudoku_s_cell_id_5_91, #mot_sudoku_s_cell_id_5_92, #mot_sudoku_s_cell_id_5_93, #mot_sudoku_s_cell_id_5_94, #mot_sudoku_s_cell_id_5_95, #mot_sudoku_s_cell_id_5_96, #mot_sudoku_s_cell_id_5_97, #mot_sudoku_s_cell_id_5_98, #mot_sudoku_s_cell_id_5_99"
).on("click", function(e) {
	if (motSudoku.preSelectedCells.indexOf($(this).attr('id')) == -1) {
		let thisElementId = $(this).attr('id');
		let gridNumber = thisElementId.substr(21, 1);
		let lineNumber = thisElementId.substr(23, 1);
		let columnNumber = thisElementId.substr(24, 1);
		let offsetX = 0;
		let offsetY = 0;

		if ($(window).width() >= 390) {
			offsetX = (columnNumber * 40) - (10/columnNumber);
			if (motSudoku.modalSwitch) {
				offsetY = 65;
			} else {
				offsetY = (lineNumber * 40) + 50;
			}
		} else {
			offsetX = columnNumber * 20;
			if (motSudoku.modalSwitch) {
				offsetY = 95;
			} else {
				offsetY = (lineNumber * 37) + 70;
			}
		}

		motSudoku.CellId = thisElementId;
		motSudoku.backgroundColour = $(this).css('background-color');
		let backgroundColour = $(this).css('--backgroundColorActive');
//		if (!motSudoku.modalSwitch) {
			$(this).css('background-color', backgroundColour);
//		}
		$("#mot_sudoku_modal_content").css({top: e.clientY - offsetY, left: e.clientX - offsetX, position: 'relative'});
		$("#mot_sudoku_modal").show();
	}
});

/*
* Reset the Samurai grid to the content of puzzle
*
* param	puzzle	array		an array holding five 9 * 9 arrays with the content to be written into the cells
*/
motSudoku.resetSamurai = function(puzzle) {
	let systemColor = $(".panel").css('color');
	for (let g = 0; g < 5; g++) {
		for (let i = 0; i < 9; i++) {
			for (let j = 0; j < 9; j++) {
				if (puzzle[g][i][j] > 0) {
					$("#mot_sudoku_s_cell_id_" + (g + 1) + "_" + (i + 1) + (j + 1)).html(puzzle[g][i][j]);
					$("#mot_sudoku_s_cell_id_" + (g + 1) + '_' + (i + 1) + (j + 1)).css('color', systemColor);
				} else {
					$("#mot_sudoku_s_cell_id_" + (g + 1) + '_' + (i + 1) + (j + 1)).html('');
				}
				// since the 'motSudoku.preSelectedCells' array should still hold valid names we do not need to set it here, too
			}
		}
	}
}

/*
* Samurai Sudoku helper
*
*/
motSudoku.samuraiHelper = function(puzzleLine, playerLine) {
	// Get the css variables
	let fontSizeSmall = $("#mot_sudoku_s_cell_id_1_11").css('--fontSizeSmall');
	let fontWeightNormal = $("#mot_sudoku_s_cell_id_1_11").css('--fontWeightNormal');
	let textColorPlayer = $("#mot_sudoku_s_cell_id_1_11").css('--textColorPlayer');
	let textAlignLeft = $("#mot_sudoku_s_cell_id_1_11").css('--textAlignLeft');
	let verticalAlignTop = $("#mot_sudoku_s_cell_id_1_11").css('--verticalAlignTop');

	let gridSequence = [0, 1, 3, 4, 2];
	let cellDigitsArray = [];
	let allDigits = [1, 2, 3, 4, 5, 6, 7, 8, 9];

	gridSequence.forEach((item) => {
		if (item != 2) {
			// Handle the four corner grids
			cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);
		} else {
			// Now we have to handle the center grid
			let grid = 0;
			for (let i = 0; i < 9; i++) {
				for (let j = 0; j < 9; j++) {
					if (puzzleLine[item][i][j] == -1) {
						grid = (puzzleLine[item][i][j] * -1) - 1;
						puzzleLine[item][i][j] = puzzleLine[grid][i + 6][j + 6];
						playerLine[item][i][j] = playerLine[grid][i + 6][j + 6];
					}
					if (puzzleLine[item][i][j] == -2) {
						grid = (puzzleLine[item][i][j] * -1) - 1;
						puzzleLine[item][i][j] = puzzleLine[grid][i + 6][j - 6];
						playerLine[item][i][j] = playerLine[grid][i + 6][j - 6];
					}
					if (puzzleLine[item][i][j] == -4) {
						grid = (puzzleLine[item][i][j] * -1) - 1;
						puzzleLine[item][i][j] = puzzleLine[grid][i - 6][j + 6];
						playerLine[item][i][j] = playerLine[grid][i - 6][j + 6];
					}
					if (puzzleLine[item][i][j] == -5) {
						grid = (puzzleLine[item][i][j] * -1) - 1;
						puzzleLine[item][i][j] = puzzleLine[grid][i - 6][j - 6];
						playerLine[item][i][j] = playerLine[grid][i - 6][j - 6];
					}
				}
			}
			cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);

			// Superimpose the corner subgrids
			let tempDigits = [[], [], [], [], [], [], [], [], []];
			// Top left
			for (let i = 6; i < 9; i++) {
				for (let j = 6; j < 9; j++) {
					tempDigits[i][j] = [];
					allDigits.forEach((item) => {
						if (typeof cellDigitsArray[0][i][j] !== 'undefined' && cellDigitsArray[0][i][j].includes(item) && cellDigitsArray[2][i - 6][j - 6].includes(item)) {
							tempDigits[i][j].push(item);
						}
					});
				}
			}
			for (let i = 6; i < 9; i++) {
				for (let j = 6; j < 9; j++) {
					if (typeof tempDigits[i][j] !== 'undefined') {
						cellDigitsArray[0][i][j] = tempDigits[i][j];
					}
				}
			}

			// Top right
			tempDigits = [[], [], [], [], [], [], [], [], []];
			for (let i = 6; i < 9; i++) {
				for (let j = 0; j < 3; j++) {
					tempDigits[i][j] = [];
					allDigits.forEach((item) => {
						if (typeof cellDigitsArray[1][i][j] !== 'undefined' && cellDigitsArray[1][i][j].includes(item) && cellDigitsArray[2][i - 6][j + 6].includes(item)) {
							tempDigits[i][j].push(item);
						}
					});
				}
			}
			for (let i = 6; i < 9; i++) {
				for (let j = 0; j < 3; j++) {
					if (typeof tempDigits[i][j] !== 'undefined') {
						cellDigitsArray[1][i][j] = tempDigits[i][j];
					}
				}
			}

			// Bottom left
			tempDigits = [[], [], [], [], [], [], [], [], []];
			for (let i = 0; i < 3; i++) {
				for (let j = 6; j < 9; j++) {
					tempDigits[i][j] = [];
					allDigits.forEach((item) => {
						if (typeof cellDigitsArray[3][i][j] !== 'undefined' && cellDigitsArray[3][i][j].includes(item) && cellDigitsArray[2][i + 6][j - 6].includes(item)) {
							tempDigits[i][j].push(item);
						}
					});
				}
			}
			for (let i = 0; i < 3; i++) {
				for (let j = 6; j < 9; j++) {
					if (typeof tempDigits[i][j] !== 'undefined') {
						cellDigitsArray[3][i][j] = tempDigits[i][j];
					}
				}
			}

			// Bottom right
			tempDigits = [[], [], [], [], [], [], [], [], []];
			for (let i = 0; i < 3; i++) {
				for (let j = 0; j < 3; j++) {
					tempDigits[i][j] = [];
					allDigits.forEach((item) => {
						if (typeof cellDigitsArray[4][i][j] !== 'undefined' && cellDigitsArray[4][i][j].includes(item) && cellDigitsArray[2][i + 6][j + 6].includes(item)) {
							tempDigits[i][j].push(item);
						}
					});
				}
			}
			for (let i = 0; i < 3; i++) {
				for (let j = 0; j < 3; j++) {
					if (typeof tempDigits[i][j] !== 'undefined') {
						cellDigitsArray[4][i][j] = tempDigits[i][j];
					}
				}
			}
		}
	});

	gridSequence.forEach((item) => {
		for (let i = 0; i < 9; i++) {
			for (let j = 0; j < 9; j++) {
				if (typeof cellDigitsArray[item][i][j] !== 'undefined' && cellDigitsArray[item][i][j] != '') {
					// Set the style
					$("#mot_sudoku_s_cell_id_" + (item + 1) + "_" + (i + 1) + (j + 1)).css({"font-size": fontSizeSmall, "font-weight": fontWeightNormal, "color": textColorPlayer, "text-align": textAlignLeft, "vertical-align": verticalAlignTop});
					$("#mot_sudoku_s_cell_id_" + (item + 1) + "_" + (i + 1) + (j + 1)).html(cellDigitsArray[item][i][j].join(', '));
				}
			}
		}
	});
}

motSudoku.samuraiHelperMask = function() {
	for (let g = 0; g < 5; g++) {
		for (let x = 0; x < 9; x++) {
			for (let y = 0; y < 9; y++) {
				if ((this.puzzleLine[g][x][y] == 0) && (this.playerLineS[g][x][y] == 0)) {
					$("#mot_sudoku_s_cell_id_" + (g + 1) + "_" + (x + 1) + (y + 1)).html('');
				}
			}
		}
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
