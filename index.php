<?php 
session_start();
include("includes/a_config.php");
include 'db_connection.php'; 
$nottoosoon=false;
$toosoon =false;?>

<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php 
include("includes/design-top.php");
include("includes/navigation.php");
echo '<div class="container" id="main-content"><center>';
$nextstep=false;
$laststep =false;

if (!isset($_POST['TeamSel'])){
echo '<h2><center>Please Select Team you want to be displayed</center></h2><br>';
echo '
<form  method="post">
<select name= "TeamSel">';

foreach ($conn->query("SELECT TeamName FROM team_stats_2021;") as $row){
echo '<option value="' . $row['TeamName'] . '"">' . $row['TeamName'] . '</option>';}

if (!isset($_POST	['TeamSel'])) 
{echo '<input type ="submit"  name="submit" value= "Choose Team to see Record" /></select><br>';}
else
{echo '<input type ="submit"  name="submit" value= "Start New Search" /></select><br>';}

 echo '<p>Select Stat Year</p>
<input type="radio" id="Year" name="Year" value="2019">
	<label for="2019">2019</label>
<input type="radio" id="Year" name="Year" value="2020">
	<label for="2020">2020</label>
<input type="radio" id="Year" name="Year" value="2021" checked>
	<label for="2021">2021</label><br><br>
</form>';}


if(isset($_POST	['TeamSel']))
	{
//		echo $_POST['Year'];
$year =$_POST['Year'];
$TeamSelection = $_POST['TeamSel'];
$TeamBareSelection = $TeamSelection;
$temp = "'";
$TeamSelection = $temp.=$TeamSelection;
$TeamSelection = $TeamSelection.="'";
$sql = "SELECT * FROM team_stats_$year WHERE TeamName =";
$sqlOffense = "SELECT * FROM scrimmage_stats_$year WHERE TeamName =";
$sqlDefense ="SELECT * FROM defense_$year WHERE TeamName =";
$sqlDefense = $sqlDefense.=$TeamSelection;
$sqlOffense = $sqlOffense.=$TeamSelection;
$sqlOffense = $sqlOffense.=" ORDER BY TotalYards DESC Limit 1;";
$sqlDefense = $sqlDefense.=" ORDER BY Tackles DESC Limit 1;";
$sql = $sql.=$TeamSelection;
$sql = $sql.=";";


echo '<h3>Team Stats for ' . $TeamBareSelection . " in " . $year .'</h3><table>';
printteamtable();
foreach($conn->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $results){
	{ 	echo '<tr>';	foreach($results as $result=>$info){	echo '<td>' . $info .  '</td>';} 	echo '</tr></table><br>';}}

echo '<h3>Top Defensive Player</h3><table>';
printdefensetable();
foreach($conn->query($sqlDefense)->fetchAll(PDO::FETCH_ASSOC) as $results){
	{ 	echo '<tr>';	foreach($results as $result=>$info){	echo '<td>' . $info .  '</td>';		 	} 	echo '</tr></table><br>';			 }}

echo '<h3>Top Offensive Player</h3><table>';
printoffensetable();
foreach($conn->query($sqlOffense)->fetchAll(PDO::FETCH_ASSOC) as $results){
	{ 	echo '<tr>';	foreach($results as $result=>$info){	echo '<td>' . $info .  '</td>';		 	} 	echo '</tr>';			 }}

echo 
'</table><form action="index.php" method="get">
  <button type="submit" formaction="index.php">Start New Search</button></form>';
}?>

</center></div>
<?php include("includes/footer.php");?>
</body>
</html>