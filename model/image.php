<?php
if(!defined('TOKEN'))die('403');
class Image{
	private $db;

	public function __construct(){
		$this->db= new SaeMysql();
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	public function get_by_wid($wid){
		$sql = "select * from image where wid = '" . $wid . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		return $data;
	}

	public function get_by_id($id){
		$sql = "select * from image where id = '" . $id . "'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		$result = $data[0];
		$result['content'] = html_entity_decode(base64_decode($result['content']));
		return $result;
	}

	public function get_all_keyword($wid){
		$sql = "select keyword from keyword where wid = '" . $wid . "' and type='image'";
		$data = $this->db->getData($sql);
		if( $this->db->errno() != 0 ) return null;
		return $data;
	}

	public function create_image($key,$title,$content,$url,$wid){
		$sql = "insert into image (keyword,title,content,img,wid) values (" ;
		$sql .= "'" . $key . "'," ;
		$sql .= "'" . $title . "'," ;
		$sql .= "'" . base64_encode($content) . "'," ;
		$sql .= "'" . $url . "'," ;
		$sql .= "'" . $wid . "');" ;
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}

	public function update_image($id,$key,$title,$content,$url,$wid){
		$sql = " update image " ;
		$sql .= " set keyword = '" . $key . "'," ;
		$sql .= " title = '" . $title . "'," ;
		$sql .= " content = '" . base64_encode($content) . "'," ;
		$sql .= " img = '" . $url . "'" ;
		$sql .= " where wid = '" . $wid . "' and id = '" . $id . "'";
		$this->db->runSql($sql);
		if( $this->db->errno() != 0 ) return $sql;//$this->db->errmsg();
	}

	public function delete_image($id, $wid){
		$sql = "delete from image where id = '" . $id . "' and wid ='" . $wid . "'";
		$this->db->runSql( $sql );
		if( $this->db->errno() != 0 ) return $this->db->errmsg();
	}
}