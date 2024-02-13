# phpBB Sudoku Game Extension

![Version: 0.4.1](https://img.shields.io/badge/Version-0.4.1-green)  
  
![phpBB 3.3.x Compatible](https://img.shields.io/badge/phpBB-3.3.x%20Compatible-009BDF)  

[![Build Status](https://github.com/Mike-on-Tour/sudoku/workflows/Tests/badge.svg)](https://github.com/Mike-on-Tour/sudoku/actions)

## Description
This extension is a version of the popular number-placement puzzle.
Each user plays their own grids. Users gain more points if they make less mistakes. A leaderboard is kept, showing who is the best at the puzzle. It also features variants on the puzzle, such as Sudoku Samurai and Sudoku Ninja.
  
## Install

1. Download the latest release.
2. Unzip the downloaded file.
3. Copy the unzipped folder to `/ext/` (if done correctly, you'll have the main extension class at `(your forum root)/ext/mot/sudoku/composer.json`).
4. Navigate in the ACP to `Customise -> Manage extensions`.
5. Look for `Sudoku` under the Disabled Extensions list, and click its `Enable` link.

## Update

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Sudoku` under the Enabled Extensions list, and click its `Disable` link.
3. Using your favorite FTP software go to the `(your forum root)/ext/mot/sudoku` folder and delete all files and directories.
4. Locally unzip the file `mot_hangman_x.y.z.zip` file (x, y and z are numbers indicating the major version, minor version and patch level).
5. Upload all files from your unzipped `sudoku` folder to your server into the `(your forum root)/ext/mot/sudoku`, please make certain that you use the binary mode for uploading.
6. Go back to the ACP and look for `Sudoku` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Sudoku` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/mot/sudoku` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
