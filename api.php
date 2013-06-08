<?php
define("TOKEN", "9jialu");
require_once("config.php");
header("Content-type: text/html; charset=utf-8");//头部
if (isset($_GET["action"])) {
	session_start();
	if($_GET["action"] == "login"){
		$uc = new User();
		$user = $uc->get_by_pass(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['pass']));
		if($user == null){
			header("Location: login.html#nouser");
			exit;
		}
		$_SESSION['user'] = $user;
		header("Location: admin.php");
	}
	if($_SESSION['user'] == null) die("403");

	switch ($_GET["action"]){
		case 'update_config_pass' :
			$uc = new User();
			$result = $uc->change_pass(htmlspecialchars($_POST['pass']), $_SESSION['user']);
			die($result);
		case 'key_create' :
			if(!isset($_POST['key']) || empty($_POST['type'])) die("no params");
			$m = new Keyword();
			$result = $m->create_keyword(htmlspecialchars($_POST['key']),
				htmlspecialchars($_POST['type']),
				htmlspecialchars($_POST['content']), 
				$_SESSION['user']['wid']);
			die($result);
		case 'key_update' :
			if(!isset($_POST['key']) || empty($_POST['type'])) die("no params");
			$m = new Keyword();
			$result = $m->update_keyword(htmlspecialchars($_POST['key']),
				htmlspecialchars($_POST['type']),
				htmlspecialchars($_POST['content']), 
				$_SESSION['user']['wid']);
			die($result);
		case 'key_delete' :
			if(!isset($_POST['key'])) die("no params");
			$m = new Keyword();
			$result = $m->delete_keyword(htmlspecialchars($_POST['key']), $_SESSION['user']['wid']);
			die($result);
		case 'image_create' :
			if(!isset($_POST['key'])) die("no params");
			$m = new Image();
			$result = $m->create_image(
				htmlspecialchars($_POST['key']),
				htmlspecialchars($_POST['title']),
				htmlspecialchars($_POST['content']),
				htmlspecialchars($_POST['url']), 
				$_SESSION['user']['wid']);
			die($result);
		case 'image_update' :
			if(!isset($_POST['id'])) die("no params");
			$m = new Image();
			$result = $m->update_image(
				htmlspecialchars($_POST['id']),
				htmlspecialchars($_POST['key']),
				htmlspecialchars($_POST['title']),
				htmlspecialchars($_POST['content']),
				htmlspecialchars($_POST['url']), 
				$_SESSION['user']['wid']);
			die($result);
		case 'image_delete' :
			if(empty($_POST['id'])) die("no params");
			$m = new Image();
			$result = $m->delete_image(htmlspecialchars($_POST['id']), $_SESSION['user']['wid']);
			die($result);
		case 'image_info' :
			if(empty($_GET['id'])) die("no params");
			$m = new Image();
			$result = $m->get_by_id(htmlspecialchars($_GET['id']));
			die(json_encode($result));
		case 'geo_create' :
			if(!isset($_POST['title'])) die("no params");
			$m = new Location();
			$result = $m->create_location(
				$_SESSION['user']['wid'],
				htmlspecialchars($_POST['title']),
				htmlspecialchars($_POST['content']),
				htmlspecialchars($_POST['x']), 
				htmlspecialchars($_POST['y']));
			die($result);
		case 'geo_update' :
			if(!isset($_POST['id'])) die("no params");
			$m = new Location();
			$result = $m->update_location(
				htmlspecialchars($_POST['id']),
				$_SESSION['user']['wid'],
				htmlspecialchars($_POST['title']),
				htmlspecialchars($_POST['content']),
				htmlspecialchars($_POST['x']), 
				htmlspecialchars($_POST['y']));
			die($result);
		case 'geo_delete' :
			if(empty($_POST['id'])) die("no params");
			$m = new Location();
			$result = $m->delete_location(htmlspecialchars($_POST['id']), $_SESSION['user']['wid']);
			die($result);
		case 'geo_info' :
			if(empty($_GET['id'])) die("no params");
			$m = new Location();
			$result = $m->get_by_id(htmlspecialchars($_GET['id']));
			die(json_encode($result));
	}
}  