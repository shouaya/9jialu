<?php
if(!defined('TOKEN'))die('403');
function startsWith($haystack, $needle){
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle){
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function distance($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {
	$theta = $longitude1 - $longitude2;
	$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) +
	(cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) *
	cos(deg2rad($theta)));
	$distance = acos($distance);
	$distance = rad2deg($distance);
	$distance = $distance * 60 * 1.1515;
	switch($unit) {
	case 'Mi': break;
	case 'Km' : $distance = $distance * 1.609344;
	}return (round($distance,2));
}

function midpoint ($begin, $end) {
	$bgeo = explode(",", $begin);
	$egeo = explode(",", $end);
    $lat1= deg2rad($bgeo[1]);
    $lng1= deg2rad($bgeo[0]);
    $lat2= deg2rad($egeo[1]);
    $lng2= deg2rad($egeo[0]);

    $dlng = $lng2 - $lng1;
    $Bx = cos($lat2) * cos($dlng);
    $By = cos($lat2) * sin($dlng);
    $lat3 = atan2( sin($lat1)+sin($lat2),
    sqrt((cos($lat1)+$Bx)*(cos($lat1)+$Bx) + $By*$By ));
    $lng3 = $lng1 + atan2($By, (cos($lat1) + $Bx));
    $pi = pi();
    return ($lat3*180)/$pi .','. ($lng3*180)/$pi;
}

function convertGeo($bgeo){
	$geo = explode(",", $bgeo);
	return $geo[1] . "," . $geo[0];
}

function convertRoute($broute){
	$points = explode("|", $broute);
	$groute = array();
	foreach($points as $point){
		$groute[] = convertGeo($point);
	}
	return join("|" , $groute);
}

function watermark($img, $watermark, $district = 0,$watermarkquality = 72)
{
	$imginfo = @getimagesize($img);
	$watermarkinfo = @getimagesize($watermark);
	$img_w = $imginfo[0];
	$img_h = $imginfo[1] + 72;
	$watermark_w = $watermarkinfo[0];
	$watermark_h = $watermarkinfo[1];
	if($district == 0) $district = rand(1,9);
	if(!is_int($district) OR 1 > $district OR $district > 9) $district = 9;
	switch($district)
	{
		case 1:
			$x = +5;
			$y = +5;
			break;
		case 2:
			$x = ($img_w - $watermark_w) / 2;
			$y = +5;
			break;
		case 3:
			$x = $img_w - $watermark_w - 5;
			$y = +5;
			break;
		case 4:
			$x = +5;
			$y = ($img_h - $watermark_h) / 2;
			break;
		case 5:
			$x = ($img_w - $watermark_w) / 2;
			$y = ($img_h - $watermark_h) / 2;
			break;
		case 6:
			$x = $img_w - $watermark_w;
			$y = ($img_h - $watermark_h) / 2;
			break;
		case 7:
			$x = +0;
			$y = $img_h - $watermark_h - 0;
			break;
		case 8:
			$x = ($img_w - $watermark_w) / 2;
			$y = $img_h - $watermark_h - 5;
			break;
		case 9:
			$x = $img_w - $watermark_w - 5;
			$y = $img_h - $watermark_h - 5;
			break;
	}
	switch ($imginfo[2]) {
		case 1:
			$im = @imagecreatefromgif($img); 
			break;
		case 2:
			$im = @imagecreatefromjpeg($img); 
			break;
		case 3:
			$im = @imagecreatefrompng($img); 
			break;
	}
	switch ($watermarkinfo[2]) {
		case 1:
			$watermark_logo = @imagecreatefromgif($watermark); 
			break;
		case 2:
			$watermark_logo = @imagecreatefromjpeg($watermark); 
			break;
		case 3:
			$watermark_logo = @imagecreatefrompng($watermark); 
			break;
	}
	if(!$im or !$watermark_logo) return false;
	$dim = @imagecreatetruecolor($img_w,$img_h);
	if(@imagecopy ($dim, $im, 0, 0, 0, 0,$img_w, $img_h))
	{
		imageCopy($dim, $watermark_logo, $x, $y, 0, 0, $watermark_w, $watermark_h);
	}
	ob_start();
	$result = imagejpeg ($dim, null, $watermarkquality);
	$imgstr = ob_get_contents();
	ob_end_clean();
	//$file = dirname($img) . '/water_' . $district . '_' . basename($img);
	//$result = imagejpeg ($dim, $file, $watermarkquality);
	imagedestroy($watermark_logo);
	imagedestroy($dim);
	imagedestroy($im);
	if($result)
	{
		return $imgstr;
	}
	else 
	{
		return false;
	}
}

function randpass(){
	srand((double)microtime()*1000000);
	$ychar="0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
	$list=explode(",",$ychar);
	for($i=0;$i<6;$i++){
		$randnum=rand(0,35);
		@$authnum.=$list[$randnum];
	}
	return $authnum;
}