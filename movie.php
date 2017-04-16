<!DOCTYPE html>

<?php

session_start();

require 'managerconnect.php';

	$idtoquery = $_GET['id'];
	$query = "SELECT * FROM movies AS m WHERE m.mvid = '$idtoquery'";

	$response = @mysqli_query($dbc, $query);

	if($response){
		while($row = mysqli_fetch_array($response)){
			echo '<br/><b>' .$row['title'] . '</b><p>' .
			"Released:    " . $row['releasedate'] .  '<br/>' .
			"Summary:    " . $row['summary'] . '<br/>'.
			"Language:    " . $row['lang'] . '<br/>'.
			"Duration:    " . $row['duration'].'</p>';
		}
	} else {
		echo 'Could not find movie';
	}

	$query2 = "SELECT * FROM tags WHERE mvid = $idtoquery";
	$response2 = @mysqli_query($dbc, $query2);

	if($response2){
		echo '<br/> <b>Tags</b> <br/>';
		while($row = mysqli_fetch_array($response2)){
			echo '<p>' .$row['tag'] . '</p>';
		}
	} else {
		echo 'Could not find tags';
	}

	$query3 = "SELECT * FROM review WHERE mvid = '$idtoquery'";
	$response3 = @mysqli_query($dbc, $query3);

	if($response3){
		echo '<br/> <b>Reviews</b> <br/>';
		while($row = mysqli_fetch_array($response3)){
			$uid = $row['uid'];  
			$query4= "SELECT * FROM users WHERE uid = '$uid'";
			$response4 = @mysqli_query($dbc, $query4);
			$row2=mysqli_fetch_array($response4);
			echo '<b> Username' .$row2['uname'] . '</b>'.'</br>'.
			'<p> Score:  ' . $row['rating'].'</br>'.
			'Review : </br>'. $row['rcomment'].'</br>';
		}
	} else {
		echo 'Could not find reviews';
	}








if(isset($_POST['gettag'])){
	echo '<form action="movie.php?id='.$idtoquery.'" method="post"> 
		<input type="text" name="tag" placeholder="Tag movie">
		<input type="submit" value="Go">
		</form>';	
}

if(isset($_POST['tag'])){
	$tagtoadd = $_POST['tag'];
	$query = "INSERT INTO tags (mvid, tag) VALUES ('$idtoquery','$tagtoadd')";	
	mysqli_query($dbc, $query);
}

if(isset($_POST['getreview'])){
	echo '<form action="movie.php?id='.$idtoquery.'" method="post"> 
		<input type="text" name="review" placeholder="Review">
		<input type="text" name="score" placeholder="Score out of 5">
		<input type="submit" value="Review">
		</form>';	
}

if(isset($_POST['review'])&&isset($_POST['score'])){
	$reviewtoadd = $_POST['review'];
	$scoretoadd = $_POST['score'];
	$uid = $_SESSION['user_id'];
	$query1 = "SELECT * FROM review WHERE uid='$uid' AND mvid='$idtoquery'";
	$response = mysqli_query($dbc, $query1);
	if(mysqli_num_rows($response)>0){
		$query2 = "DELETE FROM review WHERE uid='$uid' AND mvid='$idtoquery'";
		mysqli_query($dbc, $query2);
	}
	$query = "INSERT INTO review (uid, mvid, rating, rcomment) VALUES ('$uid','$idtoquery' ,'$scoretoadd','$reviewtoadd')";
	echo $query;	
	mysqli_query($dbc, $query);
	echo mysqli_error($dbc);
}

if(isset($_POST['wlist'])){
	$movietoadd = isset($_POST['wlist']);
	$uid= $_SESSION['user_id'];
	$query = "INSERT INTO watchlist (uid, mvid) VALUES ('$uid','$idtoquery' )";	
	mysqli_query($dbc, $query);
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
			<input type="text" name="search" placeholder="Search for a movie to...">
			<select name = "Search">
				<option value= "Title">Title</option>
				<option value =	"Genre">Genre</option>
				<option value="Tags">Tag</option>
				<option value="Crew Member">Cast Member</option> 
			</select>
			<input type="submit" value="Go">
		</form>
	</div>
	<?php 
		if(isset($_SESSION['user_id'])){
			echo '
	<form action="movie.php?id='.$idtoquery.'" method="POST">						
		<input type="submit" name="gettag" value="Add Tag">
	</form>
	<form action="movie.php?id='.$idtoquery.'" method="POST">					
		<input type="submit" name="getreview" value="Review">
	</form>
	<form action="movie.php?id='.$idtoquery.'" method="POST">					
		<input type="submit" name="wlist" value="WatchList">
	</form>';
		}
		?>
</body>
</html>