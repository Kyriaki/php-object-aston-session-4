<?php

	include "functions.php";
	session_start();

	if (isset($_GET['className'])) {
		$_SESSION['class'] = getClass($_GET['className']);
		$students = getStudents($_SESSION['class']->getName());
	}
	elseif (!isset($_GET['className']) && isset($_SESSION['class'])) {
		$students = getStudents($_SESSION['class']->getName());
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

	<div class="students">
		<form method="GET" action="teacherStudent.php">
		<?php 
			foreach ($students as $stud) {
				echo "<input type='submit' name='studentName' value='".$stud->getName()." ".$stud->getLastName()."'/> Average Note : ".getAverageNote($stud)."<br/>" ;
			}
		?>
		</form>
		<p> Class Average Note : <?php echo getClassAverageNote($_SESSION['class']->getName()); ?> </p>
		<p> Class Comment : <?php echo($_SESSION['class']->getComment()); ?>
	</div>

</body>
</html>