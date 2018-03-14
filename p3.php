<?php

// Naz Taylor
// CS 316
// Project 3

// Some of the code, specifically the doControl() and displayForm() along with parts of every other function, were provided by and credited to Paul Linton. 

// Check if fields are set. If they arent then display the form. If they are then process what they contain.
	if (isset($_GET['fileToSearch']) && isset($_GET['statToSearch']) && isset($_GET['functWanted'])) {
		processForm();
		echo "";
	} else {
		displayForm();
	}

// function to take form information and get what they ask for
function processForm() {
	$myError = 0;
	$file = $_GET['fileToSearch'];
	$theStat = $_GET['statToSearch'];
	$theFunct = $_GET['functWanted'];
	$fileContents = "";
	$filecheck = okayFile($file);
	
	if($filecheck == true){
        $filesJSON = slurpfile($file);
	
	// decode the JSON if there is an issue with it then display error
        if (strlen($filesJSON) > 0) {
                $fileContents = json_decode($filesJSON);
      		if(json_last_error() > 0){
                        printJSONerror(json_last_error());
                        return;
                }
        }

	doSearch($fileContents, $theStat, $theFunct);

	return;
	}
	else{
		echo "Selected file does not exist.";
		return;
	}
}

//
//  Pre-conditions:  $f contains a string representation of a season file
//                   $s is a statistic we want to search for
//                   $w is what function (high or low) we want.
//
//  Post-conditions: Output of the information of the matching game.
//
function doSearch($f, $s, $w) {

	$currStat = null;
  	
	// only search the JSON if looking for high or low as they are the only acceptible answers here
	if($w == "high" || $w == "low"){
		$thegame = null;
		$thestat = null;
		foreach($f->games as $agame){
		if(!isset($agame->$s)){
			continue;
		}
		if($thegame == null){
			$thegame = $agame;
			$thestat = $agame->$s;
			continue;
		}
		// search for high in specified stat
        	if ($w == "high"){
           		if($agame->$s > $thestat){
				$thestat = $agame->$s;
				$thegame = $agame;
				continue;
			}
		}
		// search for low in specified stat
        	if ($w == "low"){
                	if($agame->$s < $thestat){
                                $thestat = $agame->$s;
                                $thegame = $agame;
				continue;
                        }
        	}
		}
		// error catching for stat that doesnt exist
		if($thegame == null || $thestat == null){
			echo "Invalid parameters or there is no record of that stat.";
		}
		// print answer to valid query
		else{
		echo $w," in ", $s," for selected season was against ",$thegame->Opponent," where they scored ",$thestat," ", $s;
		}
	}
	else{
		echo "Invalid parameters";
	}
	return;
}

// check if input file actually exists
function okayFile($f) {
	if(file_exists($f)){
		return true;
	}
	else{
		return false;
	}
}

// display options on web
function displayForm() {

	startHTML();

	$filesJSON = doControl();
	

	echo "
	<form action='p3.php' method='get'>
	Select parameters to search:<br>
	";
	echo "
	<p>
	<select name='fileToSearch'> ";
	foreach($filesJSON->files as $years){
		echo "<option value='$years'>$years</option>";
	}

	echo "</select>";

	echo "
	<p>
	<select name='statToSearch'> ";
	foreach($filesJSON->stats as $stats){
		echo "<option value='$stats'>$stats</option>";
	}

	echo "</select>";

	echo "
	<p>
	<select name='functWanted'> ";
		echo "<option value='high'>High</option>";
		echo "<option value='low'>Low</option>";
	echo "</select>";

	echo "
	<p>
	<input type='submit' value='Do search'>
	";

	endHTML();
}

//
//  Read the file "UKgames.json" and return a JSON object.
//
//  Calling code should check return value for validity!
//
function doControl() {

	$scoreFiles = "UKgames.json";
	$results = "";
	$filecheck = okayFile($scoreFiles);
	
	if($filecheck == true){
	$filesJSON = slurpfile($scoreFiles);

	if (strlen($filesJSON) > 0) {
		$results = json_decode($filesJSON);	 
		if(json_last_error() > 0){
			printJSONerror(json_last_error());
			return;
		}
	}
	return $results;
	}
	else{
		echo "Invalid initial file.";
		return;
	}

}

//
//  Read in the contents of a file and return it as a string.
//  Need to check for errors......
//
function slurpfile($afile) {
	
	$contents = file_get_contents($afile);
	return $contents;
}

function startHTML() {

echo "
<html>
<head>
<title>Search records!</title>
</head>
<body>
<h1>Search records!</h1>
";

}

function endHTML() {

echo "
</body>
</html>
";

}

//
//  Pass in json_last_error() and this will print out the error, if any.
//
function printJSONerror($e) {

switch ($e) {
        case JSON_ERROR_NONE:
//            echo ' - No errors';
			return;
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }

    echo PHP_EOL;

}

?>
