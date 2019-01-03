<?php 
	// require_once '../utilities/boot.php';

	$username = Auth::user()->username;

	if (Input::has('old_pass') && Auth::attempt($username, Input::get('old_pass'), $dbc)) {
		$password = password_hash(Input::get('new_pass'), PASSWORD_DEFAULT);
		$update = "UPDATE users SET password = :password WHERE username = :username";

		$stmt = $dbc->prepare($update);

		$stmt->bindValue(':password', $password, PDO::PARAM_STR);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);

 		$result = $stmt->execute();
	}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<?php require base_path('legacy/module/styles.php'); ?>
</head>
<body>
	<div class="container">
		<?php require base_path('legacy/module/nav.php'); ?>
		<?php if (isset($result) && $result) : ?>
			<div>
				Password change successful
			</div>
		<?php endif; ?>
		<form method="post">
			<div class="form-group">
				<label>
					Old Password
					<input class="form-control" type="text" name="old_pass" id="old_pass">
				</label>
			</div>
			<div class="form-group">
				<label>
					New Password
					<input class="form-control" type="text" name="new_pass" id="new_pass">
				</label>
			</div>
			<div class="form-group">
				<label>
					Confirm Password
					<input class="form-control" type="text" name="confirm_pass" id="confirm_pass">
				</label>
			</div>
		</form>
		<button class="btn btn-primary">Submit</button>
	</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script>
	$('button').on('click', function(){
		var newPass = $('#new_pass').val();
		var confirm = $('#confirm_pass').val();
		if (newPass == confirm) {
			$('form').submit();
		} else {
			alert('Passwords do not match');
		}
	});
</script>
</body>
</html>