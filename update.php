<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
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
echo '<input type="checkbox" name="FormatCheck[]" value="DVD">DVD<br />';
echo '<input type="checkbox" name="FormatCheck[]" value="Blu-Ray">Blu-Ray<br />';
echo '<p>Price: </p><input type="text" name="Price" value="'.$Price.'"><br>';

echo '<p>Udlaant?</p><select name="Lend">';
echo '<option value="Yes">Yes</option>';
echo '<option value="No">No</option>';
echo '</select><br>';

echo '<p>Udlaant til: </p><input type="text" name="Loaner" value="'.$Loaner.'">';
echo '<input type="hidden" name="ID" value="'.$ID.'"><br>';
echo '<input type="submit" name="submit" value="Opdater">';


if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!=''){

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

echo '<p>Filmen er blevet opdateret</p>';

}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}

?>