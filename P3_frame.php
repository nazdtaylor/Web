<?php

	if (isset($_GET['fileToSearch'])) {
		processForm();
	} else {
		displayForm();
	}


function processForm() {
	$myError = 0;

......................
					$fileContents = ........
					doSearch($fileContents, $theStat, $theFunct);
.....................
	return;
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
	$gamesJSON = json_decode($f);


    ...............................................
    ...............................................
    ...............................................
    ...............................................

	return;
}

function okayFile($f) {
.............................
	return true;
}

function displayForm() {

	startHTML();


      .............................................


	echo "
	<form action='p3.php' method='get'>
	Select parameters to search:<br>
	";
	echo "
	<p>
	<select name='fileToSearch'> ";

           ...............................................

	echo "</select>";

	echo "
	<p>
	<select name='statToSearch'> ";

           ...............................................

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

	$filesJSON = slurpfile($scoreFiles);

	if (strlen($filesJSON) > 0) {
		$results = json_decode($filesJSON);	
	} 
	echo "Error", json_last_error();
	return $results;

}

//
//  Read in the contents of a file and return it as a string.
//  Need to check for errors......
//
function slurpfile($afile) {

..........................
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
