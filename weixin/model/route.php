<?php
if(!defined('TOKEN'))die('403');
class Route
{
	private $Obj;

	public function __construct($postObj){
		$this->Obj = $postObj;
	}

	public function display(){
		$guide = new TplGuide($this->Obj);
		$type = $this->Obj->MsgType;

		$messgae = new Message();
		$messgae->save($this->Obj);
		$keyword = new Keyword($this->Obj->ToUserName);

		if($type == "text"){
			$content = trim($this->Obj->Content);
			if(filter_var($content, FILTER_VALIDATE_EMAIL)){
				$member = new Member();
				$result = $member->regist($this->Obj->ToUserName, $this->Obj->FromUserName, $content);
				return $guide->guideText($result);
			}
			$result = $keyword->get_key_word($content);
			if(is_array($result)){
				if($result[0]['type'] == "text") return $guide->guideText($result[0]['content']);
				if($result[0]['type'] == "image"){
					//return $guide->guideText($this->Obj->ToUserName . '_' . $content);  
					$image = new Image($this->Obj->ToUserName);
					$result = $image->get_by_key($content);
					$item = new TplItem($this->Obj);				
					return $item->listItem($result);
				}
			}else{
				return $guide->guideText($result);
			}

		}else if($type == "event"){
			if($this->Obj->Event == "subscribe"){
				return $guide->guideText($keyword->init);
			}
		}else if($type == "location"){
			$location = new Location($this->Obj->ToUserName);
			$result = $location->get_by_geo($this->Obj->Location_X, $this->Obj->Location_Y);
			/*ob_start();
			var_dump($result);
			$out = ob_get_contents();
			ob_end_flush();
			return $guide->guideText($out);*/
			$item = new TplItem($this->Obj);
			return $item->listGeo($result);
		}
	}
}