<?php

session_start();

if(isset($_SESSION['user_id'])){
	header("Location: /homepage.php");
}

require 'guestconnect.php';

if(isset($_POST['submit'])){

	$missingdata = array();

	if(empty($_POST['email'])){
		$missingdata[]='Email Address';
	}else{
		$email=trim($_POST['email']);
	}

	if(empty($_POST['username'])){
		$missingdata[]='User name';
	}else{
		$uname=trim($_POST['username']);
	}

	if(empty($_POST['password'])){
		$missingdata[]='Password';
	}else{
		$pword1=$_POST['password'];
	}

	if(empty($_POST['password2'])){
		$missingdata[]='Password Confirmation';
	}else{
		$pword2=$_POST['password2'];
	}

	if(empty($_POST['firstname'])){
		$missingdata[]='First Name';
	}else{
		$fname=trim($_POST['firstname']);
	}

	if(empty($_POST['middlename'])){
		$missingdata[]='Middle Name';
	}else{
		$mname=trim($_POST['middlename']);
	}

	if(empty($_POST['lastname'])){
		$missingdata[]='Last Name';
	}else{
		$lname=$_POST['lastname'];
	}

	if(empty($_POST['dob'])){
		$missingdata[]='Date of Birth';
	}else{
		$dob=$_POST['dob'];
	}

	if(empty($_POST['gender'])){
		$missingdata[]='Gender';
	}else{
		$gender=$_POST['gender'];
	}


	if(!empty($missingdata)){
        echo 'You need to enter the following data<br />';
        foreach($missingdata as $missing){
            echo "$missing<br />";
        }
	}elseif ($pword1 != $pword2) {
    		echo "Passwords must match<br />";
    }else{
		$query = "INSERT INTO users (uid, manager, firstname, middlename, lastname, uname, password, DOB, gender) VALUES (NULL, 0,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "sssssss", $fname, $mname, $lname, $uname, $pword1, $dob, $gender);
		mysqli_stmt_execute($stmt);

		$affectedrows = mysqli_stmt_affected_rows($stmt);
		if($affectedrows == 1){
            echo 'Successfully Registered';
            mysqli_stmt_close($stmt);
            header("Location: /homepage.php");
        } else {
            echo 'Error Occurred<br />';
            mysqli_stmt_close($stmt);
        }

	}
}



mysqli_close($dbc);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link href="userstyle.css" type="text/css" rel="stylesheet"/>
</head>
<body>

	<div class="header">
		<div class ="container">
			<div class = "logo">
				<h1><a href="/homepage.php">CS 405 Project</a></h1>
			</div>
		</div>
	</div>
	<div class="wrapper">
		<h1>Register</h1>
		<span>or <a href="login.php">login here</a></span>
	</div>
	<form action="" method="POST">
		<div class= "formcontainer">
		<div class="column1">
			<input type="text" placeholder="Username" name="username">			
			<input type="text" placeholder="Enter your middle name" name="middlename">
			<input type="text" placeholder="Gender" name="gender">	
			<input type="text" placeholder="Email" name="email">
			<input type="password" placeholder="Password" name="password">
		</div>
		<div class="column2">
			<input type="text" placeholder="First name" name="firstname">
			<input type="text" placeholder="Last name" name="lastname">
			<input type="text" placeholder="Date of Birth (YYYY-MM-DD)" name="dob">		
			<input type="text" placeholder="Confirm Email" name="email2">
			<input type="password" placeholder="Confirm password" name="password2">
		</div>
		</div>	
		<input type="submit" name='submit'>
	</form>

</body>
</html>