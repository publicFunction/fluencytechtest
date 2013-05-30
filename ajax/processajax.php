<?php
require_once('../settings.php');
require_once('../class/class.database.php');
require_once('../class/class.ft.php');

$action = $_REQUEST['action'];

switch($action) {
    case "processQuote":
        echo Fluency::runRequest($_POST['postcode'], $_POST['request_type']);
        break;
    case "storeQuote":
        echo Fluency::storeUser($_POST);
        break;
    case "createQuote":
        
        break;
    default:
        echo "REQUEST STUFF";
        break;
}

?>