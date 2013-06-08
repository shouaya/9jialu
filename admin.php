<?php
define("TOKEN", "9jialu");
require_once("config.php");
$tool=<<<EOF
<li class="active"><a href='#'>管理中心</a></li>
<li><a href='#ground'>推广大厅</a></li>
<li><a href='#feedback'>意见反馈</a></li>
<li><a href='#help'>问题解答</a></li>
<li><a href='#about'>联系我们</a></li>
<li><a target="_blank" href='https://mp.weixin.qq.com/cgi-bin/loginpage?t=wxm2-login&lang=zh_CN'>微信管理后台</a></li>
EOF;
$menu=<<<EOF
<li><a href="#key">关键字设置</a></li>
<li><a href="#image">图文列表</a></li>
<li><a href="#location">位置列表</a></li>
<li><a href="#config">配置管理</a></li>
EOF;
echo template($tool,$menu,null);
?>
<script>
  var editorImg, editorGeo;
  $(function () {
	$.ajaxSetup({ cache: true });
	window.addEventListener("hashchange", pageChange, false);
	pageChange();
  })
  function pageChange(){
	var page = location.hash.replace(/#/, "");
	if(page == "") page = "key";
	$("#tab-content").load("pages/" + page + ".php",function(){
		$('#toolbar li').removeClass('active');
		$('#toolbar li a[href="#' + page + '"]').parent().addClass('active');
		$('#menu li').removeClass('active');
		$('#menu li a[href="#' + page + '"]').parent().addClass('active');
		if(page =="key" || page =="image" || page =="location" || page =="config"){
			$('#toolbar li a[href="#"]').parent().addClass('active');
		}
	});
  }
</script>