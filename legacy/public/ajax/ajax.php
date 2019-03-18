<?php
	if(!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
	{    
	  echo "This is an AJAX endpoint";  
	}
	

	// require_once '../../utilities/boot.php';

	if (Input::has('action') && Input::get('action') == 'claim') {
		$id = Input::get('id');
		if (Input::get('checked') == 'true') {
			$claimed = Input::get('who');
		} else {
			$claimed = null;
		}

		echo gettype(Input::get('id'));

		$update = "UPDATE list SET claimed = :claimed WHERE id = :id";

		$stmt = $dbc->prepare($update);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':claimed', $claimed, PDO::PARAM_INT);

 		$result = $stmt->execute();
	}	
	
	if (Input::has('action') && Input::get('action') == 'remove') {
		$id = Input::get('id');

		$update = "UPDATE list SET for_user = 0 WHERE id = :id";

		$stmt = $dbc->prepare($update);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

 		$result = $stmt->execute();
	}

	if (Input::has('action') && Input::get('action') == 'edit') {

		$id = Input::get('id');
		$name = Input::get('newName');
		$link = Input::get('newLink');

		$update = "UPDATE list SET name = :name, link = :link WHERE id = :id";

		$stmt = $dbc->prepare($update);

		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':link', $link, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

 		$result = $stmt->execute();
	}