<?php include("includes/a_config.php");
include 'db_connection.php';
$topTen = "";
$statLimit = 0;
$nottoosoon = false;

if (isset($_POST['submit']))
{
	if($_POST['statlow'] != NULL){$low=(int)($_POST['statlow']); }else { $low = 0;	}
	if($_POST['stathigh'] != NULL){$high=(int)($_POST['stathigh']); }else { $high = 9999;	}
	$sqlposition="";
	$sqlTeamChoice = "";
	if(isset($_POST['Position'])){$PositionString = $_POST['Position']; 
	switch($PositionString){
	case 'Running Backs';
	$sqlposition = "AND (position = 'RB' OR position = 'FB')";
	break;
	case 'Receivers';
	$sqlposition = "AND (position = 'WR' OR position = 'TE')";
	break;
	case 'Quarterbacks';
	$sqlposition = "AND (position = 'QB')";
	break;
	case 'Other';
	$sqlposition = "AND (position != 'RB' AND position != 'FB' AND position != 'WR' AND position != 'TE' AND position != 'QB')";
	break;}}

	 if(isset($_POST['Top_10']))	{
	 $howmany = $_POST['Top_10'];
	 	switch ($howmany) {
	 	case 10; $topTen = " LIMIT 10"; break;
	 	case 20; $topTen = " LIMIT 20";	break;
	 	case 30; $topTen = " LIMIT 30";	break;
		case 40; $topTen = " LIMIT 40";	break;
	 	default; 						break;	}}

	$chosenYear = (int)$_POST['Year'];
	$choice = $_POST['scheme'];

	if(isset($_POST['TeamSel'])){
	$TeamChoice = $_POST['TeamSel'];
	$sqlTeamChoice = "AND (TeamName = '$TeamChoice')";}	
	else {$TeamChoice="";}

	$sqlstatement ="SELECT * FROM scrimmage_stats_$chosenYear where ($choice >= $low AND $choice <= $high)$sqlTeamChoice$sqlposition order by $choice desc $topTen";
	#echo $sqlstatement;
	$nottoosoon = true;
}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
	<style>
	</style>
</head>
<body>

<?php
include("includes/design-top.php");
include("includes/navigation.php");
if($nottoosoon == false){
echo '<div class="container" id="main-content">
	<h2><center>Please Select the Information you want to be displayed</center></h2><center>
<form  method="post">
	<select  name ="scheme" required>
	<option value="TotalYards">Total Yards</option>
 	<option value="TotalTD">Total Touchdowns</option>
 	<option value="RushingYards">Rushing Yards</option>
 	<option value="RushingTD">Rushing Touchdown</option>
 	<option value="ReceivingYards">Receiving Yards</option>
 	<option value="ReceivingTD">Receiving Touchdown</option>
 	<option value="Catches">Catches</option>
	</select><br><br>

<select  name ="Position">
	<option value="" disabled selected>Select Position if Desired</option>
	<option value="Receivers">Receivers</option>
 	<option value="Running Backs">Running Backs</option>
 	<option value="Quarterbacks">Quarterbacks</option>
 	<option value="Other">Other</option>
	</select><br><br>';

echo '<select name= "TeamSel">';
echo '<option value="" disabled selected>Select Team if Desired</option>';
foreach ($conn->query("SELECT TeamName FROM team_stats_2021;") as $row){
	echo '<option value="' . $row['TeamName'] . '"">' . $row['TeamName'] . '</option>';}

echo '</select><br><br>';
echo '<label for="stathigh">Requested Stats Between(Optional)</label>
<input type="number" name="stathigh" placeholder="Maximum" />
<label for="statlow">and</label>
<input type="number" name="statlow" placeholder="Minimum" /><br><br>

<p>Number of Players Displayed at a Time</p>
<input type="radio" id="top_10" name="Top_10" value=10 checked>
	<label for="Top_10">10</label>
<input type="radio" id="top_10" name="Top_10" value=20>
	<label for="Top_20">20</label>
<input type="radio" id="top_10" name="Top_10" value=30>
	<label for="Top_30">30</label>
<input type="radio" id="top_10" name="Top_10" value=40>
	<label for="Top_40">40</label>
<input type="radio" id="top_10" name="Top_10" value=99>
	<label for="All">All</label><br>

<p>Select Stat Year</p>
<input type="radio" id="Year" name="Year" value="2019">
	<label for="2019">2019</label>
<input type="radio" id="Year" name="Year" value="2020">
	<label for="2020">2020</label>
<input type="radio" id="Year" name="Year" value="2021" checked>
	<label for="2021">2021</label><br><br>	
<input type ="submit"  name="submit" value="Display Results" />
</form>';} 

if($nottoosoon)
{
echo '<center>';
if (($TeamChoice =="") and ($sqlposition==""))
{echo '<h2>' . "Displaying Offensive Stats sorted by " . $choice . " for " . $chosenYear .'<br></h2>';}
else if ($TeamChoice =="")
{echo '<h2>' . "Displaying Offensive Stats sorted by " . $choice . " and " . $PositionString ." for " . $chosenYear .'<br></h2>';}
else if ($sqlposition =="")
{echo '<h2>' . $TeamChoice . " Offensive Stats sorted by " . $choice ." for " . $chosenYear .'<br></h2>';}
else
{{echo '<h2>' . $TeamChoice. " Offensive Stats sorted by " . $choice . " and " . $PositionString ." for " . $chosenYear .'<br></h2>';}}
echo '<table>';
printoffensetable();
	foreach($conn->query($sqlstatement)->fetchAll(PDO::FETCH_ASSOC) as $results) 
		{echo '<tr>'; 	foreach($results as $result=>$info){		echo '<td>' . $info .  '</td>'; 	} 	echo '</tr>';	 }	}
echo '</table>';

if($nottoosoon==true)
{
echo '<br>
 <form action="offense.php" method="get">
  <button type="submit" formaction="offense.php">Start New Search</button>
</form>';}
?>

</center>
</div>
<?php include("includes/footer.php");?>
</body>
</html>