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
include('Connect.php');
include('ErrorControl.php');
echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Brugernavn: <input type="text" name="user"><br>';
echo 'Password: <input type="password" name="password"><br>';
echo '<input type="submit" name="submit" value="Submit">';

$userErrCheckIn=$_POST['user'];
$passErrCheckIn=$_POST['password'];

$userErrCheck=ErrorControl($userErrCheckIn);
$passErrCheck=ErrorControl($passErrCheckIn);

if($userErrCheck==TRUE || $passErrCheck==TRUE) {
	
	$ErrCheck=TRUE;
}

if(isset($_POST['submit']) && $_POST['user']!='' && $_POST['password']!='' && $ErrCheck != TRUE){

	$user=$_POST['user'];
	$password=$_POST['password'];
	

	$serveruserstatement=$db->prepare("SELECT User FROM Users WHERE User LIKE :user");
	$serverpasswordstatement=$db->prepare("SELECT Password FROM Users WHERE User LIKE :user");
	$serverSALTstatement=$db->prepare("SELECT SALT FROM Users WHERE User LIKE :user");
    
    $serveruserstatement->bindParam(':user', $user, PDO::PARAM_STR);
    $serverpasswordstatement->bindParam(':user', $user, PDO::PARAM_STR);
    $serverSALTstatement->bindParam(':user', $user, PDO::PARAM_STR);
    
	//$SALTQuery=mysql_query($serverSALT) or die('<p>Could not get User´s SALT</p>');
    
    try{
        $serverSALTstatement->execute();        
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
	
	while($row = $serverSALTstatement->fetch(PDO::FETCH_OBJ)) 
	{
	$SALT = $row->SALT;
	}
	
	$password_and_salt = $password.$SALT;
	
	$encrypted_password=hash('sha512',$password_and_salt);

	//$serveruserquery=mysql_query($serveruser) or die('<p>Could not select user</p>');
	//$serverpassquery=mysql_query($serverpassword) or die('<p>Could not select password</p>');
    
    try {
        $serveruserstatement->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
    
    try {
        $serverpasswordstatement->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

	while($row = $serveruserstatement->fetch(PDO::FETCH_OBJ)){

		$serveruservar=$row->User;

	}

	while($row = $serverpasswordstatement->fetch(PDO::FETCH_OBJ)){

		$serverpassvar=$row->Password;

	}

	echo '<br><br>';

	if($user==$serveruservar && $encrypted_password==$serverpassvar){
	
		echo 'Login successful';

        	session_start();
        	$_SESSION['Logged_In'] = true;
            $_SESSION['User'] = $serveruservar;
            $_SESSION['Password'] = $encrypted_password;
	}

	else {
	echo 'Login failed';
	}

echo '</p>';
}

if ($ErrCheck==TRUE) {
	
	
	echo '<p>Du har indtastet ugyldige karaktere</p>';
	
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}

?>