<?php
include('Connect.php');
include('ErrorControl.php');
include('AccessControl.php');

$Title=$_GET['Title'];
$ID=$_GET['ID'];

echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: </p><input type="text" name="Title" value="'.$Title.'"><br>';
echo '<p>Format: </p><select name="Format">';
echo '<option value="DVD">DVD</option>';
echo '<option vaue="Blu-Ray">Blu-Ray</option>';
echo '</select><br>';
echo '<input type="hidden" name="ID" value="'.$ID.'">';
echo '<input type="submit" name="submit" value="Slet">';

$TitleErrCheckIn=$_POST['Title'];
$TitleErrCheck=ErrorControl($TitleErrCheckIn);

if($TitleErrCheck==TRUE) {
	
	$ErrCheck=TRUE;
}


if(isset($_POST['submit']) && $ErrCheck != TRUE){

$Title=$_POST['Title'];
$Format=$_POST['Format'];
$ID=$_POST['ID'];

$Delete_Query_Statement=$db->prepare("DELETE FROM Movie WHERE ID = :id");
$Delete_Query_Statement->bindParam('id', $ID, PDO::PARAM_INT);

try{
    $Delete_Query_Statement->execute();
}catch(PDOException $e){
    echo $e->getMessage();
}


echo '<p>Filmen er blevet slettet</p>';

}

if ($ErrCheck==TRUE) {
	
	
	echo '<p>Du har indtastet ugyldige karaktere</p>';
	
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}
?>