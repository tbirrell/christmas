<?php
	require_once '../utilities/boot.php';

	if (Input::has('name')) {
		$name = Input::get('name');
		$link = Input::get('link');
		$for = $_SESSION['id'];

		$insert = "INSERT INTO list (name, link, for_user)
													VALUES (:name, :link, :for)";

		$stmt = $dbc->prepare($insert);

		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':link', $link, PDO::PARAM_STR);
		$stmt->bindValue(':for',  $for,  PDO::PARAM_INT);
		
 		$stmt->execute();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Item</title>
</head>
<body>
<form method="post">
	<label>
		Name of Item
		<input type="text" name="name">
	</label>
	<br>
	<label>
		Link (if available)
		<input type="text" name="link">
	</label>
	<br>
	<input type="submit" name="submit">
</form>
</body>
</html>