<?php 
include("includes/a_config.php");
include 'db_connection.php';
$nottoosoon = false;

if (isset($_POST['submit']))
{
	if($_POST['statlow'] != NULL){$low=(int)($_POST['statlow']); }else { $low = 0;	}
	if($_POST['stathigh'] != NULL){$high=(int)($_POST['stathigh']); }else { $high = 9999;	}

	 if(isset($_POST['Top_10']))	{
	 $howmany = $_POST['Top_10'];
	 	switch ($howmany) {
	 	case 10; $topTen = " LIMIT 10"; break;
	 	case 20; $topTen = " LIMIT 20";	break;
	 	case 30; $topTen = " LIMIT 30";	break;
		case 40; $topTen = " LIMIT 40";	break;
	 	default; 	$topTen = "";			break;	}}

	$chosenYear = (int)$_POST['Year'];
	$choice = $_POST['scheme'];
	$sql2 ="SELECT * FROM passing_$chosenYear where $choice >= $low AND $choice <= $high order by $choice desc $topTen";
	$nottoosoon = true;
}?>

<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php
include("includes/design-top.php");
include("includes/navigation.php");

if(!$nottoosoon)
{
echo '
<div class="container" id="main-content"><center>
<h2>Please Select the Passing Information you want to be displayed</h2>

<form  method="post">
	<label for="scheme">Select how to order the Stats</label>
	<select  name ="scheme" required>
	<option value="PassingYards">Passing Yards</option>
 	<option value="Completional_Rate">Completion Rate</option>
 	<option value="Touchdowns">Touchdowns</option>
	</select><br><br>

<label for="stathigh">Requested Stats Between(Optional)</label>
<input type="number" name="stathigh" placeholder="Maximum" />
<label for="statlow">and</label>
<input type="number" name="statlow" placeholder="Minimum" /><br>

<p>How Many Players to Display</p>
<input type="radio" id="top_10" name="Top_10" value=10 checked>
	<label for="Top_10">10</label>
<input type="radio" id="top_10" name="Top_10" value=20>
	<label for="Top_20">20</label>
<input type="radio" id="top_10" name="Top_10" value=30>
	<label for="Top_30">30</label>
<input type="radio" id="top_10" name="Top_10" value=40>
	<label for="Top_40">40</label>
<input type="radio" id="top_10" name="Top_10" value=99>
	<label for="All">All</label><br><br>

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
echo '<br><center><h2>' . "Displaying Passing Stats sorted by " . $choice . '<br></h2><table>';
printpassingtable();
foreach($conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC) as $results) 
			 { 	echo '<tr>';		 	foreach($results as $result=>$info){		echo '<td>' . $info .  '</td>'; }	 			 	echo '</tr>';		 }
echo '</table> ';
echo ' <form action="passing.php" method="get">
  <button type="submit" formaction="passing.php">Start New Search</button>
</form></center> ';}
?>

</center>
</div>
<?php include("includes/footer.php");?>
</body>
</html>