<?php
session_start();
if($_SESSION['user'] == null){
	header("Location: ../login.html#timeout");
	exit;
}
?>
<div id="msginfo" class="alert alert-info">
  <a class="close" data-dismiss="alert">×</a>
  <strong>  URL : </strong> http://www.9jialu.com/weixin/api.php<br/>
  <strong>Token : </strong> 9jialu
</div>
<fieldset>
	 <legend>重新设置密码</legend> 
	 <input type="text" id="config_pass"/> 
	 <span class="help-block">请输入新的密码.</span> 
	 <button type="submit" class="btn" onclick="update_config_pass()">提交</button>
</fieldset>
<script type='text/javascript'>
function update_config_pass(){
	var pass = $("#config_pass").val();
	$.post("api.php?action=update_config_pass", {pass:pass}, function(result){
		alert(result);
	});
}
</script>