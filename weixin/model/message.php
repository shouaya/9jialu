<?php
if(!defined('TOKEN'))die('403');
class Message{
	private $db;

	public function __construct(){
		$this->db = new SaeMysql();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function save($postObj){
		$sql = "insert into message (ToUserName,FromUserName,CreateTime,MsgType,Location_X,Location_Y,Label,PicUrl,Content) values (" ;
		$sql .= "'" . $postObj->ToUserName . "'," ;
		$sql .= "'" . $postObj->FromUserName . "'," ;
		$sql .= "'" . date ( "Y-m-d H:i:s" ) . "'," ;
		$sql .= "'" . $postObj->MsgType . "'," ;
		$sql .= "'" . $postObj->Location_X . "'," ;
		$sql .= "'" . $postObj->Location_Y . "'," ;
		$sql .= "'" . $postObj->Label . "'," ;
		$sql .= "'" . $postObj->PicUrl . "'," ;
		$sql .= "'" . trim($postObj->Content) . "');" ;
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return("error");
	}
}