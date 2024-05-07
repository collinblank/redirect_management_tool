<?php
$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;
$dbname = DB_NAME;
	$conn=mysqli_connect($servername,$username,$password,"$dbname");
	  if(!$conn){
		  die('Could not Connect MySql Server');
		}

