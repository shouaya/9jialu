<?php
if(!defined('TOKEN'))die('403');
class Response
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        if(!$this->checkSignature()){
			die('405');
		}else{
			echo $echoStr;
		}
    }

    public function callBack()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (empty($postStr)) die('403');
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$tpl = new Route($postObj);
		echo $tpl->display();
    }

	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>