<?php

	include "functions.php";
	session_start();

	if(isset($_POST['username'])  && isset($_POST['password'])){
		login($_POST['username'], $_POST['password']);
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>

	<div class="loginBox">
		<p class= "loginBoxTitle"> Login </p>		
		<form action="index.php" name="login" method="POST">
			<p class="loginUsername">Username : <input type="text" name="username" /></p>
			<p class="loginPassword">Password : <input type="password" name="password" /></p>
			<p><input type="submit" value="Login" class="loginButton"></p>
		</form>
	</div>

</body>
</html>