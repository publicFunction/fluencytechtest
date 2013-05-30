<?php
require_once(BASE_DIR.'class/class.database.php');

class Fluency {
    
    const baseURL = "http://api.fluency.net.uk/checker/ead?b_end=";
    
    private static function connectDB() {
        $db = new DB();
        $db->dbSetup(DB_SERVER, DB_USER, DB_PASS, DB_TABLE);
    }
    
    private static function closeDB() {
        $db = new DB();
        $db->dbClose();
    }
    
    public static function contractLength() {
        /*  This function exists to allow the contract lengths to be pulled from a data source, as none exists
         *  it is being set as an array
         */
        $contract_times = array(12,36);
        return $contract_times;
    }
    
    public static function runRequest($postcode, $type=false) {
        /*  Tnis function is used to */
        if ($type) {
            $req = self::baseURL.str_replace(" ", "", $postcode)."&return=".$type;
        } else {
            $req = self::baseURL.str_replace(" ", "", $postcode);
        }
        $data = self::curlRequest($req);
        return $data;
    }
    
    public static function storeUser($data) {
        self::connectDB();
        $cleanUserData = array( 'person_id' => 0, 
                                'customer_name' => $data['customer_name'],
                                'date_created' => date("Y-m-d H:i:s", time()),
                                'contract_length' => (int)$data['contract_length']
                            );
        DB::dbInsert('ethernet_quotes', $cleanUserData);
        $user = DB::dbQuery("SELECT id FROM ethernet_quotes ORDER BY id DESC LIMIT 1;", "1");
        self::closeDB();
        return $user;
    }
    
    public static function storeQuotes() {
        
    }

    public static function processQuotes($jsonData) {
        var_dump($jsonData);
    }

        private static function curlRequest($urlData, $options=false) {
        /*
         *  With curlRequest you can specify your own list of options by creating an array like:
         *  $curlOpt = array ('UPPERCASE_CURL_OPT' => 'required param', 'UPPERCASE_CURL_OPT' => 'another param');
         *  This is not required and is treated as false and has CURLOPT_URL, CURLOPT_RETURNTRANSFER, CURLOPT_REFERER
         *  set as the default entries.  Be aware that CURLOPT_REFERER is set to a php define param called SITE_URL
         *  with this code, this is set in the DB in the registry table, but you are taking this code then please set a
         *  define to cover this param.
         *  The default values are set as follows:
         *                                          CURLOPT_URL, the url you pass into the object
         *                                          CURLOPT_RETURNTRANSFER, set to 1 to allow you to get the data back
         *                                          CURLOPT_REFERER, as mentioned previously uses the SITE_URL define param
         */
        
        $curl = curl_init();
        if (!$options) {
            curl_setopt($curl, CURLOPT_URL, $urlData);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_REFERER, SITE_URL);
        } else {
            foreach ($options as $key=>$val) {
                curl_setopt($curl, $key, $val);
            }
        }
        $body = curl_exec($curl);
        curl_close($curl);
        return $body;
    }
}

?>
