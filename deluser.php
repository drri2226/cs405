
<?php

session_start();

if(!isset($_SESSION['priv']) ){
	header("Location: /homepage.php");
}
elseif($_SESSION['priv']!=1) {
	header("Location: /homepage.php");
}

require 'managerconnect.php';

if(!isset($_POST['delete'])){
	$idtoquery = $_GET['id'];
	$query = "SELECT * FROM users WHERE uid = '$idtoquery'";

	$response = @mysqli_query($dbc, $query);

	if($response){
		while($row = mysqli_fetch_array($response)){
			$message = "Are you sure you want to delete" .'<br/>'.
			'<b>' .$row['uname'] . '</b><p>';
		}
	} else {
		echo 'Could not find movie';
	}
}else{
	$idtoquery = $_GET['id'];
	$query1 = "DELETE FROM review WHERE uid = '$idtoquery'";
	$query2 = "DELETE FROM watchlist WHERE uid = '$idtoquery'";
	$query3 = "DELETE FROM users WHERE uid = '$idtoquery'";


	if(mysqli_query($dbc, $query1)  &&  mysqli_query($dbc, $query2) &&
	   mysqli_query($dbc, $query3)){
    echo "Records were deleted successfully.";
	header("Location: /deleteuser.php");
	} else{
    echo "ERROR: Could not delete records. ". mysqli_error($dbc);
	}
}
mysqli_close($dbc);
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="confirmstyles.css" type="text/css" rel="stylesheet"/>
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
	<form action="deluser.php?id=<?php echo $idtoquery; ?>" method="POST">						
		<input type="submit" name="delete" value='DELETE'>
	</form>
	<form action="toadd.php" method="POST">						
		<input type="submit" name="return" value='Return'>
	</form>
	</div>
</body>
</html>