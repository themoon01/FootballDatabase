<?php include("includes/a_config.php");?>

<?php

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
	case 'Lineman';
	$sqlposition = "AND (position = 'DE' OR position = 'LDT' OR position = 'DT' OR position = 'RDE' OR position = 'NT' OR position = 'LDE' OR Position ='RDT')";
	break;
	case 'Safety/Cornerback';
	$sqlposition = "AND (position = 'RCB' OR position = 'CB' OR position = 'DB' OR position = 'SS' OR position = 'LCB' OR position = 'S' OR Position ='FS')";
	break;
	case 'Linebackers';
	$sqlposition = "AND (position LIKE '%LB')";
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
	$sqlTeamChoice = "AND (TeamName = '$TeamChoice')";
	}	
	else {$TeamChoice="";}


	$sqlstatement ="SELECT * FROM defense_$chosenYear where ($choice >= $low AND $choice <= $high)$sqlTeamChoice$sqlposition order by $choice desc $topTen";
	#echo $sql2;
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


<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>


<?php
if($nottoosoon == false){
echo '<div class="container" id="main-content">
	<h2><center>Please Select the Information you want to be displayed</center></h2>
	

	
	<center>
<form  method="post">
	<select  name ="scheme" required>
	
	<option value="Tackles">Tackles</option>
 	<option value="Sacks">Sacks</option>
 	<option value="Interceptions">Interceptions</option>
	</select>
	<br><br>

<select  name ="Position">
	<option value="" disabled selected>Select Position (Optional)</option>
	<option value="Lineman">Lineman</option>
 	<option value="Safety/Cornerback">Safety/Cornerback</option>
 	<option value="Linebackers">Linebackers</option>
	</select>
	<br><br>';


echo '<select name= "TeamSel">';
echo '<option value="" disabled selected>Select Team (Optional)</option>';

foreach ($conn->query("SELECT TeamName FROM team_stats_2021;") as $row){
echo '<option value="' . $row['TeamName'] . '"">' . $row['TeamName'] . '</option>';
}
echo '</select>';
echo '<br><br><label for="stathigh">Requested Stats Between(Optional)</label>
<input type="number" name="stathigh" placeholder="Maximum" />
<label for="statlow">and</label>
<input type="number" name="statlow" placeholder="Minimum" />
<br><br>
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
	<label for="All">All</label>
<br>
<p>Select Stat Year</p>
<input type="radio" id="Year" name="Year" value="2019">
	<label for="2019">2019</label>
<input type="radio" id="Year" name="Year" value="2020">
	<label for="2020">2020</label>
<input type="radio" id="Year" name="Year" value="2021" checked>
	<label for="2021">2021</label><br><br>	

<input type ="submit"  name="submit" value="Display Results" />
</form>';} ?></center>

<center>

<?php

if($nottoosoon)
	{

if (($TeamChoice =="") and ($sqlposition==""))
{echo '<h2>' . "Displaying Defensive Stats sorted by " . $choice . " for " . $chosenYear .'<br></h2>';}
else if ($TeamChoice =="")
{echo '<h2>' . "Displaying Defensive Stats sorted by " . $choice . " and " . $PositionString ." for " . $chosenYear .'<br></h2>';}
else if ($sqlposition =="")
{echo '<h2>' . $TeamChoice . " Defensive Stats sorted by " . $choice ." for " . $chosenYear .'<br></h2>';}
else
{{echo '<h2>' . $TeamChoice. " Defensive Stats sorted by " . $choice . " and " . $PositionString .  " for " . $chosenYear .'<br></h2>';}}

echo '<table>';
printdefensetable();
	foreach($conn->query($sqlstatement)->fetchAll(PDO::FETCH_ASSOC) as $results) 
			 { 	echo '<tr>';	foreach($results as $result=>$info){ 		echo '<td>' . $info .  '</td>';	 	} 	echo '</tr>';	 }}
echo '</table>';
?>
								

<?php
if($nottoosoon==true)
{
	echo '<br><bt>
 <form action="defence.php" method="get">
 
  <button type="submit" formaction="defense.php">Start New Search</button>
</form>';}?>



</center>
</div>



<?php include("includes/footer.php");?>

</body>
</html>