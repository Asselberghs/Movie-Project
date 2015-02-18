<?php
/*
    This is a media database to mange your Movie.
    Copyright (C) 2013 Nick Tranholm Asselberghs

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
include('ErrorControl.php');
include('AccessControl.php');

$Title=$_GET['Title'];
$ID=$_GET['ID'];
$Production_Year=$_GET['Production_Year'];
$Actor=$_GET['Actor'];
$Director=$_GET['Director'];
$Genre=$_GET['Genre'];
$Price=$_GET['Price'];

$resultStatement = $db->prepare("SELECT * FROM Movie WHERE ID = :ID");
$resultStatement->bindParam(':ID', $ID, PDO::PARAM_INT);
try
{
    $resultStatement->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}

while($row = $resultStatement->fetch(PDO::FETCH_OBJ)) 
{
$Lend=$row->Lend;
$Loaner=$row->Loaner;
}

echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: </p><input type="text" name="Title" value="'.$Title.'"><br>';
echo '<p>Produktions &Aring;r: </p><input type="text" name="Production_Year" value="'.$Production_Year.'"><br>';
echo '<p>Skuespillere: </p><textarea rows="2" cols="20" name="Actor">';
echo $Actor;
echo '</textarea><br>';
echo '<p>Instruktoeer: </p><textarea rows="2" cols="20" name="Director">';
echo $Director;
echo '</textarea><br>';
echo '<p>Genre: </p><input type="text" name="Genre" value="'.$Genre.'"><br>';
echo '<p>Format: </p>';
echo '<input type="checkbox" name="FormatCheck[]" id="DVD" value="DVD"> <label for="DVD">DVD</label><br />';
echo '<input type="checkbox" name="FormatCheck[]" id="Blu-Ray" value="Blu-Ray"> <label for="Blu-Ray">Blu-Ray</label><br />';
echo '<p>Price: </p><input type="text" name="Price" value="'.$Price.'"><br>';

echo '<p>Udlaant?</p><select name="Lend">';
echo '<option value="Yes">Yes</option>';
echo '<option value="No" selected="selected">No</option>';
echo '</select><br>';

echo '<p>Udlaant til: </p><input type="text" name="Loaner" value="'.$Loaner.'">';
echo '<input type="hidden" name="ID" value="'.$ID.'"><br>';
echo '<input type="submit" name="submit" value="Opdater">';


$TitleErrCheckIn = $_POST['Title'];
$Production_YearErrCheckIn = $_POST['Production_Year'];
$ActorErrCheckIn = $_POST['Actor'];
$DirectorErrCheckIn = $_POST['Director'];
$GenreErrCheckIn = $_POST['Genre'];
$PriceErrCheckIn = $_POST['Price'];
$LoanerErrCheckIn = $_POST['Loaner'];

$TitleErrCheck = ErrorControl($TitleErrCheckIn);
$Production_YearErrCheck = ErrorControl($Production_YearErrCheckIn);
$ActorErrCheck = ErrorControl($ActorErrCheckIn);
$DirectorErrCheck = ErrorControl($DirectorErrCheckIn);
$GenreErrCheck = ErrorControl($GenreErrCheckIn);
$PriceErrCheck = ErrorControl($PriceErrCheckIn);
$LoanerErrCheck = ErrorControl($LoanerErrCheckIn);

if($TitleErrCheck==TRUE || $Production_YearErrCheck==TRUE || $ActorErrCheck==TRUE || $DirectorErrCheck==TRUE || $GenreErrCheck==TRUE || $PriceErrCheck==TRUE || $LoanerErrCheck==TRUE) {
	
	$ErrCheck = TRUE;
}


if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!='' && $ErrCheck != TRUE){

$Title=$_POST['Title'];
$Format=$_POST['FormatCheck'];
$FormatData = implode(",", $Format);
$ID=$_POST['ID'];
$Production_Year=$_POST['Production_Year'];
$Actor=$_POST['Actor'];
$Director=$_POST['Director'];
$Lend=$_POST['Lend'];
$Loaner=$_POST['Loaner'];
$Genre=$_POST['Genre'];
$Price=$_POST['Price'];
$Price=(int)$Price;

$Query_Statement=$db->prepare("UPDATE Movie SET Title = :title WHERE ID = :id");
$Query_Statement->bindParam(':title',$Title, PDO::PARAM_STR);
$Query_Statement->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement2=$db->prepare("UPDATE Movie SET Format = :formatdata WHERE ID = :id");
$Query_Statement2->bindParam(':formatdata',$FormatData, PDO::PARAM_STR);
$Query_Statement2->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement2->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement3=$db->prepare("UPDATE Movie SET Production_Year = :productionyear WHERE ID = :id");
$Query_Statement3->bindParam(':productionyear',$Production_Year, PDO::PARAM_STR);
$Query_Statement3->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement3->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement4=$db->prepare("UPDATE Movie SET Actor = :actor WHERE ID = :id");
$Query_Statement4->bindParam(':actor',$Actor, PDO::PARAM_STR);
$Query_Statement4->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement4->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement5=$db->prepare("UPDATE Movie SET Director = :director WHERE ID = :id");
$Query_Statement5->bindParam(':director',$Director, PDO::PARAM_STR);
$Query_Statement5->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement5->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement6=$db->prepare("UPDATE Movie SET Lend = :lend WHERE ID = :id");
$Query_Statement6->bindParam(':lend',$Lend, PDO::PARAM_STR);
$Query_Statement6->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement6->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement7=$db->prepare("UPDATE Movie SET Loaner = :loaner WHERE ID = :id");
$Query_Statement7->bindParam(':loaner',$Loaner, PDO::PARAM_STR);
$Query_Statement7->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement7->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement8=$db->prepare("UPDATE Movie SET Genre = :genre WHERE ID = :id");
$Query_Statement8->bindParam(':genre',$Genre, PDO::PARAM_STR);
$Query_Statement8->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement8->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$Query_Statement9=$db->prepare("UPDATE Movie SET Price = :price WHERE ID = :id");
$Query_Statement9->bindParam(':price',$Price, PDO::PARAM_INT);
$Query_Statement9->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement9->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}


$Query_Statement10=$db->prepare("UPDATE Movie SET User = :user WHERE ID = :id");
$Query_Statement10->bindParam(':user',$_SESSION['User'], PDO::PARAM_INT);
$Query_Statement10->bindParam(':id', $ID, PDO::PARAM_STR);
try{
    $Query_Statement10->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}


echo '<p>Filmen er blevet opdateret</p>';

}

if ($ErrCheck==TRUE) {
	
	
	echo '<p>Du har indtastet ugyldige karaktere</p>';
	
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}

?>