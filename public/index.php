<?php
	require_once '../utilities/boot.php';

	//id of person to focus for bdays
	$bday = 5;

	$today = date('Y-m-d');

	$select = "SELECT * 
						 FROM `list` 
						 WHERE for_user <> :for 
						 AND for_user <> 0
						 AND (
						 		claimed IS NULL
								OR expire > :expire 
						 )";

	$stmt = $dbc->prepare($select);
	$stmt->bindValue(':for', $_SESSION['id'], PDO::PARAM_INT);
	$stmt->bindValue(':expire', $today, PDO::PARAM_STR);
	$stmt->execute();

	$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$select = "SELECT * FROM users WHERE id != 0 AND id != :id";

	$stmt = $dbc->prepare($select);
	$stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
	$stmt->execute();

	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$people = [];
	foreach ($users as $user) {
		$people[$user['id']]['name'] = $user['username'];
	}
	foreach ($lists as $item) {
		$people[$item['for_user']][] = $item;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Birthday Lists</title>
<?php require '../module/styles.php'; ?>
<style>
	.claimed {
		width: 10%;
	}
	.tab-content {
		margin-top: 20px;
	}
</style>
</head>
<body>
<div class="container">
	<?php require '../module/nav.php'; ?>
	<div>
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	  	<?php $first = 'active' ?>
		  <?php foreach ($people as $id => $person) : ?>
					<?php
						//coopt $first for bday in question
						if ($id == $bday) {
							$first = 'active';
						} else {
							$first = '';
						}
					?>
		    <li role="presentation" class="<?= $first ?>"><a href="#tab-<?= $id ?>" role="tab" data-toggle="tab"><?= ucfirst($person['name']) ?></a></li>
		    <?php $first = '' ?>
			<?php endforeach; ?>	
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	  	<?php $first = 'active' ?>
			<?php foreach ($people as $id => $person) : ?>
          <?php
          //coopt $first for bday in question
          if ($id == $bday) {
              $first = 'active';
          } else {
              $first = '';
          }
          ?>
	    	<div role="tabpanel" class="tab-pane <?= $first ?>" id="tab-<?= $id ?>">
					<table class="table table-bordered table-striped">
						<tr>
							<th class="item">Item</th>
							<th class="claimed">Claimed</th>
						</tr>	
						<?php foreach ($person as $item) : ?>
							<?php if (!is_array($item)) continue; ?>
							<tr>
								<?php if ($item['link'] != null) : ?>
									<td class="item"><a href="<?= $item['link'] ?>"><?= $item['name'] ?></a></td>
								<?php else : ?>
									<td class="item"><?= $item['name'] ?></td>
								<?php endif; ?>
								<?php if($item['claimed'] == $_SESSION['id']) : ?>
									<td class="claimed"><input class="checkbox" type="checkbox" id="<?= $item['id'] ?>" name="" checked></td>
								<?php elseif ($item['claimed'] != null && $item['claimed'] != 0) : ?>
									<td class="claimed"><input class="checkbox" type="checkbox" id="<?= $item['id'] ?>" name="" checked disabled></td>
								<?php else : ?>
									<td class="claimed"><input class="checkbox" type="checkbox" id="<?= $item['id'] ?>" name=""></td>
								<?php endif; ?>
							</tr>
							<?php $first = '' ?>
						<?php endforeach; ?>	
					</table>
		  	</div>
			<?php endforeach; ?>
		</div>
</div>
<input type="hidden" name="me" id="me" data-me="<?= $_SESSION['id'] ?>">

<?php require '../module/scripts.php'; ?>
<script>
	$(".checkbox").on('change',function() {
		if ($(this).is(':checked')) {
    	save($(this).attr('id'), true);
		} else {
    	save($(this).attr('id'), false);
		}
	});
	function save(id, checked) {
		var who = $('#me').attr('data-me');
		$.ajax({
			url: '/ajax/ajax.php',
			method: 'post',
			data: {
				action: 'claim',
				id,
				who,
				checked
			}
		})
	}
</script>
</body>
</html>