<?php
include('connection.php');
$login_error = false;
$username = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!isset($_POST["id"])) {
		$username =  isset($_POST["username"]) ? $_POST["username"] : NULL;
		$password = isset($_POST["pwd"]) ? $_POST["pwd"] : NULL;
		$remember = $_POST["remember"];
		
		$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		if ($user != NULL && $password == $user["password"]) {
			$_SESSION["user"] = $user;
		} else {
			$login_error = true;
		}
		if ($remember) {
			setcookie("username", $username, time()+60*60*24*365); 
		} else {
			setcookie("username", $username, time()-1);
		}
	} else {
		$id = $_POST["id"];
		$title = $_POST["title"];
		$body = $_POST["body"];
		$stmt = $db->prepare("INSERT INTO posts (title, body, publishDate, userId) VALUES (?,?,?,?)");
		$stmt->execute(array($title, $body, date("Y-m-d"), $id));
	}
} else {
	$logout = isset($_GET["logout"]) ? $_GET["logout"] : NULL;
	$username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : "";
	if ($logout == 1) {
		session_destroy();
		header('Location: index.php');		
	}
}
$rows = $db->query("SELECT * FROM posts");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Personal Page</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>

		
	<body>
		<?php include('header.php'); ?>
		<?= $login_error ? "<h4 style='color: red; align: center'> Login or password is not correct!</h4>" : "" ?>

		<!-- Show this part if user is not signed in yet -->
		<div class="twocols" style="<?= isset($_SESSION["user"]) ? 'display: none': '' ?>">
			<form action="index.php" method="post" class="twocols_col">
				<ul class="form">
					<li>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?=$username ?>" />
					</li>
					<li>
						<label for="pwd">Password</label>
						<input type="password" name="pwd" id="pwd" />
					</li>
					<li>
						<label for="remember">Remember Me</label>
						<input type="checkbox" name="remember" id="remember" checked />
					</li>
					<li>
						<input type="submit" value="Submit" /> &nbsp; Not registered? <a href="register.php">Register</a>
					</li>
				</ul>
			</form>
			<div class="twocols_col">
				<h2>About Us</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur libero nostrum consequatur dolor. Nesciunt eos dolorem enim accusantium libero impedit ipsa perspiciatis vel dolore reiciendis ratione quam, non sequi sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nobis vero ullam quae. Repellendus dolores quis tenetur enim distinctio, optio vero, cupiditate commodi eligendi similique laboriosam maxime corporis quasi labore!</p>
			</div>
		</div>
		
		<!-- Show this part after user signed in successfully -->
		<div style="<?= !isset($_SESSION["user"]) ? 'display: none': '' ?>">
			<div class="logout_panel"><a href="register.php">My Profile</a>&nbsp;|&nbsp;<a href="index.php?logout=1">Log Out</a></div>
			<h2>New Post</h2>
			<form action="index.php" method="post">
				<ul class="form">
					<input type="hidden" name="id" value="<?=$_SESSION["user"]["id"] ?>" />
					<li>
						<label for="title">Title</label>
						<input type="text" name="title" id="title" />
					</li>
					<li>
						<label for="body">Body</label>
						<textarea name="body" id="body" cols="30" rows="10"></textarea>
					</li>
					<li>
						<input type="submit" value="Post" />
					</li>
				</ul>
			</form>
		</div>
		
		<div class="onecol">
			<?php foreach ($rows as $row) { ?>
				<div class="card">
					<h2><?=$row["title"] ?></h2>
					<h5><?=$row["publishDate"] ?></h5>
					<p><?=$row["body"] ?></p>
				</div>
			<?php } ?>
		</div>
	</body>
</html>