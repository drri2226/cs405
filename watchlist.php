<!DOCTYPE html>

<?php

session_start();

require 'managerconnect.php';

if(!isset($_SESSION['user_id'])){
	header("Location: /homepage.php");
}


$queryid= $_SESSION['user_id'];

$query = "SELECT * FROM movies, watchlist WHERE movies.mvid = watchlist.mvid AND watchlist.uid = '$queryid'";

$response = @mysqli_query($dbc, $query);

if($response){

	while($row = mysqli_fetch_array($response)){
		echo '<b><a href="movie.php?id='.$row['mvid'] .'">'. $row['title'] .'</a>'."   ".$row['releasedate'] . '</b><br/><p>' . $row['summary'] . '</p><br/> <form action="Watchlist.php?id='.$row['mvid'] .'" method="post"> <input type="submit" value="Remove" name="remove">
		</form>';
	}
} else {
	echo 'Could not issue query';
}

if(isset($_POST['remove'])){
	$mvid=$_GET['id'];
	$query = "DELETE FROM watchlist WHERE mvid = '$mvid' AND uid = '$queryid'";
	mysqli_query($dbc, $query);
	header("Location: /Watchlist.php");
}

mysqli_close($dbc);
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
</head>
<body>
	<div class="header">
		<div class = "container">
			<div class="logo">
				<h1><a href="homepage.php">CS 405 DB</a></h1>
			</div>
		<div class="nav">
			<ul>
				<?php if(isset($_SESSION['priv'])){
						if($_SESSION['priv']==1){
						echo '<li><a href="managemovies.php">Manage Movies</a></li>
							<li><a href="manageusers.php">Manage Users</a></li>';
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
	<div class="searchbar">
		<form action="search.php" method="post">
			<input type="text" name="search" placeholder="Search...">
			<select name = "Search">
				<option value= "Title">Title</option>
				<option value =	"Genre">Genre</option>
				<option value="Tags">Tag</option>
				<option value="Crew Member">Cast Member</option> 
			</select>
			<input type="submit" value="Go">
		</form>
	</div>
</body>
</html>