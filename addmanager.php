<?php
	session_start();

if(!isset($_SESSION['priv']) ){
	header("Location: /homepage.php");
}
elseif($_SESSION['priv']!=1) {
	header("Location: /homepage.php");
}

require 'guestconnect.php';
?>


<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="searchstyle.css" type="text/css" rel="stylesheet"/>
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
			<form action="addmanager.php" method="post">
				<input type="text" name="search" placeholder="Search for user to add...">
				<input type="submit" value="Go">
			</form>
			</div>
		</div>
	<div class="query">
<?php
if(isset($_POST['search'])){
	$tosearch = $_POST['search'];
	$query = "SELECT * FROM users  WHERE uname LIKE '%$tosearch%' COLLATE utf8_general_ci";


	$response = @mysqli_query($dbc, $query);

if($response){
	while($row = mysqli_fetch_array($response)){
				echo '<div class="results">';
				echo '<b><a href="addman.php?id='.$row['uid'] .'">'. $row['uname'] .'</a></b><br/>';
				echo '</div>';
	}
} else {
	echo 'Could not issue query';
}
}
mysqli_close($dbc);	

?>
</div>
</body>
</html>