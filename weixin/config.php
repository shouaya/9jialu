<?php
if(!defined('TOKEN'))die('403');

define("POSTURL", "http://www.9jialu.com/post.php?id=");
define("GEOURL", "http://www.9jialu.com/geo.php");
define("PICURL", "http://www.9jialu.com/image");


require_once('lib/function.php');
//require_once('lib/sae.php');

require_once('model/message.php');
require_once('model/response.php');
require_once('model/route.php');
require_once('model/keyword.php');
require_once('model/image.php');
require_once('model/location.php');
require_once('model/member.php');

require_once('tpl/guide.php');
require_once('tpl/item.php');
