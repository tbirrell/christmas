<?php

	require_once '../utilities/boot.php';
	
	if (!Auth::check()) {
		$_SESSION['back_to'] = '/';
		header('Location: /login.php');
		exit();
	}

	$select = "SELECT * FROM list WHERE for_user <> :for";

	$stmt = $dbc->prepare($select);
	$stmt->bindValue(':for', $_SESSION['id'], PDO::PARAM_INT);
	$stmt->execute();

	$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Christmas Lists</title>
</head>
<body>
<a href="/logout.php">Logout</a>
<?php var_dump($lists) ?>
</body>
</html>