<?PHP
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
include("Connect.php");

$file="backup/movie.sql";
$query_string = "SELECT * INTO OUTFILE '".$file."' FROM Movie";

$query = mysql_query($query_string) or die(mysql_error());

echo $query;
?>