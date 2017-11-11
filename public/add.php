<?php
	require_once '../utilities/boot.php';
	var_dump($_SESSION);

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

	function get_list($dbc)
	{
		$select = "SELECT * FROM list WHERE for_user = :for";

		$stmt = $dbc->prepare($select);
		$stmt->bindValue(':for', $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	$list = get_list($dbc);
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Items</title>
	<?php require '../module/styles.php'; ?>
	<style>
		.remove {
			width: 10%;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php require '../module/nav.php'; ?>
		<div class="row">
			<form method="post">
				<div class="form-group">
					<label>
						Name of Item
						<input class="form-control" type="text" name="name">
					</label>
				</div>
				<div class="form-group">
					<label>
						Link (if available)
						<input class="form-control" type="text" name="link">
					</label>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
		<div class="row">
			<table class="table table-bordered table-striped">
				<tr>
					<th class="item">Item</th>
					<th class="remove">Remove</th>
				</tr>	
				<?php foreach ($list as $item) : ?>
					<tr id="row-<?= $item['id'] ?>">
						<?php if ($item['link'] != null) : ?>
							<td class="item"><a href="<?= $item['link'] ?>"><?= $item['name'] ?></a></td>
						<?php else : ?>
							<td class="item"><?= $item['name'] ?></td>
						<?php endif; ?>
						<td class="remove"><button class="btn btn-danger btn-remove" id="<?= $item['id'] ?>">Remove</button></td>
					</tr>
				<?php endforeach; ?>	
			</table>
		</div>
	</div>

<?php require '../module/scripts.php'; ?>
<script>
	$('.btn-remove').on('click', function(){

		var id = $(this).attr('id');
		$.ajax({
			url: '/ajax/ajax.php',
			method: 'post',
			data: {
				action: 'remove',
				id,
			}
		}).done(function(){
			$('#row-' + id).remove();
		});

	});
</script>
</body>
</html>