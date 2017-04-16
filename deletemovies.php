
<?php

session_start();

if(!isset($_SESSION['priv']) ){
	header("Location: /homepage.php");
}
elseif($_SESSION['priv']!=1) {
	header("Location: /homepage.php");
}

require 'guestconnect.php';
/*
if(isset($_POST['search'])){
$tosearch = $_POST['search'];

if($_POST['Search']=="Title"){
	$query = "SELECT * FROM movies  WHERE title LIKE '%$tosearch%' COLLATE utf8_general_ci";
}elseif($_POST['Search']=="Genre"){
	$query = "SELECT * FROM movies AS m WHERE m.mvid IN(SELECT m2.mvid FROM movies as m2 ,moviegenre as mg, genre as g WHERE m2.mvid = mg.mvid AND mg.gid = g.gid AND g.gname LIKE '%$tosearch%' COLLATE utf8_general_ci)";
}elseif($_POST['Search']=="Tags"){
	$query = "SELECT * FROM movies AS m WHERE m.mvid IN(SELECT m2.mvid FROM movies as m2 ,tags as t WHERE m2.mvid = t.mvid AND t.tag LIKE '%$tosearch%' COLLATE utf8_general_ci)";
}else{
	$query = "SELECT * FROM movies AS m WHERE m.mvid IN(SELECT m2.mvid FROM movies as m2 ,moviecrew as mc, crew as c WHERE m2.mvid = mc.mvid AND mc.cid = c.cid AND c.cname LIKE '%$tosearch%' COLLATE utf8_general_ci)";
}


$response = @mysqli_query($dbc, $query);

if($response){
	while($row = mysqli_fetch_array($response)){
		echo '<b><a href="deletethis.php?id='.$row['mvid'] .'">'. $row['title'] .'</a>'."   ".$row['releasedate'] . '</b><br/><p>' . $row['summary'] . '</p><br/>';
	}
} else {
	echo 'Could not issue query';
}
}
mysqli_close($dbc);*/
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="moviesearch.css" type="text/css" rel="stylesheet"/>
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
	<div class="searchbar">
		<form action="deletemovies.php" method="post">
			<input type="text" name="search" placeholder="Search for a movie to delete...">
			<select name = "Search">
				<option value= "Title">Title</option>
				<option value =	"Genre">Genre</option>
				<option value="Tags">Tag</option>
				<option value="Crew Member">Cast Member</option> 
			</select>
			<input type="submit" value="Go">
		</form>
	</div>
		</div>
		<div class="query">
		<?php
		if(isset($_POST['search'])){
$tosearch = $_POST['search'];

if($_POST['Search']=="Title"){
	$query = "SELECT * FROM movies  WHERE title LIKE '%$tosearch%' COLLATE utf8_general_ci";
}elseif($_POST['Search']=="Genre"){
	$query = "SELECT * FROM movies AS m WHERE m.mvid IN(SELECT m2.mvid FROM movies as m2 ,moviegenre as mg, genre as g WHERE m2.mvid = mg.mvid AND mg.gid = g.gid AND g.gname LIKE '%$tosearch%' COLLATE utf8_general_ci)";
}elseif($_POST['Search']=="Tags"){
	$query = "SELECT * FROM movies AS m WHERE m.mvid IN(SELECT m2.mvid FROM movies as m2 ,tags as t WHERE m2.mvid = t.mvid AND t.tag LIKE '%$tosearch%' COLLATE utf8_general_ci)";
}else{
	$query = "SELECT * FROM movies AS m WHERE m.mvid IN(SELECT m2.mvid FROM movies as m2 ,moviecrew as mc, crew as c WHERE m2.mvid = mc.mvid AND mc.cid = c.cid AND c.cname LIKE '%$tosearch%' COLLATE utf8_general_ci)";
}


$response = @mysqli_query($dbc, $query);

if($response){
	while($row = mysqli_fetch_array($response)){
		echo '<div class="results">';
		echo '<b><a href="deletethis.php?id='.$row['mvid'] .'">'. $row['title'] ."   ".$row['releasedate'] . '</b><br/><p>' . $row['summary'] . '</p></a>';
		echo '</div>';
	}
} else {
	echo 'Could not issue query';
}
}
mysqli_close($dbc);
?>
</body>
</html>