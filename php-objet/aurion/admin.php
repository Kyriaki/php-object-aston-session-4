<?php

	include "functions.php";
	session_start();

	if(!isset($_SESSION['user'])){
		header("location: index.php");
	}

	if(isset($_SESSION['user']) && $_SESSION['user']->getRole() !== 'administration'){
		echo "ACCESS DENIED";
		header("Refresh:3; url=index.php"); 
	}

	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['role'])){
		createUser($_POST['firstname'], $_POST['lastname'],$_POST['username'],$_POST['password'], $_POST['role']);
	}

	if (isset($_POST['logout'])) {
		logout();
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	
	<div class="header">
		<h1 class="aurion"> AURION </h1>
		<h2 class="adminSession">ADMIN SESSION</h2>
		<img class="logo" src="logo.png">
		<form action="admin.php" name="logout" method="POST">	
			<input class="logout" type="submit" name="logout" value="Logout">
		</form>
		<nav>
	  		<ul class="menu">
			    <li class="home"><a href="admin.php">Home</a></li>
		    	<li><a href="adminValidations.php">Validations</a></li>
	  		</ul>
		</nav>
	</div>

	<div class="createUserBox">
		<p class= "createUserBoxTitle"> Create User </p>		
		<form action="admin.php" name="createUser" method="POST">
			<p class="createUserUsername">Username : <input type="text" name="username" /></p>
			<p class="createUserPassword">Password : <input type="text" name="password" /></p>
			<p class="createUserFirstname">Firstname : <input type="text" name="firstname" /></p>
			<p class="createUserLastname">Lastname : <input type="text" name="lastname" /></p>
			<select class="createUserUsertype" name="role">
				<option>administration</option>
				<option>teacher</option>
				<option>student</option>
			</select>
			<p><input type="submit" value="SUBMIT" class="createUserButton"></p>
		</form>
	</div>

</body>
</html>