<?php

	// session initialization
	session_start();
	$sessionId = session_id();

	ini_set('display_errors', 1);

	require_once '../database/connect.php';
	require_once '../security/Auth.php';
	require_once '../utilities/Input.php';