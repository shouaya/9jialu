<?php
define("TOKEN", "9jialu");
require_once("../config.php");
session_start();
if($_SESSION['user'] == null){
	header("Location: ../login.html#timeout");
	exit;
}
$key = new Keyword();
$list = $key->get_by_wid($_SESSION['user']['wid']);

?>
<script type="text/javascript">
function key_create(){
	$("#key_new_value").attr("disabled",false);
	$("#key_new_value").val("");
	$("#key_new_type").val("text");
	$("#key_new_content").val("");
	$('#key_modal_new').modal('show');
	$('#key_action').unbind();
	$('#key_action').bind('click', function() {
		if($.trim($("#key_new_value").val()) == ""){
			alert("关键字必须要输入");
			return;
		}
		if($("#key_new_type").val() == "text" && $.trim($("#key_new_content").val()) == ""){
			alert("回复内容必须输入");
			return;
		}
		$.post("api.php?action=key_create",
			{key:$.trim($("#key_new_value").val()), type:$("#key_new_type").val(), content: $.trim($("#key_new_content").val())},
			function(result){
				if(result == ""){
					pageChange();
					$('#key_modal_new').modal('hide');
				}else{
					alert(result);
				}
		});
	});
}

function key_update(key){
	var key_content = $.trim($("#content_" + key).html());
	var key_type = $.trim($("#type_" + key).html());
	$("#key_new_value").val(key);
	$("#key_new_value").attr("disabled",true);
	$("#key_new_type").val(key_type);
	$("#key_new_content").val(key_content);
	$('#key_modal_new').modal('show');
	$('#key_action').unbind();
	$('#key_action').bind('click', function() {
	  if($.trim($("#key_new_value").val()) == ""){
			alert("关键字必须要输入");
			return;
		}
		if($("#key_new_type").val() == "text" && $.trim($("#key_new_content").val()) == ""){
			alert("回复内容必须输入");
			return;
		}
		$.post("api.php?action=key_update",
			{key:$.trim($("#key_new_value").val()), type:$("#key_new_type").val(), content: $.trim($("#key_new_content").val())},
			function(result){
				if(result == ""){
					pageChange();
					$('#key_modal_new').modal('hide');
				}else{
					alert(result);
				}
		});
	});
}

function key_delete(key){
	$('#key_delete_value').html(key);
	$('#key_modal_delete').modal('show');
}

function key_delete_send(){
	$.post("api.php?action=key_delete",{key:$('#key_delete_value').html()},
		function(result){
			if(result == ""){
				pageChange();
				$('#key_modal_delete').modal('hide');
			}else{
				alert(result);
			}
	});
}
</script>
<div id="msginfo" class="alert alert-info">
  <a class="close" data-dismiss="alert">×</a>
  <strong>1 : </strong>首次关注必须将关键字设置为<strong>init</strong>类型为<strong>文字</strong>（例：欢迎您关注酒家路）<br/>
  <strong>2 : </strong>未找到关键字的回复必须将关键字设置为<strong>null</strong>类型为<strong>文字</strong>（例：你要找的信息不存在于酒家路）<br/>
  <strong>3 : </strong>图文关键字必须将类型设置为<strong>图文</strong>
</div>
<div class="row-fluid">
  <div class="span2"><a href="javascript:key_create();" role="button" class="btn btn-info" data-toggle="modal">增加关键字</a></div>
  <div class="span10">
	<ul class="nav nav-tabs">
	<li class="active">
	<a href="#">全部</a>
	</li>
	<li><a href="#">文字</a></li>
	<li><a href="#">图文</a></li>
	</ul>
  </div>
</div>
<?php if(count($list) > 0){ ?>
	<?php foreach($list as $item) {?>
	<blockquote >
		<p id="content_<?php echo $item['keyword'] ?>">
			<?php echo $item['content'] ?>
		</p>
		<small>关键字：<span class="label label-info"><?php echo $item['keyword'] ?></span>
		| 类型：<span class="label label-success" id="type_<?php echo $item['keyword'] ?>"><?php echo $item['type'] ?></span> |
		<?php if($item['type'] == "text"){?>
			<a href="javascript:key_update('<?php echo $item['keyword'] ?>');" data-toggle="modal">更新</a> |
		<?php }?>
		<a href="javascript:key_delete('<?php echo $item['keyword'] ?>');" data-toggle="modal">删除</a> 
		</small>
	</blockquote>
	<?php } ?>
<?php } ?>
<div id="key_modal_new" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">增加关键字</h3>
  </div>
  <div class="modal-body">
	<div id="msginfo" class="alert alert-info">
	  关键字务必要输入，当类型为<strong>图为</strong>时，回复内容不用填写。<a class="btn" href="#image"><strong>管理图文</strong><a/>
	</div>
    <input id="key_new_value" type="text" placeholder="请输入关键字">
	<select id="key_new_type">
	  <option selected="selected" value="text">文字</option>
	  <option value="image">图文</option>
	</select>
	<hr>
	<textarea id="key_new_content" rows="3" class="field span12"></textarea>
  </div>
  <div class="modal-footer">
    <button id="key_action" class="btn btn-primary">保存</button>
  </div>
</div>
<div id="key_modal_delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">删除关键字</h3>
  </div>
  <div class="modal-body">
    <p>确定删除关键字<span class="label label-info" id="key_delete_value"></span>?</p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="key_delete_send()">确定</button>
  </div>
</div>