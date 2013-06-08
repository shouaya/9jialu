<?php
	$lvyi_db = new SaeMysql();
	$lvyi_sql = "SELECT `wid`,`pass` FROM `member` where `wid`='admin'";
	$lvyi_result = $lvyi_db->getLine( $lvyi_sql );
	if( $lvyi_result && ($lvyi_result['wid']=='admin') ){
		Header( "HTTP/1.1 301 Moved Permanently") ; 
		Header( "Location: http://".$_SERVER['HTTP_HOST'].'/' ); 
		exit();
	}
	//install
	$sql = file_get_contents( './weiadmin.sql');
	//do
	runquery( $sql );	
	//report
	if( $lvyi_db->errno() != 0 )
	{
	    die( "Error:" . $lvyi_db->errmsg() );
	}
	$lvyi_db->closeDb();

	//include success template
	include_once( './install_success.html' );
	

function runquery($sql) {
	global $lvyi_db;
	$sql = str_replace("\r", "\n", $sql );
	$ret = array ();
	$num = 0;
	foreach (explode(";\n", trim($sql)) as $query) {
		$queries = explode("\n", trim($query));
		foreach ($queries as $query) {
			$ret[$num] .= $query[0] == '#' || $query[0] . $query[1] == '--' ? '' : $query;
		}
		$num++;
	}
	unset ($sql);
	$strtip = "";
	foreach ($ret as $query) {
		$query = trim($query);
		if ($query) {
			if (substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE\s*([a-z0-9_]+)\s*.*/is", "\\1", $query);
				$res = $lvyi_db->runSql(createtable($query, 'utf8'));
				$tablenum++;
			} else {
				$res = $lvyi_db->runSql($query);
			}
		}
	}
	return true;
}

function createtable($sql, $dbcharset) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array (
		'MYISAM',
		'HEAP'
	)) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql) .
	 " ENGINE=$type DEFAULT CHARSET='utf8'";
}


?>
