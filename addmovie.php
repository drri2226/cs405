<?php
	session_start();
	
if(!isset($_SESSION['priv']) ){
	header("Location: /homepage.php");
}
elseif($_SESSION['priv']!=1) {
	header("Location: /homepage.php");
}

require 'guestconnect.php';

if(isset($_POST['submit'])){

	$missingdata = array();

	if(empty($_POST['title'])){
		$missingdata[]='Title';
	}else{
		$title=trim($_POST['title']);
	}

	if(empty($_POST['summary'])){
		$missingdata[]='User name';
	}else{
		$summary=trim($_POST['summary']);
	}

	if(empty($_POST['date'])){
		$missingdata[]='Release Date';
	}else{
		$date=$_POST['date'];
	}

	if(empty($_POST['language'])){
		$missingdata[]='Language';
	}else{
		$language=$_POST['language'];
	}

	if(empty($_POST['duration'])){
		$missingdata[]='Duration';
	}else{
		$duration=trim($_POST['duration']);
	}


	if(!empty($missingdata)){
        echo 'You need to enter the following data<br />';
        foreach($missingdata as $missing){
            echo "$missing<br />";
        }
    }else{
		$query = "INSERT INTO movies (mvid, title, summary, releasedate, lang, duration) VALUES (NULL,?,?,?,?,?)";
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "sssss", $title, $summary, $date, $language, $duration);
		mysqli_stmt_execute($stmt);

		$affectedrows = mysqli_stmt_affected_rows($stmt);
		if($affectedrows == 1){
            echo 'Successfully Registered';
            mysqli_stmt_close($stmt);
            $query2 = "SELECT mvid FROM movies WHERE title = '$title' AND releasedate = '$date'";
            $response = mysqli_query($dbc, $query2);
            $row = mysqli_fetch_array($response);
			$movieid=$row['mvid'];
            header("Location: /addmore.php?id=$movieid");
        } else {
            echo 'Error Occurred<br />';
            mysqli_stmt_close($stmt);
        }

	}
}
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="searchstyles.css" type="text/css" rel="stylesheet"/>
</head>
<body>
		<div class="header">
		<div class = "container">
			<div class="logo">
				<h1><a href="homepage.php">CS 405 Project</a></h1>
			</div>
				<ul>
					<?php if(isset($_SESSION['priv'])){
							if($_SESSION['priv']==1){
							echo '<li><a href="managemovies.php">Manage Movies</a>
									<ul>
										<li><a href="addmovie.php">Add Movies</a>
										</li>
										<li><a href="updatemovies.php">Update Movies</a>
										</li>
										<li><a href="deletemovies.php">Delete Movies</a>
										</li>
									</ul>
									</li>
								<li><a href="manageusers.php">Manage Users</a>
									<ul>
										<li><a href="addmanager.php">Add Manager</a>
										</li>
										<li><a href="deleteuser.php">Delete User</a>
										</li>
									</ul>
									</li>
								</li>';
							}
						} 

					if(!isset($_SESSION['user_id'])){
							echo '<li><a href="login.php">Login</a></li>';
						}else{ echo '<li><a href="watchlist.php">Watch List</a></li>
							<li><a href="logout.php">Logout</a></li>';

						}
					?>
				</ul>
		</div>
	</div>
	<div class="wrapper">
		<h1>Add Movies</h1>
		</div>
			<form action="" method="POST">
			<div class= "formcontainer">
		<div class="column1">
		<input type="text" placeholder="Title" name="title">
		<input type="text" placeholder="Summary" name="summary">
		<input type="text" placeholder="Release Date (YYYY-MM-DD)" name="date">
		</div>
		<div class="column2">
		<input type="text" placeholder="Language" name="language">
		<input type="text" placeholder="Duration (H:MM:SS)" name="duration">						
		<input type="submit" name='submit'>
		</div>
		</div>
	</form>


</body>
</html>