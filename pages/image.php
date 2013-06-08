<?php
define("TOKEN", "9jialu");
require_once("../config.php");
session_start();
if($_SESSION['user'] == null){
	header("Location: ../login.html#timeout");
	exit;
}
$image = new Image();
$list = $image->get_by_wid($_SESSION['user']['wid']);
$keys = $image->get_all_keyword($_SESSION['user']['wid']);

?>
<script type="text/javascript">
function image_create(){
	$('#image_modal_new').modal('show');
	$("#image_new_keyword").val("");
	$("#image_new_title").val("");
	editorImg.html('请输入图文描述');
	$("#image_new_url").val("");
	$('#image_action').unbind();
	$('#image_action').bind('click', function() {
		if($("#image_new_keyword").val() == ""){
			alert("关键字必须选择");
			return;
		}
		if($.trim($("#image_new_title").val()) == ""){
			alert("标题必须要输入");
			return;
		}
		if($.trim(editorImg.html()) == ""){
			alert("描述必须要输入");
			return;
		}
		if($.trim($("#image_new_url").val()) == ""){
			alert("必须要上传一张图片");
			return;
		}
		$.post("api.php?action=image_create",
			{key:$("#image_new_keyword").val(),
			 title:$.trim($("#image_new_title").val()),
			 content:$.trim(editorImg.html()),
			 url: $.trim($("#image_new_url").val())},
			function(result){
				if(result == ""){
					pageChange();
					$('#image_modal_new').modal('hide');
				}else{
					alert(result);
				}
		});
	});
}

function image_update(id){
	$.getJSON("api.php?action=image_info&id="+id,function(image){
		$('#image_modal_new').modal('show');
		$("#image_new_keyword").val(image.keyword);
		$("#image_new_title").val(image.title);
		editorImg.html(image.content);
		$("#image_new_url").val(image.img);
		$('#image_action').unbind();
		$('#image_action').bind('click', function() {
			if($("#image_new_keyword").val() == ""){
				alert("关键字必须选择");
				return;
			}
			if($.trim($("#image_new_title").val()) == ""){
				alert("标题必须要输入");
				return;
			}
			if($.trim(editorImg.html()) == ""){
				alert("描述必须要输入");
				return;
			}
			if($.trim($("#image_new_url").val()) == ""){
				alert("必须要上传一张图片");
				return;
			}
			$.post("api.php?action=image_update",
				{id:id,
				 key:$("#image_new_keyword").val(),
				 title:$.trim($("#image_new_title").val()),
				 content:$.trim(editorImg.html()),
				 url: $.trim($("#image_new_url").val())},
				function(result){
					if(result == ""){
						pageChange();
						$('#image_modal_new').modal('hide');
					}else{
						alert(result);
					}
			});
		});
	});
}

function image_delete(id){
	$('#image_delete_id').val(id);
	$('#image_modal_delete').modal('show');
}

function image_delete_send(){
	$.post("api.php?action=image_delete",{id:$('#image_delete_id').val()},
		function(result){
			if(result == ""){
				pageChange();
				$('#image_modal_delete').modal('hide');
			}else{
				alert(result);
			}
	});
}
</script>
<div id="msginfo" class="alert alert-info">
  <a class="close" data-dismiss="alert">×</a>
  <strong>1 : </strong>必须先设置一条关键字且类型为<strong>image</strong><br/>
  <strong>2 : </strong>在图文列表内设置该关键字对应图文，每个关键字最多支持<strong>10个</strong>图文
</div>
<a href="javascript:image_create();" role="button" class="btn btn-info" data-toggle="modal">增加图文</a>
<br/>
<br/>
<?php if(count($list) > 0){ ?>
<ul class="thumbnails">
	<?php foreach($list as $item){?>
	<li class="span4" style="width: 30%;">
		<div class="thumbnail">
			<img alt="300x200" style="height: 320px;" src="<?php echo $item['img'] ?>" />
			<div class="caption">
				<h3><?php echo $item['title'] ?></h3>
				<p>
					<a class="btn btn-info" href="javascript:image_update('<?php echo $item['id'] ?>');">更改</a>
					<a class="btn btn-danger" href="javascript:image_delete('<?php echo $item['id'] ?>');">删除</a>
					<a class="btn btn-success" href="post.php?id=<?php echo $item['id'] ?>" target="_blank">预览</a>
				</p>
				<hr/>关键字：<span class="label label-info"><?php echo $item['keyword'] ?></span><br/><br/>
			</div>
		</div>
	</li>
	<?php } ?>
</ul>
<?php } ?>
<div id="image_modal_new" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">增加图文</h3>
  </div>
  <div class="modal-body">
	请选择关键字
    <select id="image_new_keyword">
	<?php foreach($keys as $key){?>
	  <option value="<?php echo $key['keyword'] ?>"><?php echo $key['keyword'] ?></option>
	<?php } ?>
	</select><br/>
	请输入图文标题
	<textarea id="image_new_title" rows="1" class="field span12"></textarea>
	<textarea id="image_new_content" name="content" style="width:528px;height:200px;visibility:hidden;">请输入图文描述</textarea>
	<script type="text/javascript">
		editorImg = KindEditor.create('textarea[id="image_new_content"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : false,
			items : [
				'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist','|']
		});
	</script>
	<br/>
	<input id="image_new_url" type="hidden">
	<input id="file_upload" name="file_upload" type="file" class="span12" multiple="true">
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" id="image_action">保存</button>
  </div>
</div>
<div id="image_modal_delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">删除图文</h3>
  </div>
  <div class="modal-body">
    <p>确定删除该图文？</p>
	<input id='image_delete_id' type='hidden' value=''/>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="image_delete_send()">确定</button>
  </div>
</div>
<script type="text/javascript">
	<?php $timestamp = time();?>
	$(function() {
		$('#file_upload').uploadify({
			'formData'     : {
				'timestamp' : '<?php echo $timestamp;?>',
				'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
			},
			'multi'    : false,
			'swf'      : 'upload.swf',
			'uploader' : 'upload.php',
			'buttonText' : '点击上传图片',
			'onUploadSuccess' : function(file,data,response) {
				$('#image_new_url').val(data);
			}
		});
	});
</script>