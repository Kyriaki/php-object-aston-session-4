<?php

abstract class Role{
	const Teacher = "teacher";
	const Stud = "student";
	const Admin = "administration";
}


class Person{
	protected $name;
	protected $lastName;
	protected $role;

	function __construct(){
		
	}

	function getName(){
		return $this->name;
	}

	function setName($name){
		$this->name = $name;
	}

	function getLastName(){
		return $this->lastName;
	}

	function setLastName($lastName){
		$this->lastName = $lastName;
	}

	function getRole(){
		return $this->role;
	}

	function setRole($role){
		$this->role = $role;
	}

	function __destruct(){

	}
}

class Student extends Person{
	private $class;

	function __construct(){

	}

	function getClass(){
		return $this->class;
	}

	function setClass(&$class){
		$this->class = $class;
	}

	function __destruct(){

	}
}


class Classroom{
	private $name;
	private $representative1;
	private $representative2;
	private $comment;

	function __construct(){

	}

	function getName(){
		return $this->name;
	}

	function setName($name){
		$this->name = $name;
	}

	function getRepresentatives(){
		return array($this->representative1, $this->representative2);
	}

	function setRepresentatives($rep1, $rep2){
		$this->representative1 = $rep1;
		$this->representative2 = $rep2;	
	}

	function getComment(){
		return $this->comment;
	}

	function setComment($comment){
		$this->comment = $comment;
	}

	function __destruct(){

	}
}

class Note{
	private $value;
	private $date;
	private $coeff;
	private $comment;

	function __construct(){

	}

	function getValue(){
		return $this->value;
	}

	function setValue($value){
		$this->value = $value;
	}

	function getDate(){
		return $this->date;
	}

	function setDate($date){
		$this->date = $date;
	}

	function getCoeff(){
		return $this->coeff;
	}

	function setCoeff($coeff){
		$this->coeff = $coeff;
	}

	function getComment(){
		return $this->comment;
	}

	function setComment($comment){
		$this->comment = $comment;
	}

	function __destruct(){

	}

}



?>

