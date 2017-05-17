<?php

	include "functions.php";
	session_start();


	if(isset($_GET['studentName'])){
		$_SESSION['currentStudent'] = findStudent(findStudentId(explode(' ', $_GET['studentName'])[0], explode(' ', $_GET['studentName'])[1]));
		$notes = getValidNotes(findStudentId($_SESSION['currentStudent']->getName(), $_SESSION['currentStudent']->getLastName()));
	}

	if (!isset($_GET['studentName']) && isset($_SESSION['currentStudent'])) {
		$notes = getValidNotes(findStudentId($_SESSION['currentStudent']->getName(), $_SESSION['currentStudent']->getLastName()));
	}

	if((isset($_POST['note']) && !empty($_POST['note'])) && (isset($_POST['coeff']) && !empty($_POST['note']))){
		addNote($_SESSION['currentStudent'], $_POST['note'], $_POST['coeff'],$_POST['comment']);
		header("Location:teacherStudent.php");
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
		    	<li><a href="<?php echo "teacherClass.php?className=".$_SESSION['className']."" ?>">Class</a></li>
	  		</ul>
		</nav>
	</div>

	<div class="noteSheet">
		
		<table border="1">
			<tr>
				<th>Date</th>
				<th>Notes</th>
				<th>Coefficient</th>
				<th>Comment</th>
			</tr>
			<?php
				foreach ($notes as $note) {
					echo "<tr>";
					echo "<td>".$note->getDate()."</td>";
					echo "<td>".$note->getValue()."</td>";
					echo "<td>".$note->getCoeff()."</td>";
					echo "<td>".$note->getComment()."</td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>

	<div class="addNoteBox">
        <p class= "addNoteBoxTitle"> Add Note </p>        
        <form action="<?php echo "teacherStudent.php?className=".$_SESSION['currentStudent']->getName()."+".$_SESSION['currentStudent']->getLastName()."" ?>" name="addNote" method="POST">
            <p class="addNoteTS">Note : <input type="number" min="0" max="20" name="note" /></p>
            <p class="addNoteCoeff">Coeff : <input type="number" min="1" max="9" name="coeff" value="1"/></p>
            <p class="addNoteComment">Comment : <input type="text" name="comment" /></p>
            <p><input type="submit" value=Add class="addNoteButton"></p>
        </form>
    </div>

</body>
</html>