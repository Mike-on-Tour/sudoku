# Change Log
All changes to `Sudoku` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [0.7.2] - 2024-03-16

### Added

### Changed

### Fixed
-	Problems with Postgres databases in `controller/mot_sudoku_acp.php` and `controller/mot_sudoku_main.php`

### Removed
  
  
## [0.7.1] - 2024-03-15

### Added

### Changed

### Fixed
-	A problem with Postgres databases in `controller/mot_sudoku_acp.php`

### Removed
-	A still existing template variable concerning purging the Sudoku cache (removed in ver 0.4.0) in `controller/mot_sudoku_acp.php`
  
  
## [0.7.0] - 2024-03-11

### Added
-	A setting to choose the number of lines in the ACP game packs table added to the settings tab
-	An `if` statement to the `styles/all/template/mot_sudoku_ninja.js` file which enlarges the cell width and height as well as the font sizes for the digits and the helper
	digits if the Ninja box is wider than 1830 pixels

### Changed
-	Deleting game packs has been changed from a single pack affair to a single or multiple pack choice by marking the pack(s) to be removed

### Fixed

### Removed
  
  
## [0.6.2] - 2024-03-07

### Added
-	A check whether the user is still logged in to the functions handling AJAX requests for entering a digit, reseting the puzzle and buying a digit in the
	`controller/mot_sudoku_main.php` file including handing back a result to `styles/all/template/mot_sudoku_main.js` to indicate this state 

### Changed
-	The SQL query in `event/mot_sudoku_listener.php` from `SELECT` to `SELECT DISTINCT` to limit the number of usernames displayed as being actively playing Sudoku to one per user

### Fixed
-	Some PHP warnings and errors in the `controller/mot_sudoku_main.php` and `includes/mot_sudoku_functions.php` files when using the Hall of Fame tab
-	A bug which did not increment the number of games played when updating the FAME_TABLE within the `controller/mot_sudoku_main.php` file's function `save_to_fame()`
-	The missing calculation of xStart and yStart to prevent a hidden modal window in `styles/all/template/mot_sudoku_classic.js`

### Removed
  
  
## [0.6.1] - 2024-02-26

### Added

### Changed
-	The template event files shifted from the `prosilver` directory to the `all` directory
-	Shifted the dropdown select field on the Highscore and Hall of Fame tabs from the right side into the header for improved recognisability

### Fixed
-	Some PHP warnings due to undefined variables when using the Highscore and Hall of Fame tabs

### Removed
  
  
## [0.6.0] - 2024-02-25

### Added
-	A highscore tab including a switch in the ACP to enable or disable it
-	A Hall of Fame tab including a switch in the ACP to enable or disable it and a setting to choose the number of entries to be displayed
-	A function to `event/mot_sudoku_listener.php` to remove the entries belonging to a deleted user from the games, stats and fame tables

### Changed
-	The game pack upload now shows a message what variable has to be set if file uploads are disabled within php.ini and the number of files allowed in one upload in the upload
	explanation if it is enabled
-	If disabled founders still can see and operate Sudoku
-	Some code optimization

### Fixed
-	The config setting "enable_sudoku" has been inactive so far, it is now activated

### Removed
  
  
## [0.5.1] - 2024-02-22

### Added
-	The css code to horizontally scroll the Ninja puzzle if screen width is smaller than 970 pixels

### Changed
-	Cell dimensions within the Samurai puzzle from 40 x 40 pixels to 38 x 38 pixels to prevent the puzzle from overflowing to the right using prosilver
-	Corrected the formula to calculate the modal digit windows position in Ninja puzzles
-	Adjusted Ninja css to min width of 850 pixels for prosilver and 860 pixels for Dark Vision
-	The game pack upload now accepts multiple files

### Fixed
-	The missing game level definition if no game pack is installed which led to a PHP warning
-	The disappearance of the modal digit window after scrolling vertically
-	A problem with the "buy digit" function of Ninja puzzles which led to an invalid entry into the puzzle line (tried to enter an illegal 10th grid)

### Removed
  
  
## [0.5.0] - 2024-02-19

### Added
-	The functionality for the Ninja puzzles

### Changed
-	If no puzzle exists the user no longer only sees an error message, now the different tabs are visible and the error message is displayed for the puzzle type which does not
	exist. The player may still do not have a classic puzzle (e.g. because they all were played) but still may solve a Samurai or Ninja puzzle.

### Fixed

### Removed
  
  
## [0.4.1] - 2024-02-07

### Added

### Changed
-	The vertical distance of the digit selection window from the mouse pointer in `styles/all/template/mot_sudoku_classic.js` and `styles/all/template/mot_sudoku_samurai.js`
	by 15 pixel to the upper screen border
-	The number of additional digits gained with a new level for the Samurai and Ninja puzzles
-	The modal window holding the digit buttons is double-spaced at a screen width smaller than 700 pixels
-	The div holding the Samurai puzzle has aminimum width of 895 pixels and becomes scrollable if the screen width is smaller than that

### Fixed
-	A bug which prevented the removing of wrong digits from the grid due to an inadvertently used upper-case letter in the cell identifier in `styles/all/template/mot_sudoku_main.js`

### Removed
  
  
## [0.4.0] - 2024-02-06

### Added
-	An ACP page to administer game packs (import and delete)
-	The functionality for the Samurai puzzles
-	The functionality to enable (display) the helper button for each game type

### Changed
-	Some code improvements
-	The behaviour of the button buying a digit to prevent buying the last missing digit and thus circumfence the routine to check whether the last digit was entered
-	The display of the activated cell by selecting another background colour instead of changing the border colour which a player can not easily detect

### Fixed
-	A bug which still did not protect digits bought through a game level change from being altered before the first re-loading of the puzzle

### Removed
-	The enabling and purging of a cache from the ACP settings page
  
  
## [0.3.2] - 2024-01-24

### Added

### Changed
-	Improved the code to retrieve a new puzzle while ignoring puzzles already solved by the user
-	The difficulty level is now displayed with a term and no longer as a digit
-	The selected cell is now "highlighted" with a blue border instead of box shadow since the latter didn't work properly with all browsers
-	All CSS settings which will be used in one or more jQuery functions to variables to enable easy changing in other styles than prosilver
-	Bought digits (this is valid for digits "bought" by changing the game level, too) are now displayed with a grey color until the game is loaded the next time
-	After solving a puzzle the player will be rerouted to a new game after 5 seconds

### Fixed

### Removed
  
  
## [0.3.1] - 2024-01-21

### Added
-	The functionality to clear the game stats within the ACP settings page

### Changed

### Fixed
-	If no file was selected for the game pack import a PHP warning was issued, this case is now handled with an error message
-	A forgotten css setting which caused the digits to still have the wrong style if a digit is bought after showing the helper (`styles/all/template/mot_sudoku_main.js`)

### Removed
  
  
## [0.3.0] - 2024-01-18

### Added
-	A shadow to the selected puzzle cell to show the selection
-	A list of active Sudoku players to the bottom of the Sudoku page, affected files are `event/mot_sudoku_listener.php` and all `language/XX/mot_sudoku_common.php` files
-	Game points settings to the ACP
-	A table called MOT_SUDOKU_GAMES_TABLE to hold the data of all currently played and unsolved games
-	A table called MOT_SUDOKU_STATS_TABLE to hold the solved games, total points and settings for a certain player
-	HTML files to be included holding the game options, the game level select and the results
-	General game functions to the `styles/all/template/mot_sudoku_main.js` file
-	A special Javascript file to hold the specific game functions for the classic Sudoku (`styles/all/template/mot_sudoku_classic.js`)
-	A modal window to hold the digits and a trash bin for selecting the action for a chosen cell
-	The complete functionality to play Classic Sudoku puzzles
-	The Samurai Sudoku grid

### Changed
-	The size of the classic puzzle cells from 30 to 40 pixel in order to improve operability on mobile devices
-	Hide the Sudoku cache settings because it might not be needed in the future
-	The ACP settings page layout

### Fixed

### Removed
  
  
## [0.2.0] - 2024-01-02

### Added
-	A frontend language file to all languages (`language/XX/mot_sudoku_common.php`)
-	A main controller for the frontend (`controller/mot_sudoku_main.php`)
-	A main template file `styles/prosilver/template/mot_sudoku_main.html`
-	`routing.yml` and `tables.yml` files
-	An event template file to display the copyright in the footer when Sudoku is played
-	Tabs to display the three Sudoku types (`styles/all/template/mot_sudoku_main.js`, `styles/template/mot_sudoku_classic.html`, `styles/template/mot_sudoku_samurai.html`,
	`styles/template/mot_sudoku_ninja.html` and `styles/prosilver/theme/mot_sudoku_main.css`)
-	A table called MOT_SUDOKU_CLASSIC_TABLE to hold the data for classich Sudoku puzzles
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

