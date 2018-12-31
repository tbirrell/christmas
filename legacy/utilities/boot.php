<?php

	// session initialization
	// session_start();
	// $sessionId = session_id();

	// ini_set('display_errors', 1);

	require_once base_path('legacy/database/connect.php');
	require_once base_path('legacy/security/Auth.php');
	require_once base_path('legacy/utilities/Input.php');

	// if ($_SERVER['REQUEST_URI'] != '/login' && !Auth::check()) {
	// 	header('Location: /login');
	// 	exit();
	// }