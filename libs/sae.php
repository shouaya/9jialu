<?php
class SaeMysql {
	protected static $DB_Name;
	protected static $DB_Open;
	protected static $DB_Conn;
	public function __construct()
	{
		self::$DB_Name = "weiadmin";
		self::$DB_Conn = mysql_connect('localhost', 'root', 'whkc76s6');
		@mysql_select_db(self::$DB_Name, self::$DB_Conn);
	} 

	public function runSql($sql) {
		$query = @mysql_query($sql, self::$DB_Conn) OR die(mysql_error());
		return $query;
	}

	public function getData( $sql )
	{
		$data = Array();
		$i = 0;
		$result = @mysql_query($sql, self::$DB_Conn);
		if (is_bool($result)) {
			return $result;
		} else {
			while( $Array = @mysql_fetch_array($result))
			{
				$data[$i++] = $Array;
			}
		}
		@mysqli_free_result($result); 
		if( count( $data ) > 0 )
			return $data;
		else
			return NULL;    
	}

	public function errno(){
		return 0;
	}
	public function closeDb(){
		@mysql_close(self::$DB_Conn);
	}
}
