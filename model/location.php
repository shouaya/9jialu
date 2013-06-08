<?php
if(!defined('TOKEN'))die('403');
class Location{
	private $db;

	public function __construct(){
		$this->db= new SaeMysql();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function get_by_wid($wid){
		$sql = "select * from location where wid = '" . $wid . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		return $data;
	}

	public function get_by_id($id){
		$sql = "select * from location where id = '" . $id . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		$result = $data[0];
		$result['content'] = html_entity_decode(base64_decode($result['content']));
		return $result;
	}

	public function create_location($wid,$title,$content,$x,$y){
		$sql = "insert into location (wid,title,content,Location_X,Location_Y) values (" ;
		$sql .= "'" . $wid . "'," ;
		$sql .= "'" . $title . "'," ;
		$sql .= "'" . base64_encode($content) . "'," ;
		$sql .= "'" . $x . "'," ;
		$sql .= "'" . $y . "');" ;
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}

	public function update_location($id,$wid,$title,$content,$x,$y){
		$sql = " update location " ;
		$sql .= " set title = '" . $title . "'," ;
		$sql .= " content = ''" . base64_encode($content) . "'," ;
		$sql .= " x = '" . $x . "'," ;
		$sql .= " y = '" . $y . "'" ;
		$sql .= " where wid = '" . $wid . "' and id = '" . $id . "'";
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}

	public function delete_location($id, $wid){
		$sql = "delete from location where id = '" . $id . "' and wid ='" . $wid . "'";
		$this->db->runSql( $sql );
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}
}