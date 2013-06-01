<?php
require_once('../settings.php');
require_once('../class/class.database.php');
require_once('../class/class.ft.php');

$action = $_POST['action'];

switch($action) {
    case "processQuote":
        Fluency::runRequest($_POST['postcode'], $_POST['request_type']);
        break;
    case "storeUser":
        Fluency::storeUser($_POST);
        break;
    case "createQuote":
        Fluency::processQuote($_POST);
        break;
    case "deleteQuote":
        Fluency::deleteQuote($_POST['quote']);
        break;
    default:
        echo "REQUEST STUFF";
        break;
}

?>