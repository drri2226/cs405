
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
	
	$message = "Records were updated successfully".'</br>'."Now update Tags, Crew and Genre";
	$idtoquery = $_GET['id'];
	$query1 = "SELECT * FROM tags WHERE mvid = '$idtoquery'";
	$query2 = "SELECT *  FROM crew, moviecrew WHERE moviecrew.mvid = '$idtoquery' AND moviecrew.cid = crew.cid";
	$query3 = "SELECT * FROM moviegenre, genre WHERE moviegenre.mvid = '$idtoquery' AND genre.gid = moviegenre.gid";

	$response1 = @mysqli_query($dbc, $query1);
	$response2 = @mysqli_query($dbc, $query2);
	$response3 = @mysqli_query($dbc, $query3);

	if($response1){
		$tags = "";
		while($row1 = mysqli_fetch_array($response1)){
			$tag =  $row1['tag'];
			$tags .= $tag." , ";
		}
		
		$tags = "\"".substr($tags, 0, -3)."\"";
	} else {
		echo 'Could not find movie';
	}

	if($response2){
		$cast = "";
		while($row2 = mysqli_fetch_array($response2)){
			$member = "( " .$row2['cname'] ." , " . $row2['role']. " )";
			$cast.= $member." ";
		}
		$cast = "\"".substr($cast, 0, -1)."\"";
	} else {
		echo 'Could not find movie';
	}


	if($response3){
		$genres = "";
		while($row3 = mysqli_fetch_array($response3)){
			$genre =  $row3['gname'];
			$genres .= $genre." , ";
		}
		
		$genres = "\"".substr($genres, 0, -3)."\"";	
	} else {
		echo 'Could not find movie';
	}

}else{
	$idtoquery = $_GET['id'];
	$newtags = $_POST['tags'];
	$newgenre = $_POST['genre'];
	$newcrew = $_POST['crew'];

	$query1 ="DELETE FROM tags WHERE mvid = $idtoquery";
	mysqli_query($dbc, $query1);
	$indtags = explode(" , ", $newtags);
	foreach($indtags as $thistag){
		echo $thistag;
		$query2 = "INSERT INTO tags (mvid,  tag) VALUES ('$idtoquery', '$thistag')";
		echo $query2;
		mysqli_query($dbc, $query2);
	}

	$query2 ="DELETE FROM moviecrew WHERE mvid = $idtoquery";
	mysqli_query($dbc, $query2);
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



	$query3 ="DELETE FROM moviegenre WHERE mvid = $idtoquery";
	mysqli_query($dbc, $query3);
	$indgenre = explode(" , ", $newgenre);
	foreach($indgenre as $thisgenre){
		echo $thisgenre;
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

	header("Location: /updatemovies.php");
}
mysqli_close($dbc);
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="searchstyles3.css" type="text/css" rel="stylesheet"/>
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
		<form action="updatemore.php?id=<?php echo $idtoquery; ?>" method="POST">
		<input type="text" placeholder="Tags" name="tags" value=<?php echo $tags ?>>
		<input type="text" placeholder="Crew" name="crew" value=<?php echo $cast; ?>>
		<input type="text" placeholder="Genre" name="genre" value=<?php echo $genres; ?>>			
		<input type="submit" name='update' value="UPDATE">

	</form>

	<form action="updatemovies.php" method="POST">						
		<input type="submit" name="return" value='Return'>
	</form>
	</div>
</body>
</html>