<?php
	session_start();
?>

<DOCTYPE html>
<html>
<head>
	<title>CS 405 Project</title>
	<link href="homepage.css" type="text/css" rel="stylesheet"/>
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
			<form action="search.php" method="post">
				<input type="text" name="search" placeholder="Search movies...">
				<div class="searching">
				<select name = "Search" placeholder="Search By">
					<option value= "Title">Title</option>
					<option value =	"Genre">Genre</option>
					<option value="Tags">Tag</option>
					<option value="Crew Member">Cast Member</option> 
				</select>
				</div>
				<input type="submit" value="Go">
			</form>
			</div>
		</div>
</body>
</html>