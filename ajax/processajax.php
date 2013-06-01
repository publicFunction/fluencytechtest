<?php
require_once('../settings.php');
require_once('../class/class.database.php');
require_once('../class/class.ft.php');

$action = $_POST['action'];

switch($action) {
    case "processQuote":
        echo Fluency::runRequest($_POST['postcode'], $_POST['request_type']);
        break;
    case "storeUser":
        echo Fluency::storeUser($_POST);
        break;
    case "createQuote":
        
        break;
    default:
        echo "REQUEST STUFF";
        break;
}

?>