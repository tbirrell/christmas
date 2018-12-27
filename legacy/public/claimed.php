<?php
	require_once '../utilities/boot.php';

	$today = date('Y-m-d');

	//get items
	$select = "SELECT l.name, l.link, l.expire, u.username #select all
						 FROM `list` l #from the list table'
						 JOIN users u on l.for_user = u.id
						 WHERE l.claimed = :user #where the item was claimed by current user
						 AND for_user <> 0 #but does not belong to the special admin because thats being used as a deletion tool right now
						 AND (
						 		l.expire > :expire 
	 						  OR l.expire IS NULL
						 )";

	$stmt = $dbc->prepare($select);
	$stmt->bindValue(':user', $_SESSION['id'], PDO::PARAM_INT);
	$stmt->bindValue(':expire', $today, PDO::PARAM_STR);
	$stmt->execute();

	$claimed = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Claimed Gifts</title>
	<?php require '../module/styles.php'; ?>
</head>
<body>
<div class="container">
	<?php require '../module/nav.php'; ?>
	
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th class="item">Item</th>
				<th class="claimed">For</th>
			</tr>	
		</thead>
		<?php foreach ($claimed as $item) : ?>
			<?php if (!is_array($item)) continue; ?>
			<tr>
				<?php if ($item['link'] != null) : ?>
					<td class="item"><a href="<?= $item['link'] ?>"><?= $item['name'] ?></a></td>
				<?php else : ?>
					<td class="item"><?= $item['name'] ?></td>
				<?php endif; ?>
				<td class="for">
					<?= ucfirst($item['username']) ?>
				</td>
			</tr>
		<?php endforeach; ?>	
	</table>
</div>
</body>
</html>