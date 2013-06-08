<?php
if(!defined('TOKEN'))die('403');

function sendmsg($msg, $number){
	$sms = apibus::init("sms");
	$obj = $sms->send( $number, $msg , "UTF-8"); 
	if ( $sms->isError( $obj ) ) return false;
	return true;
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

function convertZoom($dis){
	if($dis <= 1){
		return 15;
	}else if($dis <= 2){
		return 14;
	}else if($dis <= 4){
		return 13;
	}else if($dis <= 8){
		return 12;
	}else if($dis <= 16){
		return 11;
	}else if($dis <= 32){
		return 10;
	}
}