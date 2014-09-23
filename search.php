<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
include('ErrorControl.php');

session_start();

echo '<form name="Movie" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p><select name="Type"><option value="Title">Titel</option><option value="Genre">Genre</option><option value="Format">Format</option><option value="Production_Year">Productions Aar</option><option value="Actor">Skuespiller</option><option value="Director">Instruktoeer</option></select> <input type="text" name="Search"></p><br>';
echo '<input type="submit" name="submit" value="Search">';
echo '</form>';

$TitleErrCheckIn=$_POST['Search'];
$TitleErrCheck=ErrorControl($TitleErrCheckIn);

if($TitleErrCheck==TRUE){
	
	$ErrCheck=TRUE;
}


if(isset($_POST['submit']) && $_POST['Search']!='' && $ErrCheck != TRUE){

$Search=$_POST['Search'];
$Type=$_POST['Type'];


//$Query_String="SELECT * FROM Movie WHERE Title LIKE '%".$Title."%'";
//$Query_String="SELECT * FROM Movie WHERE ".$Type." LIKE '%".$Search."%'";

$Search = '%'.$Search.'%';

$statement = $db->prepare("SELECT * FROM Movie WHERE ".$Type." LIKE :search");
$statement->bindParam(':search', $Search, PDO::PARAM_STR);

try{
    $statement->execute();
}catch(PDOException $e){
    echo $e->getMessage();
}


//$result = mysql_query($Query_String) or die('<p>Could not search database</p>');


echo '<center>';
echo '<table border="1">';
echo '<tr>';
echo '<td><p>Titel</p></td><td><p>Genre</p></td><td><p>Format</p></td><td><p>Productions Aar</p></td><td><p>Skuespillere</p></td><td><p>Instruktoeer</p></td>';
echo '</tr>';

//while($row = mysql_fetch_array($result)) 
while($row = $statement->fetch(PDO::FETCH_OBJ))
{


if($row->Lend == 'Yes') {
	
	echo '<tr>';
echo "<td bgcolor=\"red\">".$row->Title."</td><td bgcolor=\"red\">".$row->Genre."</td><td bgcolor=\"red\">".$row->Format."</td><td bgcolor=\"red\">".$row->Production_Year."</td><td bgcolor=\"red\">".$row->Actor."</td><td bgcolor=\"red\">".$row->Director."</td>";

			if(isset($_SESSION['Logged_In'])){
          			echo "<td><a href=\"update.php?Title=".$row->Title."&ID=".$row->ID."&Genre=".$row->Genre."&Production_Year=".$row->Production_Year."&Actor=".$row->Actor."&Director=".$row->Director."\">Edit</a></td><td><a href=\"delete.php?Title=".$row->Title."&ID=".$row->ID."\">Delete</a></td><td><p>".$row->Loaner."</p></td>";
      					}
			
	echo '</tr>';
	
	}
	else {


echo '<tr>';
echo "<td><p>".$row->Title."</p></td><td><p>".$row->Genre."</p></td><td><p>".$row->Format."</p></td><td><p>".$row->Production_Year."</p></td><td><p>".$row->Actor."</p></td><td><p>".$row->Director."</p></td>";

			if(isset($_SESSION['Logged_In'])){
          			echo "<td bgcolor=\"#808080\"><a href=\"update.php?Title=".$row->Title."&ID=".$row->ID."&Genre=".$row->Genre."&Production_Year=".$row->Production_Year."&Actor=".$row->Actor."&Director=".$row->Director."\">Edit</a></td><td bgcolor=\"#808080\"><a href=\"delete.php?Title=".$row->Title."&ID=".$row->ID."\">Delete</a></td>";
      					}
		}
echo '</tr>';
}
echo '</table>';
echo '</center>';
}
?>