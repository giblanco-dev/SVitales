<?php
$ServerName = "localhost";
$Username = "root";
$Password = "";
$NameBD = "ser";
$mysqli=new mysqli($ServerName, $Username, $Password, $NameBD); 
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>