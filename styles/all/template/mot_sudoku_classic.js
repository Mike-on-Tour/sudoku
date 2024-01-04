/**
*
* @package MoT Sudoku v0.2.0
* @copyright (c) 2023 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

var motSudokuCellId = '';

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
		let rowNumber = thisElementId.substr(22, 1);
		let offsetX = rowNumber * 32;
		motSudokuCellId = thisElementId;
		$("#mot_sudoku_modal_content").css({top: e.clientY - 50, left: e.clientX - offsetX, position: 'relative'});
		$("#mot_sudoku_modal").show();
	}
});

$("#mot_sudoku_modal_1, #mot_sudoku_modal_2, #mot_sudoku_modal_3, #mot_sudoku_modal_4, #mot_sudoku_modal_5, #mot_sudoku_modal_6, #mot_sudoku_modal_7, #mot_sudoku_modal_8, #mot_sudoku_modal_9").on("click", function() {
	let thisElementId = $(this).attr('id');
	let number = thisElementId.substr(17, 1);
	$("#" + motSudokuCellId).css({"font-weight": "normal", "color": "blue"});
	$("#" + motSudokuCellId).html(number);
	$("#mot_sudoku_modal").hide();
});

$("#mot_sudoku_modal_0").on("click", function() {
	let thisElementId = $(this).attr('id');
	let number = thisElementId.substr(17, 1);
	$("#" + motSudokuCellId).html('');
	$("#mot_sudoku_modal").hide();
});

$("#mot_sudoku_modal").on("click", function() {
	$(this).hide();
});

})(jQuery); // Avoid conflicts with other libraries
