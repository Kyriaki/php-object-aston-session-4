<?php

	include "functions.php";
	session_start();
	
	if(isset($_POST['validate'])){
		$noteId = substr($_POST['validate'], 14);
		validateNote($noteId);
		$notes = getnotesToValidate();
	}
	else {
		$notes = getnotesToValidate();
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

	<div class="noteSheet">
		<form action="adminValidations.php" name="validateNote" method="POST">
			<table border="1">
				<tr>
					<th>Date</th>
					<th>Student</th>
					<th>Notes</th>
					<th>Coefficient</th>
					<th>Comment</th>
					<th>Validate</th>
				</tr>
				<?php
					$i = 1;
					foreach ($notes as $note) {
						echo "<tr>";
						echo "<td>".$note[0]->getDate()."</td>";
						echo "<td>".findStudent($note[1])->getName()." ".findStudent($note[1])->getLastName()."</td>";
						echo "<td>".$note[0]->getValue()."</td>";
						echo "<td>".$note[0]->getCoeff()."</td>";
						echo "<td>".$note[0]->getComment()."</td>";
						echo "<td><input type='submit' name='validate' value ='Validate Note ".$i."'></td>";
						echo "</tr>";
						$i++;
					}
				?>
			</table>
		</form>
	</div>

</body>
</html>