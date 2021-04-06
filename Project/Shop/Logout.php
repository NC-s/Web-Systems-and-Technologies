<?php
	session_start();
	session_unset();
	setcookie("Token", "", time() - 1, "/");
	if(isset($_SERVER["HTTP_REFERER"])) {
		header('Location: '.$_SERVER["HTTP_REFERER"]);
	}
	else header("Location: MainPage.php");
	exit;
?>