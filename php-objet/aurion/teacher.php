<?php

	include "functions.php";
	session_start();

	if(isset($_SESSION['user']) && $_SESSION['user']->getRole() !== 'teacher'){
		echo "ACCESS DENIED";
		header("Refresh:3; url=index.php"); 
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
		<h2 class="teacherSession">TEACHER SESSION</h2>
		<img class="logo" src="logo.png">	
		<form action="teacher.php" name="logout" method="POST">	
			<input class="logout" type="submit" name="logout" value="Logout">
		</form>
		<nav>
	  		<ul class="menu">
			    <li class="home"><a href="teacher.php">Home</a></li>
	  		</ul>
		</nav>
	</div>

	<div class="classrooms">
		<form action="teacherClass.php" name="classSelect" method="GET">
			<select name="className">
				<?php
					$classes = findClasses($_SESSION['user']);
					foreach ($classes as $class) {
						echo "<option>".$class->getName()."</option>";
					}
				?>
			</select>
			<input type="submit" />
		</form>
	</div>

</body>
</html>