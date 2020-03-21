<?php  
include('connection.php');
$pass_error = false;
$username = "";
$fullname = "";
$email = "";
$password = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$stmt = $db->prepare("INSERT INTO users (username, fullname, email, password) VALUES (?,?,?,?)");
	$stmt2= $db->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, password = ? WHERE id = ?");
	if ($_POST["pwd"] == $_POST["confirm_pwd"]) {
		header('Location: index.php');
		$username = $_POST["username"];
		$fullname = $_POST["fullname"];
		$email = $_POST["email"];
		$password = $_POST["pwd"];
		if (isset($_SESSION["user"])) 
			$stmt2->execute(array($username, $fullname, $email, $password, $_SESSION["user"]["id"]));	
		else 
			$stmt->execute(array($username, $fullname, $email, $password));
	} else {
		$pass_error = true;
	}
} else {
	if (isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
		$username = $user["username"];
		$fullname = $user["fullname"];
		$email = $user["email"];
		$password = $user["password"];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Blog - Registration Form</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>
		<?php include('header.php'); ?>

		<h2>User Details Form</h2>
		<h4>Please, fill below fields correctly</h4>
		<?= $pass_error ? "<h4 style='color: red'> Passwords are not equal </h4>" : "" ?>
		<form action="register.php" method="post">
				<ul class="form">
					<li>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?= $username ?>" required/>
					</li>
					<li>
						<label for="fullname">Full Name</label>
						<input type="text" name="fullname" id="fullname" value="<?= $fullname ?>" required/>
					</li>
					<li>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" value="<?= $email ?>"/>
					</li>
					<li>
						<label for="pwd">Password</label>
						<input type="password" name="pwd" id="pwd" value="<?= $password ?>" required/>
					</li>
					<li>
						<label for="confirm_pwd">Confirm Password</label>
						<input type="password" name="confirm_pwd" id="confirm_pwd" value="<?= $password ?>" required />
					</li>
					<li>
						<input type="submit" value="Submit" /> &nbsp; Already registered? <a href="index.php">Login</a>
					</li>
				</ul>
		</form>
	</body>
</html>