<?php
if(!defined('TOKEN'))die('403');
class Keyword{
	private $db;
	private $wid;
	public $init;
	public $null;

	public function __construct($wid){
		$this->db = new SaeMysql();
		$this->wid = $wid;
		$this->init = $this->get_init();
		$this->null = $this->get_null();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	private function get_init(){
		$data = $this->get_key_word('init');
		return $data;
	}

	private function get_null(){
		$data = $this->get_key_word('null');
		return $data;
	}

	public function get_key_word($key){
		$sql = "select content,type from keyword where wid ='" . $this->wid . "' and keyword ='" . $key . "'" ;
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		if(count($data) == 0){
			if($key == "null"){
				return "no result in 9jialu";
			}else if($key == "init"){
				return "welcome to 9jialu";
			}else{
				return $this->null;
			}
		}else{
			if($key == "null" || $key == "init") return $data[0]['content'];
		}
		return $data;
	}
}