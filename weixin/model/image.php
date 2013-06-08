<?php
if(!defined('TOKEN'))die('403');
class Image{
	private $db;
	private $wid;

	public function __construct($wid){
		$this->db = new SaeMysql();
		$this->wid = $wid;
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function get_by_key($key){
		$sql = "select id,title,img,content from image where wid ='" . $this->wid . "' and keyword ='" . $key . "'" ;
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		return $data;
	}
}