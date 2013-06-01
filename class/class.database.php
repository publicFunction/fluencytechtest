<?php
/**
 * Structure for processing Basic PHP Databse Interation
 *
 * @package DB
 */
class DB {
	
    private $conn = false;

    public function __construct() {
            /*	To be written	*/
    }

    public function __destruct() {
            /*	To be written	*/
    }
	
    /**
     * Returns boolean value
     * 
     * @uses mysql_connect(), mysql_select_db()
     *
     * @param string $srv string for the database server name/hostname
     * @param string $usr string for the database server username
     * @param string $pas string for the database server users password
     * @param string $dbs string for the database server database to use
     * @return boolean
     */
    public static function dbSetup($srv, $usr, $pas, $dbs) {
        $conn = mysql_connect($srv, $usr, $pas);
        if (!$conn) {
        	$conn = false;
        } else {
            $dbconn = mysql_select_db($dbs);
            if (!$dbconn) {
                $conn = false;
            }
            $conn = true;
        }
		return $conn;
    }
	
    /**
     * Returns Database Result set or single value
     * 
     * @uses mysql_query()
     *
     * @param string $sql string correctly formatted SQL Statement/Query
     * @param string $qType string of 0 or 1. 0 will return a full result set. 1 will return a requested value from $sql 
     * @return DB Result set or DB value in an associative array
     */
    public static function dbQuery($sql, $qType) {
        $runQ = mysql_query($sql);
        if (!$runQ) {
            echo "<p id='error'>ERROR with mySQL: ".mysql_error()."</p>";
        } else {
            switch ($qType) {
                // Run query and return resource
                case "0":
                    return $runQ;
                    break;
                case "1":
                    $singVal = mysql_fetch_array($runQ);
                    return $singVal[0];
                    break;
                default:
                    break;
            }
        }
    }
	
    /**
     * Inserts a DB record
     * 
     * @uses self::dbQuery()
     *
     * @param string $table string of the required table name to manipulate
     * @param array $data must be a correctly formatted associative array of field names and values for insertion
     * @return DB Result set or DB value in an associative array
     */
    public static function dbInsert($table, $data) {
        $count = count($data);
        $i=1;
        $query = "INSERT INTO ".$table." VALUES ('',";
		foreach ($data as $key=>$val) {
            if ($i == $count) {
                $query .= "'".$val."' ";
            } else {
                $query .= "'".$val."', ";
            }
            $i++;
		}
		$query .= ");";
		$dbFields = DB::dbQuery($query,"0");
        if (!$dbFields) {
            error::displayError(12);
        }
    }
    /**
     * Fetches a 
     * 
     * @uses mysql_fetch_array(), mysql_fetch_assoc()
     *
     * @param ResultSet $data must be a valid mysql result set obtained by mysql_query or self::dbQuery() 
     * @param array $data must be a correctly formatted associative array of field names and values for insertion
     * @return DB Result set or DB value in an associative array
     */
    public static function dbFetch($data, $type) {
        switch ($type) {
            case "assoc":
                $outData = mysql_fetch_assoc($data);
                break;
            case "array":
                $outData = mysql_fetch_array($data);
                break;
            default:
                $outData = mysql_fetch_assoc($data);
                break;
        }
        return $outData;
    }


    public static function dbDelete($table, $unique, $ref) {
        $query = "DELETE FROM ".$table." WHERE ".$unique." = '".$ref."';";
        $request = mysql_query($query);
        if ($request) {
            return true;
        } else {
            error::displayError(13);
            return false;
        }
    }

    public static function dbUpdate($table, $data, $id) {
        $count = count($data);
        $i=1;
		$query = "UPDATE ".$table." SET ";
		foreach ($data as $key=>$val) {
            if ($i == $count) {
                $query .= $key."='".$val."' ";
            } else {
                $query .= $key."='".$val."', ";
            }
            $i++;
		}
		$query .= " WHERE ".$id.";";
		$dbFields = DB::dbQuery($query,"0");
        if (!$dbFields) {
            error::displayError(12);
        }

    }

    public static function dbCount($qRes) {
        $num = mysql_num_rows($qRes);
        return $num;
    }
    
    public static function dbClose() {
        return mysql_close();
    }
	
}

?>