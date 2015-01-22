<?php
/*
    This is a media database to mange your Movies.
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
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
include('AccessControl.php');
echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: <input type="text" name="Title"><br>';
echo 'Produktions Aar: <input type="text" name="Production_Year"><br>';
echo 'Skuespillere: <textarea rows="2" cols="20" name="Actor">';
echo '</textarea><br>';
echo 'Instruktoeer: <textarea rows="2" cols="20" name="Director">';
echo '</textarea><br>';
echo 'Genre: <input type="text" name="Genre"><br>';
echo 'Pris: <input type="text" name="Price"><br>';
echo 'Format:';
echo '<input type="checkbox" name="FormatCheck[]" value="DVD">DVD<br />';
echo '<input type="checkbox" name="FormatCheck[]" value="Blu-Ray">Blu-Ray<br />';
echo '</p>';
echo '<input type="submit" name="submit" value="Add">';

if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!=''){

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

	$insert_statement=$db->prepare("INSERT INTO Movie (Title, Format, Production_Year, Actor, Director, Genre, Price) VALUES (:title,:formatdata,:productionyear,:actor,:director,:genre,:price)");
    $insert_statement->bindParam(':title', $Title, PDO::PARAM_STR);
    $insert_statement->bindParam(':formatdata', $FormatData, PDO::PARAM_STR);
    $insert_statement->bindParam(':productionyear', $Production_Year, PDO::PARAM_STR);
    $insert_statement->bindParam(':actor', $Actor, PDO::PARAM_STR);
    $insert_statement->bindParam(':director', $Director, PDO::PARAM_STR);
    $insert_statement->bindParam(':genre', $Genre, PDO::PARAM_STR);
    $insert_statement->bindParam(':price', $Price, PDO::PARAM_INT);
	
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


else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}


?>