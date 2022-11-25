<?php


function printpassingtable()
{
	echo
	'<tr><th>
	Name</th><th>
	Team&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th><th>
	Passing Yards&nbsp&nbsp&nbsp&nbsp</th><th>
	Completion Rate&nbsp&nbsp&nbsp</th><th>
	Touchdowns</th></tr>';
}

function printteamtable()
{
	echo
	'<tr><th>
	Team Name</th><th>
	Wins&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th><th>
	Loses&nbsp&nbsp&nbsp&nbsp</th><th>
	Rushing Yards&nbsp&nbsp&nbsp</th><th>
	Receiving Yards</th></tr>';
}

function printdefensetable()
{
	echo '<tr><th>
	Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th><th>
	Team&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th><th>
	Position&nbsp&nbsp</th><th>
	Tackles&nbsp&nbsp</th><th>
	Sacks&nbsp&nbsp</th><th>
	Interceptions</th></tr>';
}

function printoffensetable()
{
	echo '<tr><th>
	Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp         </th><th>
	Team&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th><th>
	Position&nbsp&nbsp</th><th>
	Rushing Yards&nbsp&nbsp</th><th>
	Rushing TD&nbsp&nbsp</th><th>
	Receiving Yards&nbsp&nbsp</th><th>
	Catches&nbsp&nbsp</th><th>
	Receiving TD&nbsp&nbsp</th><th>
	Total Yards&nbsp&nbsp</th><th>
	Total TD&nbsp&nbsp</th></tr>';
}

	switch ($_SERVER["SCRIPT_NAME"]) {
		case "/basic-sample-php-template-example-master/basic-sample-php-template-example-master/offense.php":
			$CURRENT_PAGE = "offense"; 
			$PAGE_TITLE = "NFL Offensive Stats";
			break;
		case "/basic-sample-php-template-example-master/basic-sample-php-template-example-master/passing.php":
			$CURRENT_PAGE = "passing"; 
			$PAGE_TITLE = "NFL Passing Stats";
			break;
		case "/basic-sample-php-template-example-master/basic-sample-php-template-example-master/defense.php":
			$CURRENT_PAGE = "defense"; 
			$PAGE_TITLE = "NFL Defensive Stats";
			break;
		default:
			$CURRENT_PAGE = "Index";
			$PAGE_TITLE = "NFL Team Stats";
	}
?>