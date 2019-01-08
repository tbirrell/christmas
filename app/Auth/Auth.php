<?php

class MyAuth {

	public static function attempt($username, $password, $dbc) {
		$select = "SELECT id, password FROM users WHERE username = :username";

		$stmt = $dbc->prepare($select);

		$stmt->bindValue(':username', $username, PDO::PARAM_STR);

 		$stmt->execute();

		$credentials = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (password_verify($password, $credentials[0]["password"])) {
			$_SESSION["id"] = $credentials[0]["id"];
			$_SESSION["username"] = $username;
			return true;
		} else {
			return false;
		}
	}
	public static function check() {
		if (isset($_SESSION["id"])) {
			return true;
		} else {
			return false;
		}
	}
	public static function user() {
		if (self::check()) {
			return $_SESSION["username"];
		}
	}
	public static function logout() {
		$_SESSION = array();
		session_destroy();
	}
}