<?php
$hostname = "localhost";
$username="root";
$password = "";
$database="gestao";

$conn = mysqli_connect($hostname, $username, $password, $database);

if(!$conn){
	die ("Falha na ligaчуo:" .mysqli_connect_erro());
}
?>