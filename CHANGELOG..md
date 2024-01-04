# Change Log
All changes to `Sudoku` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [0.2.0] - 2024-01-19

### Added
-	A frontend language file to all languages (`language/XX/mot_sudoku_common.php`)
-	A main controller for the frontend (`controller/mot_sudoku_main.php`)
-	A main template file `styles/prosilver/template/mot_sudoku_main.html`
-	`routing.yml` and `tables.yml` files
-	An event template file to display the copyright in the footer when Sudoku is played
-	Tabs to display the three Sudoku types (`styles/all/template/mot_sudoku_main.js`, `styles/template/mot_sudoku_classic.html`, `styles/template/mot_sudoku_samurai.html`,
	`styles/template/mot_sudoku_ninja.html` and `styles/prosilver/theme/mot_sudoku_main.css`)
-	A function to the ACP settings module to import xml files containing puzzles

### Changed
-	The `event/mot_sudoku_listener.php` file in order to load the language file into phpBB and set the variables for the navbar link

### Fixed

### Removed
  
  
## [0.1.0] - 2023-12-19

### Added
-	The basic directory and file structure necessary for a phpBB 3.3.x extension
-	`CHANGELOG.md` and `README.md` files
-	The `ext.php` file and its necessary language files (`language/de/mot_sudoku_ext_enable_error.php`, `language/de_x_sie/mot_sudoku_ext_enable_error.php`,
	`language/en/mot_sudoku_ext_enable_error.php`)
-	The files necessary for creating the ACP (`acp/mot_sudoku_acp_info.php`, `acp/mot_sudoku_acp_module.php`, `adm/style/acp_mot_sudoku_settings.html`, `adm/style/mot_sudoku_acp.css`,
	`adm/style/mot_sudoku_acp.js`,`config/services.yml`, `controller/mot_sudoku_acp.php`, `language/de/info_acp_mot_sudoku.php`, `language/de_x_sie/info_acp_mot_sudoku.php`,
	`language/en/info_acp_mot_sudoku.php` and `migrations/v_0_1_0.php`)
-	A permission system with the necessary files (`config/services.yml`, `event/mot_sudoku_listener.php`, `language/de/permissions_mot_sudoku.php`,
	`language/de_x_sie/permissions_mot_sudoku.php`,`language/en/permissions_mot_sudoku.php` and `migrations/v_0_1_0.php`)

### Changed
-	The existing `composer.json` file

### Fixed

### Removed

