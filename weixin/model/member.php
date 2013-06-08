<?php
if(!defined('TOKEN'))die('403');
class Member{
	private $db;

	public function __construct(){
		$this->db = new SaeMysql();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function regist($wid, $uid ,$email){
		$data = $this->get_by_wid($wid);
		if(empty($data)){
			$pass = $this->create($wid, $uid, $email);
			return "你的密码是" . $pass;
		}
		return "你已经注册，如有疑问请联系管理员QQ:240050570";
	}

	private function create($wid, $uid, $email){
		$pass = randpass();
		$sql = "insert into member (wid,uid,pass,email,ctime) values (" ;
		$sql .= "'" . $wid . "'," ;
		$sql .= "'" . $uid . "'," ;
		$sql .= "'" . $pass . "'," ;
		$sql .= "'" . $email . "'," ;
		$sql .= "'" . date ( "Y-m-d H:i:s" ) . "');" ;
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return null;
		return $pass;
	}

	private function get_by_wid($wid){
		$sql = "select * from member where wid ='" . $wid . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		if(count($data) == 0){
			return null;
		}
		return $data;
	}
}