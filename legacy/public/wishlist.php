<?php
	// require_once '../utilities/boot.php';

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
		$stmt->bindValue(':for', Auth::user()->id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	$list = get_list($dbc);
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Items</title>
	<?php base_path('legacy/module/styles.php'); ?>
	<style>
		.remove {
			width: 10%;
		}
		.panel {
			margin-bottom: 0px;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php base_path('legacy/module/nav.php'); ?>
		<div class="row">
		<h3>Add Item</h3>
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
					<th class="remove">Edit</th>
					<th class="remove">Remove</th>
				</tr>	
				<?php foreach ($list as $item) : ?>
					<tr id="row-<?= $item['id'] ?>" data-id="<?= $item['id'] ?>" data-name="<?= $item['name'] ?>" data-link="<?= $item['link'] ?>">
						<?php if ($item['link'] != null) : ?>
							<td class="item"><a href="<?= $item['link'] ?>"><?= $item['name'] ?></a></td>
						<?php else : ?>
							<td class="item"><?= $item['name'] ?></td>
						<?php endif; ?>
						<td class="remove"><button type="button" class="btn btn-warning btn-edit" data-toggle="modal" data-target=".edit-item">Edit</button></td>
						<td class="remove"><button class="btn btn-danger btn-remove" id="<?= $item['id'] ?>">Remove</button></td>
					</tr>
				<?php endforeach; ?>	
			</table>
		</div>
	</div>


<div class="modal fade edit-item" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="panel panel-default">
			  <div class="panel-heading">Edit Item</div>
			  <div class="panel-body">
			    <form method="post">
						<div class="form-group">
							<label>
								Name
								<input class="form-control" type="text" name="name" id='edit-input-name'>
							</label>
						</div>
						<div class="form-group">
							<label>
								Link
								<input class="form-control" type="text" name="link" id='edit-input-link'>
							</label>
			  		</div>
			  		<input type="hidden" name="edit-id" id='edit-input-id'>
					</form>
				</div>
		  	<div class="panel-footer"><button class="btn btn-primary save-item">Save</button></div>
			</div>
    </div>
  </div>
</div>

<?php base_path('legacy/module/scripts.php'); ?>
<script>
	$('.btn-remove').on('click', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: '/ajax/ajax.php',
			method: 'post',
			data: {
				action: 'remove',
				id
			}
		}).done(function(){
			$('#row-' + id).remove();
		});
	});

	$('.btn-edit').on('click', function(){
		var parent = $(this).parent().parent();
		var item = $(parent).attr('data-name');
		var link = $(parent).attr('data-link');
		var id = $(parent).attr('data-id');
		console.log(id);
		$('#edit-input-name').val(item);
		$('#edit-input-link').val(link);
		$('#edit-input-id').val(id);
	});

	$('.save-item').on('click', function(){
		var newName = $('#edit-input-name').val();
		var newLink = $('#edit-input-link').val();
		var id = $('#edit-input-id').val();
		console.log(id);
		$.ajax({
			url: '/ajax/ajax.php',
			method: 'post',
			data: {
				action: 'edit',
				newName,
				newLink,
				id,
			}
		}).done(function(){
			window.location = window.location.href;
		});
	});
</script>
</body>
</html>