<?php 
session_start();
include("includes/a_config.php");
include 'db_connection.php'; 
$nextstep=false;
$nottoosoon=false;
$toosoon =false;
$laststep=false;?>

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

if(!isset($_POST['schemeSel']) AND !isset($_POST['id'])) {
echo '
<h2><center>Please Select the Information you want to be displayed</center></h2>
<form action="individual.php" method="post">
 <button name="schemeSel" type="submit" value="Passing">Passing</button>
 <button name="schemeSel" type="submit" value="Offense">Offense</button>
 <button name="schemeSel" type="submit" value="Defense">Defense</button>
 <p>Select Stat Year</p>
<input type="radio" id="Year" name="Year" value="2019">
	<label for="2019">2019</label>
<input type="radio" id="Year" name="Year" value="2020">
	<label for="2020">2020</label>
<input type="radio" id="Year" name="Year" value="2021" checked>
	<label for="2021">2021</label></form>';
}

if (isset($_POST['schemeSel']))
{$year=$_POST['Year'];
#echo $year;
	$_SESSION['schemeSave']=$_POST['schemeSel'];
	switch ($_POST['schemeSel']){
		case "Passing";		$sqlstatement="SELECT FullName FROM passing_$year ORDER BY FullName ASC;";
											$sqlplayer = "SELECT * FROM passing_$year WHERE FullName ="; 
											$_SESSION['sqlplayer']=$sqlplayer;		
											break;
		case "Offense";		$sqlstatement="SELECT FullName FROM scrimmage_stats_$year ORDER BY FullName ASC;" ;		
											$sqlplayer = "SELECT * FROM scrimmage_stats_$year WHERE FullName =";	
											$_SESSION['sqlplayer']=$sqlplayer;	
											break;
		case "Defense";		$sqlstatement="SELECT FullName FROM defense_$year ORDER BY FullName ASC;" ;
											$sqlplayer = "SELECT * FROM defense_$year WHERE FullName ="; 
											$_SESSION['sqlplayer']=$sqlplayer; 
											break;	
	} 
$toosoon=true;
$scheme = $_POST['schemeSel'];
}

if($toosoon){

echo '<br><h3>' . $scheme . " Players Shown" . '</h3><br>';
echo '<form  method="post">';
echo '<select name="id">';
foreach ($conn->query($sqlstatement) as $row){
echo '<option value="' . $row['FullName'] .'">' . $row['FullName'] . '</option>';}
echo '<input type ="submit"  name="submit" value="Continue to Choose Player" />
</select></form>';
$nextstep=true;}

if(false){
echo '
<form  method="post">
<select name="Player">';
foreach ($conn->query("SELECT FullName FROM $schemeSel$year WHERE TeamName like $TeamChoice;") as $row){
echo '<option value=' . $row['FullName'] .'>' . $row['FullName'] . '</option>';
}
echo 
'<input type ="submit"  name="submit2" value="Display Player" />
</select></form><br>';
$nextstep=false;
;}

if(isset($_POST['id']))
{
	$sqlplayer = $_SESSION['sqlplayer'];
	$sqlplayer = $sqlplayer.='"';
	$sqlplayer = $sqlplayer.=$_POST['id'];
	$sqlplayer = $sqlplayer.='";';	
	$laststep=true;
}

echo '<br><br><table>';

if($laststep)
	{
$schemeSave = $_SESSION['schemeSave'];
switch ($schemeSave){
		case "Passing";			
				echo '<table>';
				printpassingtable(); 	break;
		case "Offense";		
				echo '<table>';
				printoffensetable();	break;
		case "Defense";	
				echo '<table>';
				printdefensetable();	break;
}

foreach($conn->query($sqlplayer)->fetchAll(PDO::FETCH_ASSOC) as $results) 
{ 	echo '<tr>'; 	foreach($results as $result=>$info){ echo '<td>' . $info .  '</td>';	 }echo '</tr>';}
echo '</table>';
$nottoosoon=true;}

if ($laststep){
echo '
<form action="individual.php" method="get">
<button type="submit" formaction="individual.php">Clear Search</button>
</form> ';
}?>

</center>
</div>
<?php include("includes/footer.php");?>
</body>
</html>