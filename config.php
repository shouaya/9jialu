<?php
if(!defined('TOKEN'))die('403');
require_once(dirname(__FILE__) . '/libs/common.php');
require_once(dirname(__FILE__) . '/libs/sae.php');
require_once(dirname(__FILE__) . '/libs/template.php');

require_once(dirname(__FILE__) . '/model/user.php');
require_once(dirname(__FILE__) . '/model/keyword.php');
require_once(dirname(__FILE__) . '/model/image.php');
require_once(dirname(__FILE__) . '/model/location.php');