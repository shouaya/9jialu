<?php
if(!defined('TOKEN'))die('403');
class TplItem
{
	private $Obj;
		
	public function __construct($postObj){
		$this->Obj = $postObj;
	}

	public function listItem($list){
		$textTpl = "<xml>
					 <ToUserName><![CDATA[%s]]></ToUserName>
					 <FromUserName><![CDATA[%s]]></FromUserName>
					 <CreateTime>%s</CreateTime>
					 <MsgType><![CDATA[news]]></MsgType>
					 <Content><![CDATA[]]></Content>
					 <ArticleCount>%s</ArticleCount>
					 <Articles>%s</Articles>
					 <FuncFlag>0</FuncFlag>
					 </xml> ";
		$articles = $this->mapItem($list);
		return sprintf($textTpl, $this->Obj->FromUserName, $this->Obj->ToUserName, time(), count($list),  $articles);
	}

	public function listGeo($list){
		$textTpl = "<xml>
					 <ToUserName><![CDATA[%s]]></ToUserName>
					 <FromUserName><![CDATA[%s]]></FromUserName>
					 <CreateTime>%s</CreateTime>
					 <MsgType><![CDATA[news]]></MsgType>
					 <Content><![CDATA[]]></Content>
					 <ArticleCount>%s</ArticleCount>
					 <Articles>%s</Articles>
					 <FuncFlag>0</FuncFlag>
					 </xml> ";
		$articles = $this->mapGeo($list);
		return sprintf($textTpl, $this->Obj->FromUserName, $this->Obj->ToUserName, time(), count($list),  $articles);
	}

	private function mapItem($list){
		$textTpl = "<item>
					 <Title><![CDATA[%s]]></Title>
					 <Description><![CDATA[]]></Description>
					 <PicUrl><![CDATA[%s]]></PicUrl>
					 <Url><![CDATA[%s]]></Url>
					 </item>";
		foreach($list as $item){
			$articles .= sprintf($textTpl, $item["title"], $item["img"], POSTURL . $item["id"]);
		}
		return $articles;
	}

	private function mapGeo($list, $type){
		$textTpl = "<item>
					 <Title><![CDATA[%s]]></Title>
					 <Description><![CDATA[]]></Description>
					 <PicUrl><![CDATA[]]></PicUrl>
					 <Url><![CDATA[%s]]></Url>
					 </item>";
		foreach($list as $item){
			$id = $item["geo"]["id"];
			$title = $item["geo"]["title"];
			$des = "相距" . ceil($item["distance"]) . "千米";
			$articles .= sprintf($textTpl, $title . "(" . $des . ")" , GEOURL . "?x=" . $this->Obj->Location_X . "&y=" . $this->Obj->Location_Y . "&id=" . $id . "&dis=" . ceil($item["distance"]));
		}
		return $articles;
	}
}