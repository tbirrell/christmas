<?php 
	require_once '../utilities/boot.php';
	var_dump($_SESSION);
	if (Input::has('username')) {
		$username = Input::get('username');
		$password = Input::get('password');

		$authorized = Auth::attempt($username, $password, $dbc);

		if ($authorized) {
			header('Location: ' . $_SESSION['back_to']);
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
<form method="post">
	<input type="text" name="username">
	<input type="password" name="password">
	<input type="submit" name="submit">
</form>
</body>
</html>