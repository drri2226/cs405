<?php


session_start();

if(isset($_SESSION['user_id'])){
	header("Location: /homepage.php");
}

require 'guestconnect.php';

if(!empty($_POST['username']) && !empty($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	echo "$password";
	echo "$username";
	$query = "SELECT uname, password, manager,uid FROM users WHERE uname = '$username' and password='$password'";
	$response = @mysqli_query($dbc, $query)or die("failed to query");
	$row = mysqli_fetch_array($response);

	if($row){
		if($row['uname']==$username && $row['password'] == $password ){
			echo 'login successful';
			$_SESSION['user_id'] = $row['uid'];
			$_SESSION['priv'] = $row['manager'];
			echo $_SESSION['user_id'];
			header("Location: /homepage.php");
		}
		
	}else{
		echo 'Could not login.';
	}
}

mysqli_close($dbc);

?>

<!DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="userstyle.css" type="text/css" rel="stylesheet"/>
</head>
<body>

	<div class="header">
		<div class="container">
			<div class="logo">
			<h1><a href="/homepage.php">CS 405 Project</a></div></h1>
			</div>
		</div>
	</div>
	<div class = "wrapper">
	<h1>Login</h1>
	<span>or <a href="register.php">register here</a></span>
	</div>
	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter your username" name="username">
		<input type="password" placeholder="Password" name="password">

		<input type="submit">

	</form>

</body>
</html>