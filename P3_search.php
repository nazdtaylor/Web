<?php

function doSearch($f, $s, $w) {

	echo "We're search JSON object:<BR>", PHP_EOL;
	var_dump($f);

	echo "<BR>-------------------------<BR>", PHP_EOL;
	echo "We're looking for stat: ", $s, PHP_EOL;
	echo "<BR>-------------------------<BR>", PHP_EOL;
	echo "We want the: '", $w, "'<BR>", PHP_EOL

	echo "What do we do next?<BR>", PHP_EOL;
	return;
}

$gamesJSON = '
 { 
    "games": [
        { "Opponent": "GRAND_CANYON", "Date": "11/14/14", "WinorLose": "W",
            "Fouls": "16", "Assists": "13",
            "Turnovers": "13", "Blocks": "10", "Steals": "8",
            "Points": "85", "YeartoDateAvg": "85.0"
        },
        { "Opponent": "BUFFALO", "Date": "11/16/14", "WinorLose": "W",
            "Fouls": "21", "Assists": "17",
            "Turnovers": "14", "Blocks": "7", "Steals": "10",
            "Points": "71", "YeartoDateAvg": "78.0"
        }
	]
  }';

$stat      = "Points";
$what      = "high";

doSearch($gamesJSON, $stat, $what);

?>
