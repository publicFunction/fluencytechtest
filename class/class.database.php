<?php

class DB {
	
    public static function dbSetup($srv, $usr, $pas, $dbs) {
        //echo $srv.", ".$usr.", ".$pas.",".$dbs;
        $conn = mysql_connect($srv, $usr, $pas);
        if (!$conn) {
            //echo "<p id='error'>ERROR Connection failed with mySQL: ".mysql_error()."</p>";
            return false;
        } else {
            $dbconn = mysql_select_db($dbs);
            if (!$dbconn) {
                //echo "<p id='error'>ERROR with DB Selection mySQL: ".mysql_error()."</p>";
                return false;
            }
            return true;
        }
    }
	
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