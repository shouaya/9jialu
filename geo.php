<?php 
define("TOKEN", "9jialu");
require_once("config.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_GET['id'])||empty($_GET['x'])||empty($_GET['y'])) die("404");
$id = htmlspecialchars($_GET['id']);
$x = htmlspecialchars($_GET['x']);
$y = htmlspecialchars($_GET['y']);
//htmlspecialchars($_GET['dis']);
$location = new Location();
$geo = $location->get_by_id($id);

if($dis > 20){
	$pic_url  = "http://maps.google.com/maps/api/staticmap?center=" . $geo['Location_X'] . "," . $geo['Location_Y'];
	$pic_url .= "&size=500x500&zoom=13&sensor=false&markers=color:blue%7Clabel:S%7C" . $geo['Location_X'] . "," . $geo['Location_Y'];
}else{
	$begin = $y . "," . $x;
	$end = $geo['Location_Y'] . "," . $geo['Location_X'];
	$dis = distance($y, $x, $geo['Location_Y'], $geo['Location_X'], "Km");
	$SaeLocationObj = new SaeLocation();
	$drive_route_arr = array('begin_coordinate'=>$begin,'end_coordinate'=>$end);
	$drive_route = $SaeLocationObj->getBusRoute($drive_route_arr);
	$mid = midpoint($begin,$end);
	$pic_url  = "http://maps.google.com/maps/api/staticmap?center=" . convertGeo($mid);
	$pic_url .= "&size=500x500&zoom=" . convertZoom($dis);
	//$pic_url .= "&path=color:0x0000ff|weight:5|". convertRoute($drive_route['drive_coordinates']);
	$pic_url .= "&markers=color:blue%7Clabel:S%7C" . convertGeo($begin);
	$pic_url .= "&markers=color:blue%7Clabel:S%7C" . convertGeo($end);
	$pic_url .= "&sensor=false";
	//echo $dis;
}
$useful_bus = 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>酒家路 - <?php echo $geo['title'] ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
</head>
<div class="logo">
    <a><img src="image/Original_without_effects_204x75.png"></a>
</div>
<div class="content">
	<div class="wrap">
			<?php if($dis > 20){?>
				<div class='post-info'><?php echo "由于路途较远，推荐路线只在20公里范围内有效。"?></div>
			<?php } else { ?>
				<?php if(!empty($drive_route)) {?>
					<br/>
					<h4><?php echo "目的地：". $geo['title'] ?></h4>
					<?php foreach($drive_route['transfers'] as $transfer) {?>
						<?php if($useful_bus < 1) {?>
							<div class="post">
							<?php if($transfer['nav_count'] != "1"){//有换乘 ?>
								<?php foreach($transfer['lines'] as $line) {?>
									<div class="post-info"><?php echo $line['name'] ?></div>
									<?php if(is_array($line['stations']) && count($line['stations']) > 0){ ?>
										<?php $count = count($line['stations']);?>
										<div class="post-info">--> <?php echo $line['stations'][0]['name'] ?></div>
										<div class="post-info">--> <?php echo $line['stations'][$count - 1]['name'] ?><a>(共<?php echo $count ?>站)</a></div>
									<?php }?>
								<?php }?>
							<?php } else {?>
								<div class="post-info"><?php echo $transfer['lines']['name'] ?></div>
								<?php if(is_array($transfer['lines']['stations']) && count($transfer['lines']['stations']) > 0){ ?>
									<?php $count = count($transfer['lines']['stations']);?>
									<div class="post-info">--> <?php echo $transfer['lines']['stations'][0]['name'] ?></div>
									<div class="post-info">--> <?php echo $transfer['lines']['stations'][$count - 1]['name'] ?><a>(共<?php echo $count ?>站)</a></div>
								<?php }?>
							<?php }?><!-- transfer nav_count -->
							<?php $useful_bus = $useful_bus + 1;?>
							<div class="post-info"><a>一共<?php echo $transfer['distance'] ?></a></div>
							</div>
						<?php } ?><!-- useful_bus -->
					<?php } ?><!-- foreach transfer -->
				<?php }?><!-- empty($drive_route) -->
			<?php }?><!-- dis else-->
		 <div class="post">
            <figure><img src="<?php echo $pic_url?>" alt=""></figure>
            <div class="post-info"><a>此地图仅贡参考</a><span>|</span> <a>来自谷歌地图</a></div>
         </div>
		 <div class="post">
            <div class="post-info"><?php echo $geo['content'] ?></div>
         </div>
    </div>
</div>
<div class="footer">
	<div class="wrap bot-bar">
    	&copy; 2013 by 苏酒_笑笑  design by <a href="http://www.9jialu.com">9jialu.com</a>
    </div>
</div>
</body>
</html>