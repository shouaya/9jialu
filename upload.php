<?php
define("TOKEN", "9jialu");
require_once("weixin/config.php");

$verifyToken = md5('unique_salt' . $_POST['timestamp']);
if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

	$userfile_tmp = $_FILES["Filedata"]["tmp_name"];
    $filename = basename($_FILES["Filedata"]["name"]);  
    $file_ext = substr($filename, strrpos($filename, ".") + 1);  
 
	if (isset($_FILES["Filedata"]["name"])){
		$imgstr = file_get_contents($userfile_tmp); 
		$img = new SaeImage($imgstr);
		$img->resize(268);
		$fname =  time() . "." . $file_ext;
		file_put_contents(SAE_TMP_PATH . '/' . $fname , $img->exec());
		if($pic = watermark(SAE_TMP_PATH . '/' . $fname, PICURL . '/qrcode_mini.jpg', 7)){
			$s = new SaeStorage();
			$url = $s->write('img' , $fname, $pic);
			if($url) echo $url;
		}
	}
}