<?php

	require "classes.php";

	define("DB", 'aston');
	define("HOST", 'localhost');
	define("USER", 'root');
	define("PASS", '');



	function dbConnect(){
		$db = mysqli_connect(HOST, USER, PASS, DB);
		return $db;
	}

	//login function
	//Checks for the user and password in database
	//If found, redirects to the page corresponding to the role of the user
	//If not, error returned
	function login($user, $pwd){

		$db = dbConnect();

		$sql = "SELECT id FROM users WHERE username = '$user' and password = '$pwd'";
		$result = mysqli_query($db,$sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);

		if($count == 1) {
			$_SESSION['user_id'] = $row["id"];

			$sql = "SELECT * FROM users WHERE id = '".$_SESSION['user_id']."'";
			$result = mysqli_query($db,$sql);
			$row = $result->fetch_array(MYSQLI_ASSOC);

			$user = new Person();
			$user->setName($row['name']);
			$user->setLastName($row['lastname']);
			$user->setRole($row['role']);

			$_SESSION['user'] = $user;

			if ($_SESSION['user']->getRole() === 'administration') {
				header("location: admin.php");
			}
			if ($_SESSION['user']->getRole() === 'teacher') {
				header("location: teacher.php");
			}
			if ($_SESSION['user']->getRole() === 'student') {
				echo "Succesfully logged in! But you don't have any rights here!";
				logout();
			}
		}
		else {
			echo "Invalid credentials, please try again";
		}
	}

	//logout function
	//Logs the user out and redirects to login screen
	function logout(){
		session_destroy();
		header("Location:index.php");
		exit();
	}

	//createUser function
	//creates user into the database
	function createUser($name, $lastname, $username, $password, $role){
		$db = dbConnect();

		$sql = "INSERT INTO users (name, lastname, username, password, role) VALUES ('$name', '$lastname', '$username', '$password', '$role') ";
		if($result = mysqli_query($db, $sql)){
			$string = "User succesfully created!";
		}
		else{
			$string = "Error";
		}

		echo $string;
	}

	//findStudent function
	//finds a Student in database corresponding to given id
	function findStudent($id){
		$db = dbConnect();

		$sql = "SELECT * from users WHERE id = '$id'";
		$result = mysqli_query($db, $sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);

		if ($count == 1) {
			$stud = new Student;
			$stud->setName($row['name']);
			$stud->setLastName($row['lastname']);
			$stud->setRole(Role::Stud);

			return $stud;
		}

	}

	//findStudentId function
	//finds a Student's id in database corresponding to given name and last name
	function findStudentId($name, $lastname){
		$db = dbConnect();

		$sql = "SELECT id from users WHERE name = '$name' AND lastname = '$lastname'";
		$result = mysqli_query($db, $sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);

		if ($count == 1) {
			return $row['id'];
		}
		else{
			echo "Error";
		}

	}

	function getStudents($className){
		$db = dbConnect();
		$sql = "SELECT id FROM classes WHERE name='$className'";
		$result = mysqli_query($db, $sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);

		$sql2 = "SELECT * from users WHERE role='student' AND class_id = '".$row['id']."'";
		$result2 = mysqli_query($db, $sql2);

		$students = array();
		$i=0;
		while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
			$students[$i] = new Student();
			$students[$i]->setName($row2['name']);
			$students[$i]->setLastName($row2['lastname']);
			$students[$i]->setRole(Role::Stud);

			$i++;
		}
		
		return $students;
	}


	//findClasses function
	//enables a teacher to find the classes he is linked to
	function findClasses($teacher){

		$db = dbConnect();

		$sql = "SELECT id FROM users WHERE name = '".$teacher->getName()."' AND lastname = '".$teacher->getLastName()."'";
		$result = mysqli_query($db, $sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$sql2 = "SELECT * FROM classes WHERE teacher_id = '".$row['id']."'";
		$result2 = mysqli_query($db, $sql2);

		$classes = array();
		$i = 0;
		while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
			$classes[$i] = new Classroom;
			
			$rep1 = findStudent($row2['rep1_id']);
			$rep2 = findStudent($row2['rep2_id']);
			$rep1->setClass($classes[$i]);
			$rep2->setClass($classes[$i]);

			$classes[$i]->setName($row2['name']);
			$classes[$i]->setRepresentatives($rep1, $rep2);
			$classes[$i]->setComment($row2['comment']);

			$i++;
		}

		return $classes;
	}

	//getClass function
	//gets class object with given class name
	function getClass($className){

		$db = dbConnect();

		$sql = "SELECT * from classes WHERE name = '$className'";
		$result = mysqli_query($db, $sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);

		$class = new Classroom;
		$class->setName($row['name']);
		$class->setRepresentatives(findStudent($row['rep1_id']), findStudent($row['rep2_id']));
		$class->setComment($row['comment']);

		return $class;
	}


	//getValidNotes function
	//gets notes associated to a student
	function getValidNotes($studentId){

		$db = dbConnect();

		$sql = "SELECT * FROM notes WHERE student_id = '$studentId' AND status = 'Validated'";
		$result = mysqli_query($db, $sql);

		$notes = array();
		$i = 0;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$notes[$i] = new Note;

			$notes[$i]->setValue($row['value']);
			$notes[$i]->setDate($row['date']);
			$notes[$i]->setCoeff($row['coeff']);
			$notes[$i]->setComment($row['comment']);

			$i++;	
		}

		return $notes;
	}

	//getNotesToValidate function
	//get notes that the administration has to validate
	function getNotesToValidate(){

		$db = dbConnect();

		$sql = "SELECT * FROM notes WHERE status = 'Suspended'";
		$result = mysqli_query($db, $sql);

		$notes = array();
		$i = 0;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$notes[$i][0] = new Note;

			$notes[$i][0]->setValue($row['value']);
			$notes[$i][0]->setDate($row['date']);
			$notes[$i][0]->setCoeff($row['coeff']);
			$notes[$i][0]->setComment($row['comment']);

			$notes[$i][1] = $row['student_id'];

			$i++;	
		}

		return $notes;
	}
	
	//addNote function
	//adds a note to a student with the status 'Suspended'
	function addNote($student, $value, $coeff, $comment){

		$db = dbConnect();

		$sql = "INSERT INTO notes (student_id, value, date, coeff, comment, status) VALUES ('".findStudentId($student->getName(), $student->getLastName())."', '$value', '".date('Y-m-d')."', '$coeff', '$comment', 'Suspended' )";
		if($result = mysqli_query($db, $sql)){
			$string = "Note succesfully added!";
		}
		else{
			$string = "Error";
		}
		echo $string;
	}

	//validateNote function
	//sets a note to the status 'Validated' given the row of the note
	function validateNote($noteRow){

		$db = dbConnect();

		$sql = "SELECT * FROM notes WHERE status = 'Suspended'";
		$result = mysqli_query($db, $sql);

		$notes = array();
		$i = 1;
		while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
			if ($i == $noteRow){
				$sql2 = "UPDATE notes SET status = 'Validated' WHERE id =".$row['id']."";
				if ($result2 = mysqli_query($db, $sql2)) {
					echo "Note validated!";
				}
				else{
					echo "error";
				}
			}
			$i++;
		}
	}

	//getAverageNote function 
	//gets the average of a student's notes
	function getAverageNote($student){
		
		$db = dbConnect();

		$stud_id = findStudentId($student->getName(), $student->getLastName());
		$sql = "SELECT value, coeff FROM notes WHERE student_id = '$stud_id'";
		$result = mysqli_query($db, $sql);
		$average = 0;
		$coeffSum = 0;
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$coeffNote = $row['value'] * $row['coeff'];
			$average += $coeffNote;
			$coeffSum += $row['coeff'];
		}
		if ($coeffSum != 0) {
			$average /= $coeffSum;
		}
		
		return round($average, 2);


	}

	//getClassAverageNote function
	//gets the average of the class
	function getClassAverageNote($className){

		$students = getStudents($className);
		$studentsCount = count($students);

		$classAverage = 0;
		foreach ($students as $stud) {
			$classAverage += getAverageNote($stud);
		}
		
		$classAverage /= $studentsCount;
		return round($classAverage, 2);

	}


/****** BDD ******\
users -> id; username; password; name; lastname; role
notes -> id; student_id; value; date; coeff; comment; status; 
classes -> id; teacher_id; name; rep1_id; rep2_id; comment;

\****** BDD ******/


//To do


?>