<?PHP

include("Connect.php");

$file="backup/movie.sql";
$query_string = "SELECT * INTO OUTFILE '".$file."' FROM Movie";

$query = mysql_query($query_string) or die(mysql_error());

echo $query;
?>