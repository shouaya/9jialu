<?php
if(!defined('TOKEN'))die('403');
class Keyword{
	private $db;

	public function __construct(){
		$this->db= new SaeMysql();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function get_by_wid($wid){
		$sql = "select * from keyword where wid = '" . $wid . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		return $data;
	}

	public function create_keyword($key,$type,$content,$wid){
		$sql = "insert into keyword (keyword,type,content,wid) values (" ;
		$sql .= "'" . $key . "'," ;
		$sql .= "'" . $type . "'," ;
		$sql .= "'" . $content . "'," ;
		$sql .= "'" . $wid . "');" ;
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}

	public function update_keyword($key,$type,$content,$wid){
		$sql  = " update keyword " ;
		$sql .= " set type = '" . $type . "', " ;
		$sql .= " content = '" . $content . "' " ;
		$sql .= " where wid = '" . $wid . "' and " ;
		$sql .= " keyword = '" . $key . "' " ;
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}

	public function delete_keyword($key, $wid){
		$sql = "delete from keyword where keyword = '" . $key . "' and wid ='" . $wid . "'";
		$this->db->runSql( $sql );
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}
}