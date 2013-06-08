<?php
define("TOKEN", "9jialu");
require_once("../config.php");
session_start();
if($_SESSION['user'] == null){
	header("Location: ../login.html#timeout");
	exit;
}
$geo = new Location();
$list = $geo->get_by_wid($_SESSION['user']['wid']);
?>
<script type="text/javascript">
function searchGeo(){
	var addr = $("#addr").val();
	var markerArr = [{title:"9jialu",content:"欢迎来到酒家路",point: "118.635101|31.930729",isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}];
	$.dm.init('dituContent', new BMap.Point(116.404, 39.915), 18, markerArr, function(pois){
		var addr = $("#addr").val();
			$("#diloginfo").removeClass();
			if(pois.length == 0){
				$("#diloginfo").addClass("alert alert-error");
				$("#diloginfo").html("<strong>提示:</strong> 没有相关结果您可以适当扩大范围。");
				return;
			}else{
				$("#diloginfo").addClass("alert alert-success");
				$("#diloginfo").html("已定位到<strong>" + pois[0].title  + "</strong>。");
			}
			$("#ulng").val(pois[0].point.lng);
			$("#ulat").val(pois[0].point.lat);
			$.dm._map.centerAndZoom(new BMap.Point(pois[0].point.lng, pois[0].point.lat), 15);
			var markerArr = [{title:addr,content:pois[0].title,point: pois[0].point.lng + "|" + pois[0].point.lat,isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}];
			$.dm.addMarker(markerArr);
	});
	$.dm._service.search(addr);
}
function geo_create(){
	$("#addr").val("");
	$("#ulng").val("");
	$("#ulat").val("");
	editorGeo.html('请输入位置描述');
	$('#geo_action').unbind();
	$('#geo_modal_new').modal('show');
	$('#geo_action').bind('click', function() {
		if($.trim($("#addr").val()) == ""){
			alert("地址必须要输入");
			return;
		}
		if($.trim(editorGeo.html()) == ""){
			alert("描述必须要输入");
			return;
		}
		if($.trim($("#ulng").val()) == ""||$.trim($("#ulat").val()) == ""){
			alert("位置必须要定位到");
			return;
		}
		$.post("api.php?action=geo_create",
			{title:$.trim($("#addr").val()),
			 content:$.trim(editorGeo.html()),
			 y: $.trim($("#ulng").val()),
			 x: $.trim($("#ulat").val())},
			function(result){
				if(result == ""){
					pageChange();
					$('#geo_modal_new').modal('hide');
				}else{
					alert(result);
				}
		});
	});
}

function geo_update(id){
	$.getJSON("api.php?action=geo_info&id="+id,function(geo){
		$("#addr").val(geo.title);
		$("#ulng").val(geo.Location_Y);
		$("#ulat").val(geo.Location_X);
		editorGeo.html(geo.content);
		var markerArr = [{title:geo.title,point: geo.Location_Y + "|" + geo.Location_X,isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}];
		$.dm.init('dituContent', new BMap.Point(geo.Location_Y, geo.Location_X), 18, markerArr, null);
		$('#geo_action').unbind();
		$('#geo_modal_new').modal('show');
		$('#geo_action').bind('click', function() {
			if($.trim($("#addr").val()) == ""){
				alert("地址必须要输入");
				return;
			}
			if($.trim(editorGeo.html()) == ""){
				alert("描述必须要输入");
				return;
			}
			if($.trim($("#ulng").val()) == ""||$.trim($("#ulat").val()) == ""){
				alert("位置必须要定位到");
				return;
			}
			$.post("api.php?action=geo_create",
				{id:id,title:$.trim($("#addr").val()),
				 content:$.trim(editorGeo.html()),
				 y: $.trim($("#ulng").val()),
				 x: $.trim($("#ulat").val())},
				function(result){
					if(result == ""){
						pageChange();
						$('#geo_modal_new').modal('hide');
					}else{
						alert(result);
					}
			});
		});
	});
}

function geo_delete(id){
	$('#geo_delete_id').val(id);
	$('#geo_modal_delete').modal('show');
}

function geo_delete_send(){
	$.post("api.php?action=geo_delete",{id:$('#geo_delete_id').val()},
		function(result){
			if(result == ""){
				pageChange();
				$('#geo_modal_delete').modal('hide');
			}else{
				alert(result);
			}
	});
}
</script>
<a href="javascript:geo_create();" role="button" class="btn btn-info" data-toggle="modal">增加位置</a>
<br/>
<br/>
<div style="width:900px;height:480px;border:#ccc solid 1px;" id="dituMain"></div>
<div id="geo_modal_new" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">增加位置</h3>
  </div>
  <div class="modal-body">
	<div id="diloginfo" class="alert alert-info">
		  <strong>提示:</strong> 请填写地址坐标。
	</div>
	<div class="controls">
	  <div class="input-append">
		<input name="addr" id="addr" type="text" class="span10" type="text" placeholder="输入地址...."/>
		<button class="btn btn-info" type="button" onclick="searchGeo();">定位</button>
	  </div>
	</div>
	<div style="width:525px;height:220px;border:#ccc solid 1px;" id="dituContent"></div>
	<input id="ulng" name="ulng" type="hidden"/>
    <input id="ulat" name="ulat" type="hidden"/><br/>
	<textarea id="geo_new_content" name="content" style="width:525px;height:200px;visibility:hidden;">请输入位置描述</textarea>
	<script type="text/javascript">
		editorGeo = KindEditor.create('textarea[id="geo_new_content"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : false,
			items : [
				'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist','|']
		});
	</script>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" id="geo_action">保存</button>
  </div>
</div>
<div id="geo_modal_delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">删除位置</h3>
  </div>
  <div class="modal-body">
    <p>确定删除该位置？</p>
	<input id='geo_delete_id' type='hidden' value=''/>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="geo_delete_send()">确定</button>
  </div>
</div>
<script type="text/javascript">
var markerArr = [{title:"9jialu",content:"欢迎来到酒家路",point: "118.635101|31.930729",isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}];
<?php if(count($list) > 0){ ?>
	var	markerArr = new Array();
	<?php foreach($list as $item){?>
		var point = {title:"<?php echo $item['title'] ?>",
					 content:"<a href=javascript:geo_update('<?php echo $item['id'] ?>')>更新</a> | <a href=javascript:geo_delete('<?php echo $item['id'] ?>')>删除</a>",
					 point: "<?php echo $item['Location_Y'] ?>|<?php echo $item['Location_X'] ?>",
					 isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}};
		markerArr.push(point);
	<?php } ?>
<?php }?>
$.dm.init('dituMain',new BMap.Point(118.635101, 31.930729), 5, markerArr, null);
</script>