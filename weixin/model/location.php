<?php
if(!defined('TOKEN'))die('403');
class Location{
	private $db;
	private $wid;

	public function __construct($wid){
		$this->db = new SaeMysql();
		$this->wid = $wid;
	}

	public function __destruct(){
		$this->db->closeDb();
	}

	private function select_all_localtion(){
		$sql  = " SELECT * FROM location ";
		$sql .= " where location_x > 0 and location_y > 0";
		$sql .= " and wid = '" . $this->wid ."'";
		$all = $this->db->getData($sql);
		return $all;
	}

	private function find_geo_by_id($id, $geos){
		foreach($geos as $geo){
			if($geo['id'] == $id) return $geo;
		}
	}

	public function get_by_geo($x, $y){
		$all = $this->select_all_localtion();

		$distance = array();
		$lat1 = (float)$y;
		$lng1 = (float)$x;
		foreach($all as $point){
			$key = $point["id"];
			$lat2 = (float)$point['Location_Y'];
			$lng2 = (float)$point['Location_X'];
			$distance[$key] = distance($lat1, $lng1, $lat2, $lng2, "Km");
		}
		asort($distance);
		$index = 0;
		$nearby = array();
		foreach($distance as $key=>$value){
			$nearby[$key]['geo'] = $this->find_geo_by_id($key, $all);
			$nearby[$key]['distance'] = $value;
			$index++;
			if($index == 9) break;
		}
		return $nearby;
	}
}