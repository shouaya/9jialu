<?php
session_start();
if($_SESSION['user'] == null){
	header("Location: ../login.html#timeout");
	exit;
}
?>
建设中。。。