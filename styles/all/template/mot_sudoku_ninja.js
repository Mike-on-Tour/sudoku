/**
*
* @package MoT Sudoku v0.5.0
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
if (motSudoku.playerLineN != null) {
	// Get the css variables, we do this here once since it is the same for all cells and thus improves performance
	let fontWeightNormal = $("#mot_sudoku_n_cell_id_1_11").css('--fontWeightNormal');
	let textColorPlayer = $("#mot_sudoku_n_cell_id_1_11").css('--textColorPlayer');

	for (let g = 0; g < 9; g++) {
		for (let i = 0; i < 9; i++) {
			for (let j = 0; j < 9; j++) {
				if (motSudoku.playerLineN[g][i][j] > 0) {
					$("#mot_sudoku_n_cell_id_" + (g + 1) + "_" + (i +1) + (j + 1)).css({"font-weight": fontWeightNormal, "color": textColorPlayer});
					$("#mot_sudoku_n_cell_id_" + (g + 1) + "_" + (i +1) + (j + 1)).html(motSudoku.playerLineN[g][i][j]);
				}
			}
		}
	}
}

/*
* Add the highlighting of the selected cell and opening of the modal window to the Ninja Sudoku game's cells
*
*/
$(
"#mot_sudoku_n_cell_id_6_11, #mot_sudoku_n_cell_id_6_12, #mot_sudoku_n_cell_id_6_13, #mot_sudoku_n_cell_id_6_14, #mot_sudoku_n_cell_id_6_15, #mot_sudoku_n_cell_id_6_16, #mot_sudoku_n_cell_id_6_17, #mot_sudoku_n_cell_id_6_18, #mot_sudoku_n_cell_id_6_19, " +
"#mot_sudoku_n_cell_id_6_21, #mot_sudoku_n_cell_id_6_22, #mot_sudoku_n_cell_id_6_23, #mot_sudoku_n_cell_id_6_24, #mot_sudoku_n_cell_id_6_25, #mot_sudoku_n_cell_id_6_26, #mot_sudoku_n_cell_id_6_27, #mot_sudoku_n_cell_id_6_28, #mot_sudoku_n_cell_id_6_29, " +
"#mot_sudoku_n_cell_id_6_31, #mot_sudoku_n_cell_id_6_32, #mot_sudoku_n_cell_id_6_33, #mot_sudoku_n_cell_id_6_34, #mot_sudoku_n_cell_id_6_35, #mot_sudoku_n_cell_id_6_36, #mot_sudoku_n_cell_id_6_37, #mot_sudoku_n_cell_id_6_38, #mot_sudoku_n_cell_id_6_39, " +
"#mot_sudoku_n_cell_id_6_41, #mot_sudoku_n_cell_id_6_42, #mot_sudoku_n_cell_id_6_43, #mot_sudoku_n_cell_id_6_44, #mot_sudoku_n_cell_id_6_45, #mot_sudoku_n_cell_id_6_46, #mot_sudoku_n_cell_id_6_47, #mot_sudoku_n_cell_id_6_48, #mot_sudoku_n_cell_id_6_49, " +
"#mot_sudoku_n_cell_id_6_51, #mot_sudoku_n_cell_id_6_52, #mot_sudoku_n_cell_id_6_53, #mot_sudoku_n_cell_id_6_54, #mot_sudoku_n_cell_id_6_55, #mot_sudoku_n_cell_id_6_56, #mot_sudoku_n_cell_id_6_57, #mot_sudoku_n_cell_id_6_58, #mot_sudoku_n_cell_id_6_59, " +
"#mot_sudoku_n_cell_id_6_61, #mot_sudoku_n_cell_id_6_62, #mot_sudoku_n_cell_id_6_63, #mot_sudoku_n_cell_id_6_64, #mot_sudoku_n_cell_id_6_65, #mot_sudoku_n_cell_id_6_66, #mot_sudoku_n_cell_id_6_67, #mot_sudoku_n_cell_id_6_68, #mot_sudoku_n_cell_id_6_69, " +
"#mot_sudoku_n_cell_id_6_74, #mot_sudoku_n_cell_id_6_75, #mot_sudoku_n_cell_id_6_76, " +
"#mot_sudoku_n_cell_id_6_84, #mot_sudoku_n_cell_id_6_85, #mot_sudoku_n_cell_id_6_86, " +
"#mot_sudoku_n_cell_id_6_94, #mot_sudoku_n_cell_id_6_95, #mot_sudoku_n_cell_id_6_96, " +

"#mot_sudoku_n_cell_id_1_11, #mot_sudoku_n_cell_id_1_12, #mot_sudoku_n_cell_id_1_13, #mot_sudoku_n_cell_id_1_14, #mot_sudoku_n_cell_id_1_15, #mot_sudoku_n_cell_id_1_16, #mot_sudoku_n_cell_id_1_17, #mot_sudoku_n_cell_id_1_18, #mot_sudoku_n_cell_id_1_19, " +
"#mot_sudoku_n_cell_id_1_21, #mot_sudoku_n_cell_id_1_22, #mot_sudoku_n_cell_id_1_23, #mot_sudoku_n_cell_id_1_24, #mot_sudoku_n_cell_id_1_25, #mot_sudoku_n_cell_id_1_26, #mot_sudoku_n_cell_id_1_27, #mot_sudoku_n_cell_id_1_28, #mot_sudoku_n_cell_id_1_29, " +
"#mot_sudoku_n_cell_id_1_31, #mot_sudoku_n_cell_id_1_32, #mot_sudoku_n_cell_id_1_33, #mot_sudoku_n_cell_id_1_34, #mot_sudoku_n_cell_id_1_35, #mot_sudoku_n_cell_id_1_36, #mot_sudoku_n_cell_id_1_37, #mot_sudoku_n_cell_id_1_38, #mot_sudoku_n_cell_id_1_39, " +
"#mot_sudoku_n_cell_id_1_41, #mot_sudoku_n_cell_id_1_42, #mot_sudoku_n_cell_id_1_43, #mot_sudoku_n_cell_id_1_44, #mot_sudoku_n_cell_id_1_45, #mot_sudoku_n_cell_id_1_46, #mot_sudoku_n_cell_id_1_47, #mot_sudoku_n_cell_id_1_48, #mot_sudoku_n_cell_id_1_49, " +
"#mot_sudoku_n_cell_id_1_51, #mot_sudoku_n_cell_id_1_52, #mot_sudoku_n_cell_id_1_53, #mot_sudoku_n_cell_id_1_54, #mot_sudoku_n_cell_id_1_55, #mot_sudoku_n_cell_id_1_56, #mot_sudoku_n_cell_id_1_57, #mot_sudoku_n_cell_id_1_58, #mot_sudoku_n_cell_id_1_59, " +
"#mot_sudoku_n_cell_id_1_61, #mot_sudoku_n_cell_id_1_62, #mot_sudoku_n_cell_id_1_63, #mot_sudoku_n_cell_id_1_64, #mot_sudoku_n_cell_id_1_65, #mot_sudoku_n_cell_id_1_66, #mot_sudoku_n_cell_id_1_67, #mot_sudoku_n_cell_id_1_68, #mot_sudoku_n_cell_id_1_69, " +
"#mot_sudoku_n_cell_id_1_71, #mot_sudoku_n_cell_id_1_72, #mot_sudoku_n_cell_id_1_73, #mot_sudoku_n_cell_id_1_74, #mot_sudoku_n_cell_id_1_75, #mot_sudoku_n_cell_id_1_76, #mot_sudoku_n_cell_id_1_77, #mot_sudoku_n_cell_id_1_78, #mot_sudoku_n_cell_id_1_79, " +
"#mot_sudoku_n_cell_id_1_81, #mot_sudoku_n_cell_id_1_82, #mot_sudoku_n_cell_id_1_83, #mot_sudoku_n_cell_id_1_84, #mot_sudoku_n_cell_id_1_85, #mot_sudoku_n_cell_id_1_86, #mot_sudoku_n_cell_id_1_87, #mot_sudoku_n_cell_id_1_88, #mot_sudoku_n_cell_id_1_89, " +
"#mot_sudoku_n_cell_id_1_91, #mot_sudoku_n_cell_id_1_92, #mot_sudoku_n_cell_id_1_93, #mot_sudoku_n_cell_id_1_94, #mot_sudoku_n_cell_id_1_95, #mot_sudoku_n_cell_id_1_96, #mot_sudoku_n_cell_id_1_97, #mot_sudoku_n_cell_id_1_98, #mot_sudoku_n_cell_id_1_99, " +

"#mot_sudoku_n_cell_id_2_11, #mot_sudoku_n_cell_id_2_12, #mot_sudoku_n_cell_id_2_13, #mot_sudoku_n_cell_id_2_14, #mot_sudoku_n_cell_id_2_15, #mot_sudoku_n_cell_id_2_16, #mot_sudoku_n_cell_id_2_17, #mot_sudoku_n_cell_id_2_18, #mot_sudoku_n_cell_id_2_19, " +
"#mot_sudoku_n_cell_id_2_21, #mot_sudoku_n_cell_id_2_22, #mot_sudoku_n_cell_id_2_23, #mot_sudoku_n_cell_id_2_24, #mot_sudoku_n_cell_id_2_25, #mot_sudoku_n_cell_id_2_26, #mot_sudoku_n_cell_id_2_27, #mot_sudoku_n_cell_id_2_28, #mot_sudoku_n_cell_id_2_29, " +
"#mot_sudoku_n_cell_id_2_31, #mot_sudoku_n_cell_id_2_32, #mot_sudoku_n_cell_id_2_33, #mot_sudoku_n_cell_id_2_34, #mot_sudoku_n_cell_id_2_35, #mot_sudoku_n_cell_id_2_36, #mot_sudoku_n_cell_id_2_37, #mot_sudoku_n_cell_id_2_38, #mot_sudoku_n_cell_id_2_39, " +
"#mot_sudoku_n_cell_id_2_41, #mot_sudoku_n_cell_id_2_42, #mot_sudoku_n_cell_id_2_43, #mot_sudoku_n_cell_id_2_44, #mot_sudoku_n_cell_id_2_45, #mot_sudoku_n_cell_id_2_46, #mot_sudoku_n_cell_id_2_47, #mot_sudoku_n_cell_id_2_48, #mot_sudoku_n_cell_id_2_49, " +
"#mot_sudoku_n_cell_id_2_51, #mot_sudoku_n_cell_id_2_52, #mot_sudoku_n_cell_id_2_53, #mot_sudoku_n_cell_id_2_54, #mot_sudoku_n_cell_id_2_55, #mot_sudoku_n_cell_id_2_56, #mot_sudoku_n_cell_id_2_57, #mot_sudoku_n_cell_id_2_58, #mot_sudoku_n_cell_id_2_59, " +
"#mot_sudoku_n_cell_id_2_61, #mot_sudoku_n_cell_id_2_62, #mot_sudoku_n_cell_id_2_63, #mot_sudoku_n_cell_id_2_64, #mot_sudoku_n_cell_id_2_65, #mot_sudoku_n_cell_id_2_66, #mot_sudoku_n_cell_id_2_67, #mot_sudoku_n_cell_id_2_68, #mot_sudoku_n_cell_id_2_69, " +
"#mot_sudoku_n_cell_id_2_71, #mot_sudoku_n_cell_id_2_72, #mot_sudoku_n_cell_id_2_73, #mot_sudoku_n_cell_id_2_74, #mot_sudoku_n_cell_id_2_75, #mot_sudoku_n_cell_id_2_76, #mot_sudoku_n_cell_id_2_77, #mot_sudoku_n_cell_id_2_78, #mot_sudoku_n_cell_id_2_79, " +
"#mot_sudoku_n_cell_id_2_81, #mot_sudoku_n_cell_id_2_82, #mot_sudoku_n_cell_id_2_83, #mot_sudoku_n_cell_id_2_84, #mot_sudoku_n_cell_id_2_85, #mot_sudoku_n_cell_id_2_86, #mot_sudoku_n_cell_id_2_87, #mot_sudoku_n_cell_id_2_88, #mot_sudoku_n_cell_id_2_89, " +
"#mot_sudoku_n_cell_id_2_91, #mot_sudoku_n_cell_id_2_92, #mot_sudoku_n_cell_id_2_93, #mot_sudoku_n_cell_id_2_94, #mot_sudoku_n_cell_id_2_95, #mot_sudoku_n_cell_id_2_96, #mot_sudoku_n_cell_id_2_97, #mot_sudoku_n_cell_id_2_98, #mot_sudoku_n_cell_id_2_99, " +

"#mot_sudoku_n_cell_id_7_11, #mot_sudoku_n_cell_id_7_12, #mot_sudoku_n_cell_id_7_13, #mot_sudoku_n_cell_id_7_14, #mot_sudoku_n_cell_id_7_15, #mot_sudoku_n_cell_id_7_16, " +
"#mot_sudoku_n_cell_id_7_21, #mot_sudoku_n_cell_id_7_22, #mot_sudoku_n_cell_id_7_23, #mot_sudoku_n_cell_id_7_24, #mot_sudoku_n_cell_id_7_25, #mot_sudoku_n_cell_id_7_26, " +
"#mot_sudoku_n_cell_id_7_31, #mot_sudoku_n_cell_id_7_32, #mot_sudoku_n_cell_id_7_33, #mot_sudoku_n_cell_id_7_34, #mot_sudoku_n_cell_id_7_35, #mot_sudoku_n_cell_id_7_36, " +
"#mot_sudoku_n_cell_id_7_41, #mot_sudoku_n_cell_id_7_42, #mot_sudoku_n_cell_id_7_43, #mot_sudoku_n_cell_id_7_44, #mot_sudoku_n_cell_id_7_45, #mot_sudoku_n_cell_id_7_46, #mot_sudoku_n_cell_id_7_47, #mot_sudoku_n_cell_id_7_48, #mot_sudoku_n_cell_id_7_49, " +
"#mot_sudoku_n_cell_id_7_51, #mot_sudoku_n_cell_id_7_52, #mot_sudoku_n_cell_id_7_53, #mot_sudoku_n_cell_id_7_54, #mot_sudoku_n_cell_id_7_55, #mot_sudoku_n_cell_id_7_56, #mot_sudoku_n_cell_id_7_57, #mot_sudoku_n_cell_id_7_58, #mot_sudoku_n_cell_id_7_59, " +
"#mot_sudoku_n_cell_id_7_61, #mot_sudoku_n_cell_id_7_62, #mot_sudoku_n_cell_id_7_63, #mot_sudoku_n_cell_id_7_64, #mot_sudoku_n_cell_id_7_65, #mot_sudoku_n_cell_id_7_66, #mot_sudoku_n_cell_id_7_67, #mot_sudoku_n_cell_id_7_68, #mot_sudoku_n_cell_id_7_69, " +
"#mot_sudoku_n_cell_id_7_71, #mot_sudoku_n_cell_id_7_72, #mot_sudoku_n_cell_id_7_73, #mot_sudoku_n_cell_id_7_74, #mot_sudoku_n_cell_id_7_75, #mot_sudoku_n_cell_id_7_76, " +
"#mot_sudoku_n_cell_id_7_81, #mot_sudoku_n_cell_id_7_82, #mot_sudoku_n_cell_id_7_83, #mot_sudoku_n_cell_id_7_84, #mot_sudoku_n_cell_id_7_85, #mot_sudoku_n_cell_id_7_86, " +
"#mot_sudoku_n_cell_id_7_91, #mot_sudoku_n_cell_id_7_92, #mot_sudoku_n_cell_id_7_93, #mot_sudoku_n_cell_id_7_94, #mot_sudoku_n_cell_id_7_95, #mot_sudoku_n_cell_id_7_96, " +

"#mot_sudoku_n_cell_id_3_14, #mot_sudoku_n_cell_id_3_15, #mot_sudoku_n_cell_id_3_16, " +
"#mot_sudoku_n_cell_id_3_24, #mot_sudoku_n_cell_id_3_25, #mot_sudoku_n_cell_id_3_26, " +
"#mot_sudoku_n_cell_id_3_34, #mot_sudoku_n_cell_id_3_35, #mot_sudoku_n_cell_id_3_36, " +
"#mot_sudoku_n_cell_id_3_41, #mot_sudoku_n_cell_id_3_42, #mot_sudoku_n_cell_id_3_43, #mot_sudoku_n_cell_id_3_44, #mot_sudoku_n_cell_id_3_45, #mot_sudoku_n_cell_id_3_46, #mot_sudoku_n_cell_id_3_47, #mot_sudoku_n_cell_id_3_48, #mot_sudoku_n_cell_id_3_49, " +
"#mot_sudoku_n_cell_id_3_51, #mot_sudoku_n_cell_id_3_52, #mot_sudoku_n_cell_id_3_53, #mot_sudoku_n_cell_id_3_54, #mot_sudoku_n_cell_id_3_55, #mot_sudoku_n_cell_id_3_56, #mot_sudoku_n_cell_id_3_57, #mot_sudoku_n_cell_id_3_58, #mot_sudoku_n_cell_id_3_59, " +
"#mot_sudoku_n_cell_id_3_61, #mot_sudoku_n_cell_id_3_62, #mot_sudoku_n_cell_id_3_63, #mot_sudoku_n_cell_id_3_64, #mot_sudoku_n_cell_id_3_65, #mot_sudoku_n_cell_id_3_66, #mot_sudoku_n_cell_id_3_67, #mot_sudoku_n_cell_id_3_68, #mot_sudoku_n_cell_id_3_69, " +
"#mot_sudoku_n_cell_id_3_74, #mot_sudoku_n_cell_id_3_75, #mot_sudoku_n_cell_id_3_76, " +
"#mot_sudoku_n_cell_id_3_84, #mot_sudoku_n_cell_id_3_85, #mot_sudoku_n_cell_id_3_86, " +
"#mot_sudoku_n_cell_id_3_94, #mot_sudoku_n_cell_id_3_95, #mot_sudoku_n_cell_id_3_96, " +

"#mot_sudoku_n_cell_id_8_14, #mot_sudoku_n_cell_id_8_15, #mot_sudoku_n_cell_id_8_16, #mot_sudoku_n_cell_id_8_17, #mot_sudoku_n_cell_id_8_18, #mot_sudoku_n_cell_id_8_19, " +
"#mot_sudoku_n_cell_id_8_24, #mot_sudoku_n_cell_id_8_25, #mot_sudoku_n_cell_id_8_26, #mot_sudoku_n_cell_id_8_27, #mot_sudoku_n_cell_id_8_28, #mot_sudoku_n_cell_id_8_29, " +
"#mot_sudoku_n_cell_id_8_34, #mot_sudoku_n_cell_id_8_35, #mot_sudoku_n_cell_id_8_36, #mot_sudoku_n_cell_id_8_37, #mot_sudoku_n_cell_id_8_38, #mot_sudoku_n_cell_id_8_39, " +
"#mot_sudoku_n_cell_id_8_41, #mot_sudoku_n_cell_id_8_42, #mot_sudoku_n_cell_id_8_43, #mot_sudoku_n_cell_id_8_44, #mot_sudoku_n_cell_id_8_45, #mot_sudoku_n_cell_id_8_46, #mot_sudoku_n_cell_id_8_47, #mot_sudoku_n_cell_id_8_48, #mot_sudoku_n_cell_id_8_49, " +
"#mot_sudoku_n_cell_id_8_51, #mot_sudoku_n_cell_id_8_52, #mot_sudoku_n_cell_id_8_53, #mot_sudoku_n_cell_id_8_54, #mot_sudoku_n_cell_id_8_55, #mot_sudoku_n_cell_id_8_56, #mot_sudoku_n_cell_id_8_57, #mot_sudoku_n_cell_id_8_58, #mot_sudoku_n_cell_id_8_59, " +
"#mot_sudoku_n_cell_id_8_61, #mot_sudoku_n_cell_id_8_62, #mot_sudoku_n_cell_id_8_63, #mot_sudoku_n_cell_id_8_64, #mot_sudoku_n_cell_id_8_65, #mot_sudoku_n_cell_id_8_66, #mot_sudoku_n_cell_id_8_67, #mot_sudoku_n_cell_id_8_68, #mot_sudoku_n_cell_id_8_69, " +
"#mot_sudoku_n_cell_id_8_74, #mot_sudoku_n_cell_id_8_75, #mot_sudoku_n_cell_id_8_76, #mot_sudoku_n_cell_id_8_77, #mot_sudoku_n_cell_id_8_78, #mot_sudoku_n_cell_id_8_79, " +
"#mot_sudoku_n_cell_id_8_84, #mot_sudoku_n_cell_id_8_85, #mot_sudoku_n_cell_id_8_86, #mot_sudoku_n_cell_id_8_87, #mot_sudoku_n_cell_id_8_88, #mot_sudoku_n_cell_id_8_89, " +
"#mot_sudoku_n_cell_id_8_94, #mot_sudoku_n_cell_id_8_95, #mot_sudoku_n_cell_id_8_96, #mot_sudoku_n_cell_id_8_97, #mot_sudoku_n_cell_id_8_98, #mot_sudoku_n_cell_id_8_99, " +

"#mot_sudoku_n_cell_id_4_11, #mot_sudoku_n_cell_id_4_12, #mot_sudoku_n_cell_id_4_13, #mot_sudoku_n_cell_id_4_14, #mot_sudoku_n_cell_id_4_15, #mot_sudoku_n_cell_id_4_16, #mot_sudoku_n_cell_id_4_17, #mot_sudoku_n_cell_id_4_18, #mot_sudoku_n_cell_id_4_19, " +
"#mot_sudoku_n_cell_id_4_21, #mot_sudoku_n_cell_id_4_22, #mot_sudoku_n_cell_id_4_23, #mot_sudoku_n_cell_id_4_24, #mot_sudoku_n_cell_id_4_25, #mot_sudoku_n_cell_id_4_26, #mot_sudoku_n_cell_id_4_27, #mot_sudoku_n_cell_id_4_28, #mot_sudoku_n_cell_id_4_29, " +
"#mot_sudoku_n_cell_id_4_31, #mot_sudoku_n_cell_id_4_32, #mot_sudoku_n_cell_id_4_33, #mot_sudoku_n_cell_id_4_34, #mot_sudoku_n_cell_id_4_35, #mot_sudoku_n_cell_id_4_36, #mot_sudoku_n_cell_id_4_37, #mot_sudoku_n_cell_id_4_38, #mot_sudoku_n_cell_id_4_39, " +
"#mot_sudoku_n_cell_id_4_41, #mot_sudoku_n_cell_id_4_42, #mot_sudoku_n_cell_id_4_43, #mot_sudoku_n_cell_id_4_44, #mot_sudoku_n_cell_id_4_45, #mot_sudoku_n_cell_id_4_46, #mot_sudoku_n_cell_id_4_47, #mot_sudoku_n_cell_id_4_48, #mot_sudoku_n_cell_id_4_49, " +
"#mot_sudoku_n_cell_id_4_51, #mot_sudoku_n_cell_id_4_52, #mot_sudoku_n_cell_id_4_53, #mot_sudoku_n_cell_id_4_54, #mot_sudoku_n_cell_id_4_55, #mot_sudoku_n_cell_id_4_56, #mot_sudoku_n_cell_id_4_57, #mot_sudoku_n_cell_id_4_58, #mot_sudoku_n_cell_id_4_59, " +
"#mot_sudoku_n_cell_id_4_61, #mot_sudoku_n_cell_id_4_62, #mot_sudoku_n_cell_id_4_63, #mot_sudoku_n_cell_id_4_64, #mot_sudoku_n_cell_id_4_65, #mot_sudoku_n_cell_id_4_66, #mot_sudoku_n_cell_id_4_67, #mot_sudoku_n_cell_id_4_68, #mot_sudoku_n_cell_id_4_69, " +
"#mot_sudoku_n_cell_id_4_71, #mot_sudoku_n_cell_id_4_72, #mot_sudoku_n_cell_id_4_73, #mot_sudoku_n_cell_id_4_74, #mot_sudoku_n_cell_id_4_75, #mot_sudoku_n_cell_id_4_76, #mot_sudoku_n_cell_id_4_77, #mot_sudoku_n_cell_id_4_78, #mot_sudoku_n_cell_id_4_79, " +
"#mot_sudoku_n_cell_id_4_81, #mot_sudoku_n_cell_id_4_82, #mot_sudoku_n_cell_id_4_83, #mot_sudoku_n_cell_id_4_84, #mot_sudoku_n_cell_id_4_85, #mot_sudoku_n_cell_id_4_86, #mot_sudoku_n_cell_id_4_87, #mot_sudoku_n_cell_id_4_88, #mot_sudoku_n_cell_id_4_89, " +
"#mot_sudoku_n_cell_id_4_91, #mot_sudoku_n_cell_id_4_92, #mot_sudoku_n_cell_id_4_93, #mot_sudoku_n_cell_id_4_94, #mot_sudoku_n_cell_id_4_95, #mot_sudoku_n_cell_id_4_96, #mot_sudoku_n_cell_id_4_97, #mot_sudoku_n_cell_id_4_98, #mot_sudoku_n_cell_id_4_99, " +

"#mot_sudoku_n_cell_id_5_11, #mot_sudoku_n_cell_id_5_12, #mot_sudoku_n_cell_id_5_13, #mot_sudoku_n_cell_id_5_14, #mot_sudoku_n_cell_id_5_15, #mot_sudoku_n_cell_id_5_16, #mot_sudoku_n_cell_id_5_17, #mot_sudoku_n_cell_id_5_18, #mot_sudoku_n_cell_id_5_19, " +
"#mot_sudoku_n_cell_id_5_21, #mot_sudoku_n_cell_id_5_22, #mot_sudoku_n_cell_id_5_23, #mot_sudoku_n_cell_id_5_24, #mot_sudoku_n_cell_id_5_25, #mot_sudoku_n_cell_id_5_26, #mot_sudoku_n_cell_id_5_27, #mot_sudoku_n_cell_id_5_28, #mot_sudoku_n_cell_id_5_29, " +
"#mot_sudoku_n_cell_id_5_31, #mot_sudoku_n_cell_id_5_32, #mot_sudoku_n_cell_id_5_33, #mot_sudoku_n_cell_id_5_34, #mot_sudoku_n_cell_id_5_35, #mot_sudoku_n_cell_id_5_36, #mot_sudoku_n_cell_id_5_37, #mot_sudoku_n_cell_id_5_38, #mot_sudoku_n_cell_id_5_39, " +
"#mot_sudoku_n_cell_id_5_41, #mot_sudoku_n_cell_id_5_42, #mot_sudoku_n_cell_id_5_43, #mot_sudoku_n_cell_id_5_44, #mot_sudoku_n_cell_id_5_45, #mot_sudoku_n_cell_id_5_46, #mot_sudoku_n_cell_id_5_47, #mot_sudoku_n_cell_id_5_48, #mot_sudoku_n_cell_id_5_49, " +
"#mot_sudoku_n_cell_id_5_51, #mot_sudoku_n_cell_id_5_52, #mot_sudoku_n_cell_id_5_53, #mot_sudoku_n_cell_id_5_54, #mot_sudoku_n_cell_id_5_55, #mot_sudoku_n_cell_id_5_56, #mot_sudoku_n_cell_id_5_57, #mot_sudoku_n_cell_id_5_58, #mot_sudoku_n_cell_id_5_59, " +
"#mot_sudoku_n_cell_id_5_61, #mot_sudoku_n_cell_id_5_62, #mot_sudoku_n_cell_id_5_63, #mot_sudoku_n_cell_id_5_64, #mot_sudoku_n_cell_id_5_65, #mot_sudoku_n_cell_id_5_66, #mot_sudoku_n_cell_id_5_67, #mot_sudoku_n_cell_id_5_68, #mot_sudoku_n_cell_id_5_69, " +
"#mot_sudoku_n_cell_id_5_71, #mot_sudoku_n_cell_id_5_72, #mot_sudoku_n_cell_id_5_73, #mot_sudoku_n_cell_id_5_74, #mot_sudoku_n_cell_id_5_75, #mot_sudoku_n_cell_id_5_76, #mot_sudoku_n_cell_id_5_77, #mot_sudoku_n_cell_id_5_78, #mot_sudoku_n_cell_id_5_79, " +
"#mot_sudoku_n_cell_id_5_81, #mot_sudoku_n_cell_id_5_82, #mot_sudoku_n_cell_id_5_83, #mot_sudoku_n_cell_id_5_84, #mot_sudoku_n_cell_id_5_85, #mot_sudoku_n_cell_id_5_86, #mot_sudoku_n_cell_id_5_87, #mot_sudoku_n_cell_id_5_88, #mot_sudoku_n_cell_id_5_89, " +
"#mot_sudoku_n_cell_id_5_91, #mot_sudoku_n_cell_id_5_92, #mot_sudoku_n_cell_id_5_93, #mot_sudoku_n_cell_id_5_94, #mot_sudoku_n_cell_id_5_95, #mot_sudoku_n_cell_id_5_96, #mot_sudoku_n_cell_id_5_97, #mot_sudoku_n_cell_id_5_98, #mot_sudoku_n_cell_id_5_99, " +

"#mot_sudoku_n_cell_id_9_14, #mot_sudoku_n_cell_id_9_15, #mot_sudoku_n_cell_id_9_16, " +
"#mot_sudoku_n_cell_id_9_24, #mot_sudoku_n_cell_id_9_25, #mot_sudoku_n_cell_id_9_26, " +
"#mot_sudoku_n_cell_id_9_34, #mot_sudoku_n_cell_id_9_35, #mot_sudoku_n_cell_id_9_36, " +
"#mot_sudoku_n_cell_id_9_41, #mot_sudoku_n_cell_id_9_42, #mot_sudoku_n_cell_id_9_43, #mot_sudoku_n_cell_id_9_44, #mot_sudoku_n_cell_id_9_45, #mot_sudoku_n_cell_id_9_46, #mot_sudoku_n_cell_id_9_47, #mot_sudoku_n_cell_id_9_48, #mot_sudoku_n_cell_id_9_49, " +
"#mot_sudoku_n_cell_id_9_51, #mot_sudoku_n_cell_id_9_52, #mot_sudoku_n_cell_id_9_53, #mot_sudoku_n_cell_id_9_54, #mot_sudoku_n_cell_id_9_55, #mot_sudoku_n_cell_id_9_56, #mot_sudoku_n_cell_id_9_57, #mot_sudoku_n_cell_id_9_58, #mot_sudoku_n_cell_id_9_59, " +
"#mot_sudoku_n_cell_id_9_61, #mot_sudoku_n_cell_id_9_62, #mot_sudoku_n_cell_id_9_63, #mot_sudoku_n_cell_id_9_64, #mot_sudoku_n_cell_id_9_65, #mot_sudoku_n_cell_id_9_66, #mot_sudoku_n_cell_id_9_67, #mot_sudoku_n_cell_id_9_68, #mot_sudoku_n_cell_id_9_69, " +
"#mot_sudoku_n_cell_id_9_71, #mot_sudoku_n_cell_id_9_72, #mot_sudoku_n_cell_id_9_73, #mot_sudoku_n_cell_id_9_74, #mot_sudoku_n_cell_id_9_75, #mot_sudoku_n_cell_id_9_76, #mot_sudoku_n_cell_id_9_77, #mot_sudoku_n_cell_id_9_78, #mot_sudoku_n_cell_id_9_79, " +
"#mot_sudoku_n_cell_id_9_81, #mot_sudoku_n_cell_id_9_82, #mot_sudoku_n_cell_id_9_83, #mot_sudoku_n_cell_id_9_84, #mot_sudoku_n_cell_id_9_85, #mot_sudoku_n_cell_id_9_86, #mot_sudoku_n_cell_id_9_87, #mot_sudoku_n_cell_id_9_88, #mot_sudoku_n_cell_id_9_89, " +
"#mot_sudoku_n_cell_id_9_91, #mot_sudoku_n_cell_id_9_92, #mot_sudoku_n_cell_id_9_93, #mot_sudoku_n_cell_id_9_94, #mot_sudoku_n_cell_id_9_95, #mot_sudoku_n_cell_id_9_96, #mot_sudoku_n_cell_id_9_97, #mot_sudoku_n_cell_id_9_98, #mot_sudoku_n_cell_id_9_99"
).on("click", function(e) {
	if (motSudoku.preSelectedCells.indexOf($(this).attr('id')) == -1) {
		let thisElementId = $(this).attr('id');
		let gridNumber = thisElementId.substr(21, 1);
		let lineNumber = thisElementId.substr(23, 1);
		let columnNumber = thisElementId.substr(24, 1);
		let offsetX = 0;
		let offsetY = 0;

		if ($(window).width() >= motSudoku.screenWidth) {
			offsetX = (columnNumber * 40) - 0;//(10/columnNumber);
			if (motSudoku.modalSwitch) {
				offsetY = motSudoku.normalOffsetY;
			} else {
				offsetY = (lineNumber * 32) + motSudoku.normalOffsetYAbove;
			}
		} else {
			offsetX = columnNumber * 20;
			if (motSudoku.modalSwitch) {
				offsetY = motSudoku.smallOffsetY;
			} else {
				offsetY = (lineNumber * 25) + motSudoku.smallOffsetYAbove;
			}
		}

		motSudoku.CellId = thisElementId;
		let xStart = e.clientX - offsetX > 30 ? e.clientX - offsetX : 36;
		motSudoku.backgroundColour = $(this).css('background-color');
		let backgroundColour = $(this).css('--backgroundColorActive');
		$(this).css('background-color', backgroundColour);
		$("#mot_sudoku_modal_content").css({top: e.clientY - offsetY, left: xStart, position: 'relative'});
		$("#mot_sudoku_modal").show();
	}
});

/*
* Reset the Ninja grid to the content of puzzle
*
* param	puzzle	array		an array holding nine 9 * 9 arrays with the content to be written into the cells
*/
motSudoku.resetNinja = function(puzzle) {
	let systemColor = $(".panel").css('color');
	for (let g = 0; g < 9; g++) {
		for (let i = 0; i < 9; i++) {
			for (let j = 0; j < 9; j++) {
				if (puzzle[g][i][j] > 0) {
					$("#mot_sudoku_n_cell_id_" + (g + 1) + "_" + (i + 1) + (j + 1)).html(puzzle[g][i][j]);
					$("#mot_sudoku_n_cell_id_" + (g + 1) + '_' + (i + 1) + (j + 1)).css('color', systemColor);
				} else {
					$("#mot_sudoku_n_cell_id_" + (g + 1) + '_' + (i + 1) + (j + 1)).html('');
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
motSudoku.ninjaHelper = function(puzzleLine, playerLine) {
	// Get the css variables
	let fontSizeSmall = $("#mot_sudoku_n_cell_id_1_11").css('--fontSizeSmall');
	let fontWeightNormal = $("#mot_sudoku_n_cell_id_1_11").css('--fontWeightNormal');
	let textColorPlayer = $("#mot_sudoku_n_cell_id_1_11").css('--textColorPlayer');
	let textAlignLeft = $("#mot_sudoku_n_cell_id_1_11").css('--textAlignLeft');
	let verticalAlignTop = $("#mot_sudoku_n_cell_id_1_11").css('--verticalAlignTop');

	let gridSequence = [0, 1, 3, 4, 2, 5, 6, 7, 8];
	let cellDigitsArray = [];
	let allDigits = [1, 2, 3, 4, 5, 6, 7, 8, 9];
	let tempDigits = [[], [], [], [], [], [], [], [], []];

	gridSequence.forEach((item) => {
		if ([2, 5, 6, 7, 8].indexOf(item) == -1) {
			// Handle the four full grids
			cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);
		} else {
			switch (item) {
				case 2:
					// Now we have to handle the center grid
					for (let i = 0; i < 9; i++) {
						for (let j = 0; j < 9; j++) {
							if (puzzleLine[item][i][j] == -19) {
								puzzleLine[item][i][j] = puzzleLine[0][i + 6][j + 6];
								playerLine[item][i][j] = playerLine[0][i + 6][j + 6];
							}
							if (puzzleLine[item][i][j] == -27) {
								puzzleLine[item][i][j] = puzzleLine[1][i + 6][j - 6];
								playerLine[item][i][j] = playerLine[1][i + 6][j - 6];
							}
							if (puzzleLine[item][i][j] == -43) {
								puzzleLine[item][i][j] = puzzleLine[3][i - 6][j + 6];
								playerLine[item][i][j] = playerLine[3][i - 6][j + 6];
							}
							if (puzzleLine[item][i][j] == -51) {
								puzzleLine[item][i][j] = puzzleLine[4][i - 6][j - 6];
								playerLine[item][i][j] = playerLine[4][i - 6][j - 6];
							}
						}
					}
					cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);

					// Superimpose the corner subgrids
					tempDigits = [[], [], [], [], [], [], [], [], []];
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
					break;

				case 5:
					// Now we have to handle the top grid
					for (let i = 0; i < 9; i++) {
						for (let j = 0; j < 9; j++) {
							if (puzzleLine[item][i][j] == -13) {
								puzzleLine[item][i][j] = puzzleLine[0][i - 6][j + 6];
								playerLine[item][i][j] = playerLine[0][i - 6][j + 6];
							}
							if (puzzleLine[item][i][j] == -21) {
								puzzleLine[item][i][j] = puzzleLine[1][i - 6][j - 6];
								playerLine[item][i][j] = playerLine[1][i - 6][j - 6];
							}
						}
					}
					cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);

					// Superimpose the corner subgrids
					tempDigits = [[], [], [], [], [], [], [], [], []];
					// Bottom left
					for (let i = 0; i < 3; i++) {
						for (let j = 6; j < 9; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[0][i][j] !== 'undefined' && cellDigitsArray[0][i][j].includes(item) && cellDigitsArray[5][i + 6][j - 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 0; i < 3; i++) {
						for (let j = 6; j < 9; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[0][i][j] = tempDigits[i][j];
							}
						}
					}

					// Bottom right
					tempDigits = [[], [], [], [], [], [], [], [], []];
					for (let i = 0; i < 3; i++) {
						for (let j = 0; j < 3; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[1][i][j] !== 'undefined' && cellDigitsArray[1][i][j].includes(item) && cellDigitsArray[5][i + 6][j + 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 0; i < 3; i++) {
						for (let j = 0; j < 3; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[1][i][j] = tempDigits[i][j];
							}
						}
					}
					break;

				case 6:
					// Now we have to handle the left grid
					for (let i = 0; i < 9; i++) {
						for (let j = 0; j < 9; j++) {
							if (puzzleLine[item][i][j] == -17) {
								puzzleLine[item][i][j] = puzzleLine[0][i + 6][j - 6];
								playerLine[item][i][j] = playerLine[0][i + 6][j - 6];
							}
							if (puzzleLine[item][i][j] == -41) {
								puzzleLine[item][i][j] = puzzleLine[3][i - 6][j - 6];
								playerLine[item][i][j] = playerLine[3][i - 6][j - 6];
							}
						}
					}
					cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);

					// Superimpose the corner subgrids
					tempDigits = [[], [], [], [], [], [], [], [], []];
					// Top right
					tempDigits = [[], [], [], [], [], [], [], [], []];
					for (let i = 6; i < 9; i++) {
						for (let j = 0; j < 3; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[0][i][j] !== 'undefined' && cellDigitsArray[0][i][j].includes(item) && cellDigitsArray[6][i - 6][j + 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 6; i < 9; i++) {
						for (let j = 0; j < 3; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[0][i][j] = tempDigits[i][j];
							}
						}
					}

					// Bottom right
					tempDigits = [[], [], [], [], [], [], [], [], []];
					for (let i = 0; i < 3; i++) {
						for (let j = 0; j < 3; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[3][i][j] !== 'undefined' && cellDigitsArray[3][i][j].includes(item) && cellDigitsArray[6][i + 6][j + 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 0; i < 3; i++) {
						for (let j = 0; j < 3; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[3][i][j] = tempDigits[i][j];
							}
						}
					}
					break;

				case 7:
					// Now we have to handle the center grid
					for (let i = 0; i < 9; i++) {
						for (let j = 0; j < 9; j++) {
							if (puzzleLine[item][i][j] == -29) {
								puzzleLine[item][i][j] = puzzleLine[1][i + 6][j + 6];
								playerLine[item][i][j] = playerLine[1][i + 6][j + 6];
							}
							if (puzzleLine[item][i][j] == -53) {
								puzzleLine[item][i][j] = puzzleLine[4][i - 6][j + 6];
								playerLine[item][i][j] = playerLine[4][i - 6][j + 6];
							}
						}
					}
					cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);

					// Superimpose the corner subgrids
					tempDigits = [[], [], [], [], [], [], [], [], []];
					// Top left
					for (let i = 6; i < 9; i++) {
						for (let j = 6; j < 9; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[1][i][j] !== 'undefined' && cellDigitsArray[1][i][j].includes(item) && cellDigitsArray[7][i - 6][j - 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 6; i < 9; i++) {
						for (let j = 6; j < 9; j++) {
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
								if (typeof cellDigitsArray[4][i][j] !== 'undefined' && cellDigitsArray[4][i][j].includes(item) && cellDigitsArray[7][i + 6][j - 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 0; i < 3; i++) {
						for (let j = 6; j < 9; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[4][i][j] = tempDigits[i][j];
							}
						}
					}
					break;

				case 8:
					// Now we have to handle the bottom grid
					for (let i = 0; i < 9; i++) {
						for (let j = 0; j < 9; j++) {
							if (puzzleLine[item][i][j] == -49) {
								puzzleLine[item][i][j] = puzzleLine[3][i + 6][j + 6];
								playerLine[item][i][j] = playerLine[3][i + 6][j + 6];
							}
							if (puzzleLine[item][i][j] == -57) {
								puzzleLine[item][i][j] = puzzleLine[4][i + 6][j - 6];
								playerLine[item][i][j] = playerLine[4][i + 6][j - 6];
							}
						}
					}
					cellDigitsArray[item] = motSudoku.getGridDigits(puzzleLine[item], playerLine[item]);

					// Superimpose the corner subgrids
					tempDigits = [[], [], [], [], [], [], [], [], []];
					// Top left
					for (let i = 6; i < 9; i++) {
						for (let j = 6; j < 9; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[3][i][j] !== 'undefined' && cellDigitsArray[3][i][j].includes(item) && cellDigitsArray[8][i - 6][j - 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 6; i < 9; i++) {
						for (let j = 6; j < 9; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[3][i][j] = tempDigits[i][j];
							}
						}
					}

					// Top right
					tempDigits = [[], [], [], [], [], [], [], [], []];
					for (let i = 6; i < 9; i++) {
						for (let j = 0; j < 3; j++) {
							tempDigits[i][j] = [];
							allDigits.forEach((item) => {
								if (typeof cellDigitsArray[4][i][j] !== 'undefined' && cellDigitsArray[4][i][j].includes(item) && cellDigitsArray[8][i - 6][j + 6].includes(item)) {
									tempDigits[i][j].push(item);
								}
							});
						}
					}
					for (let i = 6; i < 9; i++) {
						for (let j = 0; j < 3; j++) {
							if (typeof tempDigits[i][j] !== 'undefined') {
								cellDigitsArray[4][i][j] = tempDigits[i][j];
							}
						}
					}
					break;
			}
		}
	});

	gridSequence.forEach((item) => {
//alert(item + ':\n' + cellDigitsArray[item]);
		for (let i = 0; i < 9; i++) {
			for (let j = 0; j < 9; j++) {
				if (typeof cellDigitsArray[item][i][j] !== 'undefined' && cellDigitsArray[item][i][j] != '') {
					// Set the style
					$("#mot_sudoku_n_cell_id_" + (item + 1) + "_" + (i + 1) + (j + 1)).css({"font-size": fontSizeSmall, "font-weight": fontWeightNormal, "color": textColorPlayer, "text-align": textAlignLeft, "vertical-align": verticalAlignTop});
					$("#mot_sudoku_n_cell_id_" + (item + 1) + "_" + (i + 1) + (j + 1)).html(cellDigitsArray[item][i][j].join(', '));
				}
			}
		}
	});
}

motSudoku.ninjaHelperMask = function() {
	for (let g = 0; g < 9; g++) {
		for (let x = 0; x < 9; x++) {
			for (let y = 0; y < 9; y++) {
				if ((this.puzzleLine[g][x][y] == 0) && (this.playerLineN[g][x][y] == 0)) {
					$("#mot_sudoku_n_cell_id_" + (g + 1) + "_" + (x + 1) + (y + 1)).html('');
				}
			}
		}
	}
}

})(jQuery); // Avoid conflicts with other libraries
