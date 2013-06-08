<?php 
define("TOKEN", "9jialu");
require_once("config.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_GET['id'])) die("404");
$id = htmlspecialchars($_GET['id']);
$image = new Image();
$post = $image->get_by_id($id);
echo template_m($post['title'], $post['img'], $post['content']);
?>