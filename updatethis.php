
<?php

session_start();

if(!isset($_SESSION['priv']) ){
	header("Location: /homepage.php");
}
elseif($_SESSION['priv']!=1) {
	header("Location: /homepage.php");
}

require 'managerconnect.php';

if(!isset($_POST['update'])){
	$idtoquery = $_GET['id'];
	$query = "SELECT * FROM movies AS m WHERE m.mvid = '$idtoquery'";

	$response = @mysqli_query($dbc, $query);

	if($response){
		$row = mysqli_fetch_array($response);
		$title = "\"" . $row['title'] . "\"";
		$releasedate = "\"" . $row['releasedate'] . "\"";
		$summary = "\"" . $row['summary'] . "\"";
		$language = "\"" . $row['lang'] . "\"";
		$duration = "\"" . $row['duration'] . "\"";

		$message= "Please provide updated information for" .'<br/>'.
		'<b>' .$row['title']  . " Released:    " . $row['releasedate'] .  '</b><br/>' ;
	} else {
		echo 'Could not find movie';
	}
}else{
	$idtoquery = $_GET['id'];
	$title = $_POST['title'];
	$releasedate = $_POST['releasedate'];
	$summary = $_POST['summary'];
	$language = $_POST['language'];
	$duration = $_POST['duration'];
	$query = "UPDATE movies SET title = '$title', summary = '$summary', releasedate = '$releasedate', lang = '$language', duration = '$duration' WHERE mvid = '$idtoquery'";


	if(mysqli_query($dbc, $query)){
    	header("Location: /updatemore.php?id=$idtoquery");
	} else{
    	echo "ERROR: Could not update records. ". mysqli_error($dbc);
	}
}
mysqli_close($dbc);
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="searchstyles2.css" type="text/css" rel="stylesheet"/>
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
	<?php echo $message; ?>
		<form action="updatethis.php?id=<?php echo $idtoquery; ?>" method="POST">
		<input type="text" placeholder="Title" name="title" value=<?php echo $title ?>>
		<input type="text" placeholder="Release Date" name="releasedate" value=<?php echo $releasedate; ?>>
		<input type="text" placeholder="Summary" name="summary" value=<?php echo $summary; ?>>
		<input type="text" placeholder="Language" name="language" value=<?php echo $language; ?>>
		<input type="text" placeholder="Duration" name="duration" value=<?php echo $duration; ?>>				
		<input type="submit" name='update' value="UPDATE">

	</form>

	<form action="updatemovies.php" method="POST">						
		<input type="submit" name="return" value='Return'>
	</form>
	</div>
</body>
</html>