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
echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: <input type="text" name="Title"><br><br>';
echo 'Produktions Aar: <input type="text" name="Production_Year"><br><br>';
echo 'Skuespillere: <textarea rows="2" cols="20" name="Actor">';
echo '</textarea><br><br><br>';
echo 'Instruktoeer: <textarea rows="2" cols="20" name="Director">';
echo '</textarea><br><br><br>';
echo 'Genre: <input type="text" name="Genre"><br><br>';
echo 'Pris: <input type="text" name="Price"><br><br>';
echo '<p>Format:</p>';
echo '<input type="checkbox" name="FormatCheck[]" id="DVD" value="DVD"> <label for="DVD">DVD</label><br />';
echo '<input type="checkbox" name="FormatCheck[]" id="Blu-Ray" value="Blu-Ray"> <label for="Blu-Ray">Blu-Ray</label><br />';
echo '</p>';
echo '<input type="submit" name="submit" value="Add"><br />';

$TitleErrCheckIn=$_POST['Title'];
$Production_YearErrCheckIn=$_POST['Production_Year'];
$GenreErrCheckIn=$_POST['Genre'];
$ActorErrCheckIn=$_POST['Actor'];
$DirectorErrCheckIn=$_POST['Director'];
$PriceErrCheckIn=$_POST['Price'];



$TitleErrCheck=ErrorControl($TitleErrCheckIn);
$Production_YearErrCheck=ErrorControl($Production_YearErrCheckIn);
$GenreErrCheck=ErrorControl($GenreErrCheckIn);
$ActorErrCheck=ErrorControl($ActorErrCheckIn);
$DirectorErrCheck=ErrorControl($DirectorErrCheckIn);
$PriceErrCheck=ErrorControl($PriceErrCheckIn);

if($TitleErrCheck==TRUE || $Production_YearErrCheck==TRUE || $GenreErrCheck==TRUE || $ActorErrCheck==TRUE || $DirectorErrCheck==TRUE || $PriceErrCheck==TRUE) {

	$ErrCheck=TRUE;
}


if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!='' && $ErrCheck != TRUE){

$Title=$_POST['Title'];
$Format=$_POST['FormatCheck'];
$FormatData = implode(",", $Format);
$Production_Year=$_POST['Production_Year'];
$Actor=$_POST['Actor'];
$Director=$_POST['Director'];
$Genre=$_POST['Genre'];
$Price=$_POST['Price'];
$Price=(int)$Price;

$Query_Check_Statement=$db->prepare("SELECT * FROM Movie WHERE Title LIKE :title");
$Query_Check_Statement->bindParam(':title', $Title, PDO::PARAM_STR);
try{
    $Query_Check_Statement->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
$titlecheck="";


	while($row = $Query_Check_Statement->fetch(PDO::FETCH_OBJ))
		{
		$titlecheck=$row->Title;
		}

	if($titlecheck!=$Title){

	$insert_statement=$db->prepare("INSERT INTO Movie (Title, Format, Production_Year, Actor, Director, Genre, Price, User) VALUES (:title,:formatdata,:productionyear,:actor,:director,:genre,:price,:user)");
    $insert_statement->bindParam(':title', $Title, PDO::PARAM_STR);
    $insert_statement->bindParam(':formatdata', $FormatData, PDO::PARAM_STR);
    $insert_statement->bindParam(':productionyear', $Production_Year, PDO::PARAM_STR);
    $insert_statement->bindParam(':actor', $Actor, PDO::PARAM_STR);
    $insert_statement->bindParam(':director', $Director, PDO::PARAM_STR);
    $insert_statement->bindParam(':genre', $Genre, PDO::PARAM_STR);
    $insert_statement->bindParam(':price', $Price, PDO::PARAM_INT);
    $insert_statement->bindParam(':user', $_SESSION['User'], PDO::PARAM_STR);

    try {
        $insert_statement->execute();
    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }

	echo '<p>Filmen er tilfoejet til databasen</p>';

	}
	else
	{

	echo '<p>Filmen findes allerede i databasen</p>';

	}

}

if ($ErrCheck==TRUE) {


	echo '<p>Du har indtastet ugyldige karaktere</p>';

}

else {

		echo '<p>Formen er tom, ingen data er indsaette</p>';
}


?>
