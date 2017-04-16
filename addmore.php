
<?php

session_start();

if(!isset($_SESSION['priv']) ){
	header("Location: /homepage.php");
}
elseif($_SESSION['priv']!=1) {
	header("Location: /homepage.php");
}

require 'managerconnect.php';

	$idtoquery = $_GET['id'];
	$message = "Records were added  successfully.".'</br>'. "Add tags, cast members, and genres".'</br>';

if(isset($_POST['update'])){
	
	$idtoquery = $_GET['id'];
	echo $idtoquery;
	$newtags = $_POST['tags'];
	$newgenre = $_POST['genre'];
	$newcrew = $_POST['crew'];

	$indtags = explode(" , ", $newtags);
	foreach($indtags as $thistag){
		$query2 = "INSERT INTO tags (mvid,  tag) VALUES ('$idtoquery', '$thistag')";
		mysqli_query($dbc, $query2);
	}


	$newcrew = trim($newcrew, "(");
	$indcrew = explode("(", $newcrew);
	foreach($indcrew as $thiscrew){
		$thiscrew = trim($thiscrew, "), ");
		$thisrole2 = explode(",",$thiscrew);
		$name = $thisrole2[0];
		$name =trim($name);
		$role = $thisrole2[1];
		$role = trim($role);
		
		$query7 = "SELECT * FROM crew WHERE cname = '$name'";
		$response6 = mysqli_query($dbc, $query7);
		if(mysqli_num_rows($response6)==0){
			$query8 = "INSERT INTO crew (cid,cname) VALUES (NULL,'$name')";
			@mysqli_query($dbc, $query8);
			$response6 = mysqli_query($dbc, $query7);
		}
			 $row5 = mysqli_fetch_array($response6);
			 $cidtouse=$row5['cid'];
			 $query9 = "INSERT INTO moviecrew (mvid,cid,role) VALUES ('$idtoquery', '$cidtouse', '$role')";
			 @mysqli_query($dbc, $query9);
	}



	$indgenre = explode(" , ", $newgenre);
	foreach($indgenre as $thisgenre){
		$query4 = "SELECT * FROM genre WHERE gname = '$thisgenre'";
		$response5 = mysqli_query($dbc, $query4);
		if(mysqli_num_rows($response5)==0){
			$query5 = "INSERT INTO genre (gid,gname) VALUES (NULL,'$thisgenre')";
			@mysqli_query($dbc, $query5);
			$response5 = mysqli_query($dbc, $query4);
		}
			 $row4 = mysqli_fetch_array($response5);
			 $gidtouse=$row4['gid'];
			 $query6 = "INSERT INTO moviegenre (mvid,gid) VALUES ('$idtoquery', '$gidtouse')";
			 mysqli_query($dbc, $query6);
	}

	header("Location: /addmovie.php");


}
mysqli_close($dbc);
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="confirmstyles2.css" type="text/css" rel="stylesheet"/>
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
	<div class="message">
	<?php echo $message?>
		<form action="addmore.php?id=<?php echo $idtoquery; ?>" method="POST">
		<input type="text" placeholder="Tags" name="tags" value="Add Tag1 , Tag2">
		<input type="text" placeholder="Crew" name="crew" value="Add Cast ( Name1 , Role1) , ( Name2 , Role2 )">
		<input type="text" placeholder="Genre" name="genre" value="Add Genre1 , Genre2">			
		<input type="submit" name='update' value="UPDATE">

	</form>

	<form action="addmovie.php" method="POST">						
		<input type="submit" name="return" value='Return'>
	</form>
	</div>
</body>
</html>