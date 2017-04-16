<!DOCTYPE html>

<?php

session_start();

require 'guestconnect.php';

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
		echo '<b><a href="movie.php?id='.$row['mvid'] .'">'. $row['title'] .'</a>'."   ".$row['releasedate'] . '</b><br/><p>' . $row['summary'] . '</p><br/>';
	}
} else {
	echo 'Could not issue query';
}
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