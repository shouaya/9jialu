<?php
if(!defined('TOKEN'))die('403');
class User{
	private $db;

	public function __construct(){
		$this->db= new SaeMysql();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function get_by_pass($email, $pass){
		$sql = "select * from member where email = '" . $email . "' and pass ='" . $pass . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		if(count($data) == 0 ) return null;
		return $data[0];
	}

	public function change_pass($pass, $user){
		$sql = "update member set pass = '" . $pass . "' where wid = '" . $user['wid'] . "' and uid ='" . $user['uid'] . "'";
		$this->db->runSql( $sql );
		if( $this->db->errno() != 0 ) return "修改失败";
		return "修改成功";
	}
}