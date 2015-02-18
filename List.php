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

session_start();

echo '<link rel="stylesheet" type="text/css" href="style.css">';
include('Connect.php');
//$result = mysql_query("SELECT * FROM Movie") or die('<p>could not select database content</p>');

echo '<center>';
echo '<table border="1">';
echo '<tr>';
echo '<td><p>Titel</p></td><td><p>Genre</p></td><td><p>Format</p></td><td><p>Productions Aar</p></td><td><p>Skuespillere</p></td><td><p>Instruktoeer</p></td><td><p>Ejer</p></td>';
if(isset($_SESSION['Logged_In'])) {
echo '<td><p>Pris</p></td>';	
}
echo '</tr>';


try{
    
    $statement = $db->prepare('SELECT * FROM Movie ORDER BY Title');
    $statement->execute();
    
    while($row = $statement->fetch(PDO::FETCH_OBJ)) {
        if($row->Lend == 'Yes') {
            echo "<tr>";
            $User = $row->User;
            $User = ucfirst($User);
            echo "<td bgcolor='red'>$row->Title</td><td bgcolor='red'>$row->Genre</td><td bgcolor='red'>$row->Format</td><td bgcolor='red'>$row->Production_Year</td><td bgcolor='red'>$row->Actor</td><td bgcolor='red'>$row->Director</td><td bgcolor='red'>".$User."</td>";
            if(isset($_SESSION['Logged_In']))
            {
                echo "<td bgcolor='red'>$row->Price</td>";
            }
            if(isset($_SESSION['Logged_In'])) {
                echo "<td bgcolor='red'><a href='update_display.php?Title=$row->Title&ID=$row->ID&Genre=$row->Genre&Production_Year=$row->Production_Year&Actor=$row->Actor&Director=$row->Director'>Edit</a></td><td bgcolor='red'><a href='delete_display.php?Title=$row->Title&ID=$row->ID'>Delete</a></td><td><p>$row->Loaner</p></td>";
            }
            echo "</tr>";
        }
        else {
        
        echo "<tr>";
        $User = $row->User;
        $User = ucfirst($User);
        echo "<td><p>$row->Title</p></td><td><p>$row->Genre</p></td><td><p>$row->Format</p></td><td><p>$row->Production_Year</p></td><td><p>$row->Actor</p></td><td><p>$row->Director</p></td><td>".$User."</td>";
        
            if(isset($_SESSION['Logged_In'])) 
            {
                echo "<td><p>$row->Price</p></td>";
            }
            
            if(isset($_SESSION['Logged_In'])) {
                echo "<td bgcolor='#808080'><a href='update_display.php?Title=$row->Title&ID=$row->ID&Genre=$row->Genre&Production_Year=$row->Production_Year&Actor=$row->Actor&Director=$row->Director'>Edit</a></td><td bgcolor='#808080'><a href='delete_display.php?Title=$row->Title&ID=$row->ID'>Delete</a></td>";
            }            
        echo "</tr>";
        }
    }
    
    $CountStatement=$db->prepare('SELECT COUNT(id) FROM Movie');
    $CountStatement->execute();
    $CountResult = $CountStatement->fetch();
    
    $WorthStatement=$db->prepare('SELECT SUM(Price) FROM Movie');
    $WorthStatement->execute();
    $WorthResult = $WorthStatement->fetch();
    
    echo "<tr>";
    echo "<td></td><td></td><td></td><td></td><td></td><td><p>Total". $CountResult['COUNT(id)'] ."Titler</p></td>";
    if(isset($_SESSION['Logged_In'])) {
        echo "<td><p>Filmenes V&aelig;rdi". $WorthResult['SUM(Price)']. "</p></td>";    
    } 
    else 
    {
        echo "<td></td>";	
    }
    echo "</tr>";
    
} catch(PDOException $e) {
    echo 'ERROR: '.$e->getMessage();    
}

/*
while($row = mysql_fetch_array($result)) 
{

	if($row['Lend'] == 'Yes') {
	
	echo '<tr>';
echo "<td bgcolor=\"red\">".$row['Title']."</td><td bgcolor=\"red\">".$row['Genre']."</td><td bgcolor=\"red\">".$row['Format']."</td><td bgcolor=\"red\">".$row['Production_Year']."</td><td bgcolor=\"red\">".$row['Actor']."</td><td bgcolor=\"red\">".$row['Director']."</td>";
if(isset($_SESSION['Logged_In'])) 
	{
	 	echo "<td bgcolor=\"red\"><p>".$row['Price']."</p></td>";
	}

      	if(isset($_SESSION['Logged_In'])){
         	 echo "<td bgcolor=\"red\"><a href=\"update_display.php?Title=".$row['Title']."&ID=".$row['ID']."&Genre=".$row['Genre']."&Production_Year=".$row['Production_Year']."&Actor=".$row['Actor']."&Director=".$row['Director']."\">Edit</a></td><td bgcolor=\"red\"><a href=\"delete_display.php?Title=".$row['Title']."&ID=".$row['ID']."\">Delete</a></td><td><p>".$row['Loaner']."</p></td>";
      	}

echo '</tr>';
	
	}
	else {

echo '<tr>';
echo "<td><p>".$row['Title']."</p></td><td><p>".$row['Genre']."</p></td><td><p>".$row['Format']."</p></td><td><p>".$row['Production_Year']."</p></td><td><p>".$row['Actor']."</p></td><td><p>".$row['Director']."</p></td>";

if(isset($_SESSION['Logged_In'])) 
{
	echo "<td><p>".$row['Price']."</p></td>";
}

      if(isset($_SESSION['Logged_In'])){
          echo "<td bgcolor=\"#808080\"><a href=\"update_display.php?Title=".$row['Title']."&ID=".$row['ID']."&Genre=".$row['Genre']."&Production_Year=".$row['Production_Year']."&Actor=".$row['Actor']."&Director=".$row['Director']."\">Edit</a></td><td bgcolor=\"#808080\"><a href=\"delete_display.php?Title=".$row['Title']."&ID=".$row['ID']."\">Delete</a></td>";
      }

echo '</tr>';
	}
}

$CountQuery='SELECT COUNT(id) FROM Movie';
$DisplayCountQuery=mysql_query($CountQuery) or die('<p>Could not count from Movie</p>');
$DisplayCount=mysql_result($DisplayCountQuery,0);

$WorthQuery='SELECT SUM(Price) FROM Movie';
$WorthCountQuery=mysql_query($WorthQuery) or die('<p>Could not get total sum of money from Movie');
$WorthCount=mysql_result($WorthCountQuery,0);

echo '<tr>';
echo '<td></td><td></td><td></td><td></td><td></td><td><p>Total '.$DisplayCount.' Titler</p></td>';
if(isset($_SESSION['Logged_In'])) {
echo '<td><p>Filmenes V&aelig;rdi '.$WorthCount.'</p></td>';	
} else {
echo '<td></td>';	
}
echo '</tr>';
*/
echo "</table>";
echo "</center>";
?>