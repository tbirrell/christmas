<?php

	// session initialization
	session_start();
	$sessionId = session_id();

	// ini_set('display_errors', 1);
	$base = $_SERVER['DOCUMENT_ROOT'];


	require_once $base . '/../database/connect.php';
	require_once $base . '/../security/Auth.php';
	require_once $base . '/../utilities/Input.php';

	if ($_SERVER['REQUEST_URI'] != '/login.php' && !Auth::check()) {
		header('Location: /login.php');
		exit();
	}