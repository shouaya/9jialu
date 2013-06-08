<?php
if(!defined('TOKEN'))die('403');
class TplGuide
{
	private $Obj;
		
	public function __construct($postObj){
		$this->Obj = $postObj;
	}

	public function guideText($text){
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
		$contentStr = "welcome to 9jialu";
		if(!empty($text)) $contentStr = $text;
		return sprintf($textTpl, $this->Obj->FromUserName, $this->Obj->ToUserName, time(), $contentStr);
	}

	public function nullText(){
		return $this->guideText($this->key->null);
	}
}