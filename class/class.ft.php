<?php
/*	This is my own class.database file that I have used on severel projects 
 * including and alpha of my own CMS System
 */
require_once(BASE_DIR.'class/class.database.php');
/**
 * Structure for processing the Fluency Technical Test
 *
 * @package Fluency
 */
class Fluency {
    /**
	 * Stores The base URL used in the CURL Request
	 * @var const
	 * @access private
	 */
    const baseURL = "http://api.fluency.net.uk/checker/ead?b_end=";
	
	/**
	 * Sets up Database Connection
	 *
	 * @uses DB Database Object, DEFINES from settings.php
	 *
	 * @return nothing
	 */
    private static function connectDB() {
        $db = new DB();
        $db->dbSetup(DB_SERVER, DB_USER, DB_PASS, DB_TABLE);
    }
    
	/**
	 * Closes Database Connection
	 *
	 * @uses DB Database Object
	 *
	 * @return nothing
	 */
    private static function closeDB() {
        $db = new DB();
        $db->dbClose();
    }
    
	/**
	 * Returns Array of Contract Lengths  
	 *
	 * @return array|object
	 */
    public static function contractLength() {
        /*  This function exists to allow the contract lengths to be pulled from a data source, as none exists
         *  it is being set as an array as there is no data source
         */
        $contract_times = array(12,36);
        return $contract_times;
    }
     
	 /*
	 * Returns a json or xml string based on the $type parameter
	 * 
	 * @uses self::curlRequest, self::baseURL
	 *
	 * @param string $postcode
	 * @param string $type Optional (pass in json or xml as options), default is false.
	 * @return array|object or json|string Type returned depends on $type value.
	 */
    public static function runRequest($postcode, $type=false) {
        /*  This function is used to grab the Curl request from the postcode sent in the form, 
		 * 	then simply send the request back Javascript for processing. It also cleans the 
		 * 	postcode of any whitespace.
		 */
        if ($type) {
            $req = self::baseURL.str_replace(" ", "", $postcode)."&return=".$type;
        } else {
            $req = self::baseURL.str_replace(" ", "", $postcode);
        }
        $data = self::curlRequest($req);
        return $data;
    }
    
	/*
	 * Returns a string based number that is the ID of the record just entered
	 * 
	 * @uses self::connectDB, DB
	 *
	 * @param array $data, The array must be correctly formatted to be dumped into the database
	 * @return string|object
	 */
    public static function storeUser($data) {
    	/*	This function is used to store the ethernet_quotes data into the table */
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
    
	/*
	 * Returns Nothins
	 * 
	 * @uses self::connectDB, DB
	 *
	 * @param array $data, The array must be correctly formatted to be dumped into the database
	 * @return nothing
	 */
    private static function storeQuote() {
        /*	This function takes each quote given to it and processes it into the database
		 * 	for storing and manipulation
		 */
    }

/*
	 * Returns Nothins
	 * 
	 * @uses self::connectDB, DB
	 *
	 * @param array $data, The array must be correctly formatted to be dumped into the database
	 * @return nothing
	 */
    public static function processQuotes($jsonData) {
    	/*	This function will take each request and prep it for data processing */
        var_dump($jsonData);
    }
	/*
	 * Returns String object from the CuRL Request URL that is passed to it
	 * 
	 * @uses nothing
	 *
	 * @param string $urlData, must be a correctly formatted and live URL
	 * @param array $options, must be a correctly formatted associative array of CuRL Options and values
	 * @return string|object, A String of whatever data the curl request is asked to provide
	 */
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
