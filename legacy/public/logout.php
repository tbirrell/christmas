<?php
	require_once '../utilities/boot.php';

	Auth::logout();

	header('Location: /login.php');
	exit();