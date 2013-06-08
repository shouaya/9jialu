<?php
function template($toolbar, $menu, $content){
$template=<<<EOF
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>酒家路 - 管理后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/uploadify.css" type="text/css"  rel="stylesheet">

    <!-- Le styles -->
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 20px;
      }
      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
	  img {
		max-width: none;
	  }
      .container-narrow > hr {
        margin: 30px 0;
      }
      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 20px 0;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
	  .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
      .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../favicon.ico">
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script charset="utf-8" src="js/kindeditor/kindeditor-min.js"></script>
	<script charset="utf-8" src="js/kindeditor/zh_CN.js"></script>
	<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script src="http://api.map.baidu.com/api?key=&v=1.1&services=true" type="text/javascript"></script>
	<script src="js/jquery.dumap.js" type="text/javascript"></script>
  </head>
 <body>
 <div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container-fluid">
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </a>
	  <a class="brand" style="padding:3px;"><img src='image/Original_204x75.png' style="width:90px"></a>
	  <div class="nav-collapse">
		<ul class="nav" id="toolbar">$toolbar</ul>
		<p class="navbar-text pull-right"><a href="logout.php">退出</a></p>
	  </div>
	</div>
  </div>
</div>
<div class="container-fluid">
  <div class="row-fluid">
	<div class="span2">
		<ul class="nav nav-pills nav-stacked" id="menu">$menu</ul>
	</div>
	<div class="span10">
		<div id="tab-content" class="tab-content">$content</div>
	</div>
  </div>
<hr>
<footer>
&copy; 2013  <a href="http://weibo.com/373457579" target="_blank">苏酒_笑笑</a> | <a href="http://www.miitbeian.gov.cn/" target="_blank">苏ICP备13023887号-1</a> | <a href="admin.php#help" target="_blank">疑难解答</a> | <a href="admin.php#about" target="_blank">联系我们</a><div style="float:right"><img src='image/sae.gif'/></div>
</footer>
</div>
</body>
</html>
EOF;
return $template;
}

function template_m($title, $img, $content){
$template=<<<EOF
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>酒家路 - $title</title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
</head>
<div class="logo">
    <a><img src="image/Original_without_effects_204x75.png"></a>
</div>
<div class="content">
	<div class="wrap">
		 <div class="post">
			<h3>$title</h3>
            <figure><img src="$img" alt=""></figure>
         </div>
		 <div class="post">
			$content
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
EOF;
return $template;
}